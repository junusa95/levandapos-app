<?php

namespace App\Http\Controllers;

use DB;
use Session;
use App\Shop;
use App\User;
use App\Store;
use App\NewStock;
use App\Product;
use App\Transfer;
use App\ProductCategory;
use App\ProductCategoryGroup;
use App\Measurement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Log;

class TransferController extends Controller
{

    public function transfer_form($who,$sid) {
        $data['users'] = User::where('company_id',Auth::user()->company_id)->where('status','!=','deleted')->get();
        if ($who == 'store-master') { // this is migrated to storeController
            $store = DB::connection('tenant')->table('user_stores')->where('user_id',Auth::user()->id)->where('store_id',$sid)->first();
            if ($store) {
                $data['shops'] = Shop::where('company_id',Auth::user()->company_id)->get();
                $data['stores'] = Store::where('id','!=',$sid)->where('company_id',Auth::user()->company_id)->get();
                $data['store'] = Store::where('id',$sid)->where('company_id',Auth::user()->company_id)->first();
                $data['products'] = $data['store']->products()->get();
                return view('store-master.transfer-stock',compact('data'));
            } else {
                return redirect()->back()->with('error','Sorry! It seems like you dont have permission in this store.');
            }
        }
        if ($who == 'cashier') {
            $shop = DB::connection('tenant')->table('user_shops')->where('user_id',Auth::user()->id)->where('shop_id',$sid)->where('who','cashier')->first();
            if ($shop) {
                $data['shops'] = Shop::where('id','!=',$sid)->where('company_id',Auth::user()->company_id)->get();
                $data['stores'] = Store::where('company_id',Auth::user()->company_id)->get();
                $data['shop'] = Shop::where('id',$sid)->where('company_id',Auth::user()->company_id)->first();
                $data['products'] = $data['shop']->products()->get();
                return view('cashier.transfer-stock',compact('data'));
            } else {
                return redirect()->back()->with('error','Sorry! It seems like you dont have permission in this shop.');
            }
        }        
    }

    public function shosto_products($from,$fromid,$dest,$destid) {
        // check if he want to change the destination
        if ($from == 'ceo') {
            $item = NewStock::where('user_id',Auth::user()->id)->where('company_id',Auth::user()->company_id)->where('status','request')->first();
            if ($item) {
                if ($dest == 'store') {
                    NewStock::where('user_id',Auth::user()->id)->where('company_id',Auth::user()->company_id)->where('status','request')->update(['shop_id'=>null,'store_id'=>$destid]);
                }
                if ($dest == 'shop') {
                    NewStock::where('user_id',Auth::user()->id)->where('company_id',Auth::user()->company_id)->where('status','request')->update(['shop_id'=>$destid,'store_id'=>null]);
                }
                // $remove = NewStock::where('user_id',Auth::user()->id)->where('company_id',Auth::user()->company_id)->where('status','request')->update(['shop_id'=>null,'store_id'=>null]);
                // if ($remove) {
                // }
            }
        } else {
            $check = Transfer::where('sender_id',Auth::user()->id)->where('company_id',Auth::user()->company_id)->where('from',$from)->where('from_id',$fromid)->whereIn('status',['draft','edit'])->first();
            if ($check) {
                // there is existing cart
                if ($check->destination != $dest || $check->destination_id != $destid) {
                    return response()->json(['error'=>'By changing the destination, all the items on the cart will be cleared.']);
                }
            } 
        }
    }

    public function transfers($who,$sid) {
        if ($who == 'store-master') { // this is migrated to storeController
            $data['store'] = Store::where('id',$sid)->where('company_id',Auth::user()->company_id)->first();
            return view('store-master.transfers',compact('data'));
        }
        if ($who == 'cashier') {
            $data['shop'] = Shop::where('id',$sid)->where('company_id',Auth::user()->company_id)->first();
            return view('cashier.transfers',compact('data'));
        }
    }

    public function submit_transfer(Request $request) {
        // check if the item exist in cart 
        $transferno = $request->transferno;
        $transferval = $request->transferval;
        if ($transferno != 'null') {
            $status = 'edit';
        } else {
            $status = 'draft';
            $transferno = NULL;
            $transferval = NULL;
        }
        $item = Transfer::where('sender_id',Auth::user()->id)->where('company_id',Auth::user()->company_id)->where('from_id',$request->fromid)->where('from',$request->from)->where('product_id',$request->product)->where('status',$status)->first();
        if ($item) {
            return response()->json(['error'=>'This item is already in cart','id'=>$item->id]);
        } else {
            $insert = Transfer::create([
                'transfer_no'=>$transferno,'transfer_val'=>$transferval,
                'from'=>$request->from,'destination'=>$request->whereto,
                'from_id'=>$request->fromid,'destination_id'=>$request->shostoval,
                'product_id'=>$request->product,'quantity'=>$request->quantity,'company_id'=>Auth::user()->company_id,
                'sender_id'=>Auth::user()->id,'shipper_id'=>$request->shipper,'status'=>$status
                ]);
            if ($insert) {
                $pname = Product::find($request->product)->name;
                return response()->json(['row'=>$insert,'pname'=>$pname]);
            } else {
                return response()->json(['error'=>'Oops! Something wrong, fail to add.']);
            }      
        }
    }

    public function submit_transfer_cart($from,$sid,$tno){
        $status = 'draft';
        if ($tno != 'null') {
            $transfer = Transfer::where('transfer_no',$tno)->where('company_id',Auth::user()->company_id)->first();
            $status = 'edit';
        }
        $check = Transfer::where('status','!=','draft')->where('company_id',Auth::user()->company_id)->groupBy('transfer_val')->orderBy('transfer_val','desc')->first();
        $rows = Transfer::where('sender_id',Auth::user()->id)->where('company_id',Auth::user()->company_id)->where('from_id',$sid)->where('from',$from)->where('status',$status)->get();
        if ($tno != 'null') {
            $val = $transfer->transfer_val;
            $t_no = $transfer->transfer_no;
        } else {
            if ($check) {
                $val = ($check->transfer_val + 1);
                $val = "0".$val;
                $t_no = "TRN".Auth::user()->id.$val;
            } else {
                $val = "01";
                $t_no = "TRN".Auth::user()->id.$val;
            }
        }
        if ($rows->isNotEmpty()) {            
            // check for minimum stock level 
            if(Auth::user()->company->isCheckingStockLevel()){ $min_stock = "yes"; } else { $min_stock = "no"; }
            foreach($rows as $row) {
                $sent_at = date('Y-m-d H:i:s');
                if ($row->from == 'store') {
                    $q = DB::connection('tenant')->table('store_products')->where('store_id',$row->from_id)->where('product_id',$row->product_id)->where('active','yes');
                    $ssid = $row->fstore->id;
                }
                if ($row->from == 'shop') {
                    $q = DB::connection('tenant')->table('shop_products')->where('shop_id',$row->from_id)->where('product_id',$row->product_id)->where('active','yes');
                    $ssid = $row->fshop->id;
                }
                if ($q->first()) {
                    $av_q = $q->first()->quantity;
                    $quantity = ($av_q - $row->quantity);
                    $q->update(['quantity'=>$quantity]);
                    $row->update(['transfer_no'=>$t_no,'transfer_val'=>$val,'sent_at'=>$sent_at,'status'=>'sent']);

                    Log::channel('custom')->info('PID: '.$row->product_id.', newQ = '.$quantity.' .. transferedQ = '.$row->quantity.' .. prevQ = '.$av_q);
                    
                    if($min_stock == "yes") {          
                        $pro = \App\Product::find($row->product_id);                  
                        if($pro->min_stock_level >= $quantity) {
                            ProductController::insertMSL($pro->id,$row->from,$ssid,$pro->min_stock_level);
                        } 
                    }
                }      
            }
            return response()->json(['success'=>'Success! Items are transfered from your store.']);
        }
    }

    public function pending_transfer($from,$sid) {
        $item = Transfer::where('sender_id',Auth::user()->id)->where('company_id',Auth::user()->company_id)->where('from_id',$sid)->where('from',$from)->whereIn('status',['draft','edit'])->first();
        if ($item) {
            $shipper = User::where('id',$item->shipper_id)->where('status','!=','deleted')->where('company_id',Auth::user()->company_id)->first();
            $data['items'] = Transfer::where('sender_id',Auth::user()->id)->where('company_id',Auth::user()->company_id)->where('from_id',$sid)->where('from',$from)->whereIn('status',['draft','edit'])->get();
            $view = view('partials.pending-transfer-cart',compact('data'))->render();
            return response()->json(['cart'=>$view,'item'=>$item,'shipper'=>$shipper]);
        }
    }

    public function get_transfers($from,$status,$date,$sid) {
        $view = '';
        $data['check'] = $status;
        $date = explode("~",$date);
        $fromdate = date("Y-m-d 00:00:00", strtotime($date[0]));
        $todate = date("Y-m-d 23:59:59", strtotime($date[1]));
        if ($status == "pending") { 
            $data['items'] = Transfer::where('destination',$from)->where('company_id',Auth::user()->company_id)->where('destination_id',$sid)->where('status','sent')->groupBy('transfer_no')->orderBy('updated_at','desc')->selectRaw('*, sum(quantity) as sumQ')->get();
            $data['items2'] = Transfer::where('from',$from)->where('company_id',Auth::user()->company_id)->where('from_id',$sid)->where('status','sent')->groupBy('transfer_no')->orderBy('updated_at','desc')->selectRaw('*, sum(quantity) as sumQ')->get();
            $view = view('partials.transfers',compact('data'))->render();
        }
        if ($status == 'received') {
            $data['items'] = Transfer::where('destination',$from)->where('company_id',Auth::user()->company_id)->where('destination_id',$sid)->where('status','received')->whereBetween('received_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->groupBy('transfer_no')->orderBy('updated_at','desc')->selectRaw('*, sum(quantity) as sumQ')->get();
            $view = view('partials.transfers',compact('data'))->render();
        }
        if ($status == 'sent') {
            $data['items'] = Transfer::where('from',$from)->where('company_id',Auth::user()->company_id)->where('from_id',$sid)->whereNotIn('status',['draft','sent'])->whereBetween('sent_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->groupBy('transfer_no')->orderBy('updated_at','desc')->selectRaw('*, sum(quantity) as sumQ')->get();
            $view = view('partials.transfers',compact('data'))->render();
        }
        return response()->json(['view'=>$view]);
    }

    public function remove_transfer_row($id) {
        $delete = Transfer::where('id',$id)->where('company_id',Auth::user()->company_id)->delete();
        if ($delete) {
            return response()->json(['success'=>'removed','id'=>$id]);
        } else {
            return response()->json(['error'=>'Error! Something wrong. Failed to clear row.']);
        }
    }

    public function clear_transfer_cart($from,$sid) {
        $delete = Transfer::where('from',$from)->where('from_id',$sid)->where('company_id',Auth::user()->company_id)->where('sender_id',Auth::user()->id)->whereIn('status',['draft','edit'])->delete();
        if ($delete) {
            return response()->json(['success'=>'success']);
        }
    }

    public function transfer_items($tno,$sshop,$sid) {        
        $data['check'] = 'transfer-items';
        $data['sshop'] = $sshop;
        $data['sid'] = $sid;
        $data['transfer'] = Transfer::where('transfer_no',$tno)->where('company_id',Auth::user()->company_id)->first();
        $data['transfers'] = Transfer::where('transfer_no',$tno)->where('company_id',Auth::user()->company_id)->get();
        $view = view('partials.transfers',compact('data'))->render();
        return response()->json(['view'=>$view]);
    }

    public function transfer_report($time,$from,$sid) {
        $data['totalQty'] = 0;
        $transfers = array();
        if ($time == 'today') {
            $data['transfer'] = Transfer::where('from',$from)->where('company_id',Auth::user()->company_id)->where('from_id',$sid)->where('status','received')->whereDate('updated_at',Carbon::today())->get();
            if ($data['transfer']) {
                $qty = Transfer::where('from',$from)->where('company_id',Auth::user()->company_id)->where('from_id',$sid)->where('status','received')->whereDate('updated_at',Carbon::today())->sum('quantity');
                $qty2 = Transfer::where('destination',$from)->where('company_id',Auth::user()->company_id)->where('destination_id',$sid)->where('status','received')->whereDate('updated_at',Carbon::today())->sum('quantity');
                $data['totalQty'] = $qty + $qty2; // overall total quantity
                if ($from == 'store') {
                    $stores = Store::where('id','!=',$sid)->get();
                    if ($stores) {
                        foreach($stores as $store) {
                            // from other stores to this store 
                            $check  = Transfer::where('from','store')->where('company_id',Auth::user()->company_id)->where('from_id',$store->id)->where('destination','store')->where('destination_id',$sid)->where('status','received')->whereDate('updated_at',Carbon::today())->groupBy('from_id')->get();
                            $check2  = Transfer::where('from','store')->where('company_id',Auth::user()->company_id)->where('from_id',$sid)->where('destination','store')->where('destination_id',$store->id)->where('status','received')->whereDate('updated_at',Carbon::today())->groupBy('destination_id')->get();
                            if (!$check->isEmpty()) {
                                $transfers[] = $check;
                            }
                            if (!$check2->isEmpty()) {
                                $transfers[] = $check2;
                            }
                        }                
                    }
                }
                $view = view('partials.transfers_report',compact('transfers','time','from','sid'))->render();
                return response()->json(['data'=>$data,'view'=>$view]);
            } else {
                return response()->json(['error'=>'error']);
            }
        } elseif ($time == 'week') {
            $now = Carbon::now();
            $weekStartDate = $now->startOfWeek()->format('Y-m-d H:i:s');
            $weekEndDate = $now->endOfWeek()->format('Y-m-d H:i:s');
            $data['transfer'] = Transfer::where('from',$from)->where('company_id',Auth::user()->company_id)->where('from_id',$sid)->where('status','received')->whereBetween('updated_at',[$weekStartDate,$weekEndDate])->get();
            if ($data['transfer']) {
                $qty = Transfer::where('from',$from)->where('company_id',Auth::user()->company_id)->where('from_id',$sid)->where('status','received')->whereBetween('updated_at',[$weekStartDate,$weekEndDate])->sum('quantity');
                $qty2 = Transfer::where('destination',$from)->where('company_id',Auth::user()->company_id)->where('destination_id',$sid)->where('status','received')->whereBetween('updated_at',[$weekStartDate,$weekEndDate])->sum('quantity');
                $data['totalQty'] = $qty + $qty2; // overall total quantity
                if ($from == 'store') {
                    $stores = Store::where('id','!=',$sid)->where('company_id',Auth::user()->company_id)->get();
                    if ($stores) {
                        foreach($stores as $store) {
                            // from other stores to this store 
                            $check  = Transfer::where('from','store')->where('company_id',Auth::user()->company_id)->where('from_id',$store->id)->where('destination','store')->where('destination_id',$sid)->where('status','received')->whereBetween('updated_at',[$weekStartDate,$weekEndDate])->groupBy('from_id')->get();
                            $check2  = Transfer::where('from','store')->where('company_id',Auth::user()->company_id)->where('from_id',$sid)->where('destination','store')->where('destination_id',$store->id)->where('status','received')->whereBetween('updated_at',[$weekStartDate,$weekEndDate])->groupBy('destination_id')->get();
                            if (!$check->isEmpty()) {
                                $transfers[] = $check;
                            }
                            if (!$check2->isEmpty()) {
                                $transfers[] = $check2;
                            }
                        }                
                    }
                }
                $view = view('partials.transfers_report',compact('transfers','time','from','sid'))->render();
                return response()->json(['data3'=>$data,'view'=>$view]);
            } else {
                return response()->json(['error'=>'error']);
            }
        } elseif ($time == 'month') {
            $now = Carbon::now();
            $monthStartDate = $now->startOfMonth()->format('Y-m-d H:i:s');
            $monthEndDate = $now->endOfMonth()->format('Y-m-d H:i:s');
            $data['startMonth'] = date('d/m/Y', strtotime($monthStartDate));
            $data['endMonth'] = date('d/m/Y', strtotime($monthEndDate));
            $data['transfer'] = Transfer::where('from',$from)->where('company_id',Auth::user()->company_id)->where('from_id',$sid)->where('status','received')->whereBetween('updated_at',[$monthStartDate,$monthEndDate])->get();
            if ($data['transfer']) {
                $qty = Transfer::where('from',$from)->where('company_id',Auth::user()->company_id)->where('from_id',$sid)->where('status','received')->whereBetween('updated_at',[$monthStartDate,$monthEndDate])->sum('quantity');
                $qty2 = Transfer::where('destination',$from)->where('company_id',Auth::user()->company_id)->where('destination_id',$sid)->where('status','received')->whereBetween('updated_at',[$monthStartDate,$monthEndDate])->sum('quantity');
                $data['totalQty'] = $qty + $qty2; // overall total quantity
                if ($from == 'store') {
                    $stores = Store::where('id','!=',$sid)->where('company_id',Auth::user()->company_id)->get();
                    if ($stores) {
                        foreach($stores as $store) {
                            // from other stores to this store 
                            $check  = Transfer::where('from','store')->where('company_id',Auth::user()->company_id)->where('from_id',$store->id)->where('destination','store')->where('destination_id',$sid)->where('status','received')->whereBetween('updated_at',[$monthStartDate,$monthEndDate])->groupBy('from_id')->get();
                            $check2  = Transfer::where('from','store')->where('company_id',Auth::user()->company_id)->where('from_id',$sid)->where('destination','store')->where('destination_id',$store->id)->where('status','received')->whereBetween('updated_at',[$monthStartDate,$monthEndDate])->groupBy('destination_id')->get();
                            if (!$check->isEmpty()) {
                                $transfers[] = $check;
                            }
                            if (!$check2->isEmpty()) {
                                $transfers[] = $check2;
                            }
                        }                
                    }
                }
                $view = view('partials.transfers_report',compact('transfers','time','from','sid'))->render();
                return response()->json(['data5'=>$data,'view'=>$view]);
            } else {
                return response()->json(['error'=>'error']);
            }
        }
    }

    public static function quantity_transfered_individual($time,$from,$fromid,$dest,$destid) {
        if ($time == 'today') {
            return Transfer::where('from',$from)->where('company_id',Auth::user()->company_id)->where('from_id',$fromid)->where('destination',$dest)->where('destination_id',$destid)->where('status','received')->whereDate('updated_at',Carbon::today())->sum('quantity');
        } elseif ($time == 'week') {
            $now = Carbon::now();
            $weekStartDate = $now->startOfWeek()->format('Y-m-d H:i:s');
            $weekEndDate = $now->endOfWeek()->format('Y-m-d H:i:s');
            return Transfer::where('from',$from)->where('company_id',Auth::user()->company_id)->where('from_id',$fromid)->where('destination',$dest)->where('destination_id',$destid)->where('status','received')->whereBetween('updated_at',[$weekStartDate,$weekEndDate])->sum('quantity');
        } elseif ($time == 'month') {
            $now = Carbon::now();
            $monthStartDate = $now->startOfMonth()->format('Y-m-d H:i:s');
            $monthEndDate = $now->endOfMonth()->format('Y-m-d H:i:s');
            return Transfer::where('from',$from)->where('company_id',Auth::user()->company_id)->where('from_id',$fromid)->where('destination',$dest)->where('destination_id',$destid)->where('status','received')->whereBetween('updated_at',[$monthStartDate,$monthEndDate])->sum('quantity');
        }             
    }

    public function delete_transfer($tno) { 
        $check = Transfer::where('transfer_no',$tno)->where('company_id',Auth::user()->company_id)->where('sender_id',Auth::user()->id)->first();
        
            $rows = Transfer::where('transfer_no',$tno)->where('company_id',Auth::user()->company_id)->get();
            if ($rows->isNotEmpty()) {
                foreach($rows as $row) {
                    if ($row->status == "sent") {
                        $update = $row->update(['status'=>'deleted']);
                        if ($update) {
                            if ($row->from == 'store') {
                                $q = DB::connection('tenant')->table('store_products')->where('store_id',$row->from_id)->where('product_id',$row->product_id)->where('active','yes');
                                if ($q->first()) {
                                    $quantity = ($q->first()->quantity + $row->quantity);
                                    $q->update(['quantity'=>$quantity]);
                                } else {
                                    DB::connection('tenant')->table('store_products')->insert(['store_id' => $row->from_id, 'product_id'=>$row->product_id, 'quantity'=>$row->quantity, 'active'=>'yes', 'created_at' =>  \Carbon\Carbon::now(), 'updated_at' =>  \Carbon\Carbon::now()]);
                                }                   
                            }
                            if ($row->from == 'shop') {
                                $q = DB::connection('tenant')->table('shop_products')->where('shop_id',$row->from_id)->where('product_id',$row->product_id)->where('active','yes');
                                if ($q->first()) {
                                    $av_q = $q->first()->quantity;
                                    $quantity = ($av_q + $row->quantity);
                                    $q->update(['quantity'=>$quantity]);

                                    Log::channel('custom')->info('PID: '.$row->product_id.', newQ = '.$quantity.' .. deleted_TrsQ = '.$row->quantity.' .. prevQ = '.$av_q);
                                } else {
                                    DB::connection('tenant')->table('shop_products')->insert(['shop_id' => $row->from_id, 'product_id'=>$row->product_id, 'quantity'=>$row->quantity, 'active'=>'yes', 'created_at' =>  \Carbon\Carbon::now(), 'updated_at' =>  \Carbon\Carbon::now()]);

                                    Log::channel('custom')->info('PID: '.$row->product_id.', newQ = '.$row->quantity.' .. deleted_TrsQ = '.$row->quantity.' .. prevQ = 0');
                                }                 
                            }
                        }
                    }
                }
                return response()->json(['success'=>'success']);
            }
    }

    public function edit_transfer($tno) {
        $check = Transfer::where('transfer_no',$tno)->where('company_id',Auth::user()->company_id)->where('status','sent')->first();
        if ($check) {
            $check2 = Transfer::where('from',$check->from)->where('company_id',Auth::user()->company_id)->where('from_id',$check->from_id)->where('sender_id',Auth::user()->id)->where('status','edit')->first();
            if ($check2) {
                return response()->json(['error'=>'another transfer on editing']);
            }
            $check3 = Transfer::where('from',$check->from)->where('company_id',Auth::user()->company_id)->where('from_id',$check->from_id)->where('status','draft')->first();
            if ($check3) {
                Transfer::where('from',$check->from)->where('company_id',Auth::user()->company_id)->where('from_id',$check->from_id)->where('status','draft')->where('sender_id',Auth::user()->id)->delete();
            }
            $rows = Transfer::where('transfer_no',$tno)->where('company_id',Auth::user()->company_id)->get();
            if ($rows) {
                foreach($rows as $row) {
                    $update = $row->update(['status'=>'edit']);
                    if ($update) {
                        if ($row->from == 'store') {
                            $q = DB::connection('tenant')->table('store_products')->where('store_id',$row->from_id)->where('product_id',$row->product_id)->where('active','yes');
                            if ($q->first()) {
                                $quantity = ($q->first()->quantity + $row->quantity);
                                $q->update(['quantity'=>$quantity]);
                            } else {
                                DB::connection('tenant')->table('store_products')->insert(['store_id' => $row->from_id, 'product_id'=>$row->product_id, 'quantity'=>$row->quantity, 'active'=>'yes', 'created_at' =>  \Carbon\Carbon::now(), 'updated_at' =>  \Carbon\Carbon::now()]);
                            }                 
                        }
                        if ($row->from == 'shop') {
                            $q = DB::connection('tenant')->table('shop_products')->where('shop_id',$row->from_id)->where('product_id',$row->product_id)->where('active','yes');
                            if ($q->first()) {
                                $av_q = $q->first()->quantity;
                                $quantity = ($av_q + $row->quantity);
                                $q->update(['quantity'=>$quantity]);

                                Log::channel('custom')->info('PID: '.$row->product_id.', newQ = '.$quantity.' .. edited_TrsQ = '.$row->quantity.' .. prevQ = '.$av_q);
                            } else {
                                DB::connection('tenant')->table('shop_products')->insert(['shop_id' => $row->from_id, 'product_id'=>$row->product_id, 'quantity'=>$row->quantity, 'active'=>'yes', 'created_at' =>  \Carbon\Carbon::now(), 'updated_at' =>  \Carbon\Carbon::now()]);

                                Log::channel('custom')->info('PID: '.$row->product_id.', newQ = '.$row->quantity.' .. edited_TrsQ = '.$row->quantity.' .. prevQ = 0');
                            }                 
                        }
                    }
                }
                return response()->json(['status'=>'success']);
            }
        } else {
            return response()->json(['error'=>'Sorry! No transfer to edit.']);
        }
    }

}
