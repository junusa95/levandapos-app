<?php

namespace App\Http\Controllers;

use DB;
use Session;
use App\User;
use App\Store;
use App\NewStock;
use App\Shop;
use App\Product;
use App\Transfer;
use App\ReturnSoldItem;
use App\StockAdjustment;
use App\CustomerDebt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Log;

class StoreController extends Controller
{

    public function index() { 
        if (Session::get('role') == 'Store Master') {
            $data['stores'] = DB::connection('tenant')->table('user_stores')->where('user_id',Auth::user()->id)->where('who','store master')->get();
            
            return view('store-master.index',compact('data'));
        } else {
            $toprole = Auth::user()->roles()->orderBy('id','asc')->first();
            if (!$toprole) { //check if has assigned to any role
                return redirect('/home');
            } else {
                if ($toprole->name == "Store Master") { // chack if has store master role
                    Session::put('role','Store Master');
                    return redirect('/store-master');
                } else {
                    return redirect()->back()->with('error','Sorry! It seems like you dont have a store master role in this account.');
                }
            }         
        }     
    }
    
    public function index_bkp() { 
        if (Session::get('role') == 'Store Master') {
            return redirect('/store-master/'.Session::get('sid'));
        }
        $data['stores'] = DB::connection('tenant')->table('user_stores')->where('user_id',Auth::user()->id)->get();
        
            if (count($data['stores']) == 1) {
                $store = DB::connection('tenant')->table('user_stores')->where('user_id',Auth::user()->id)->first();
                return redirect('/store-master/'.$store->store_id);
            }
            return view('store-master.choose-store',compact('data'));             
    }

    public function stock_links($check,$check2) {
        if ($check == 'ceo') {
            Session::put('role','CEO');
            if ($check2 == "records") {
                $data['shops'] = Shop::where('company_id',Auth::user()->company_id)->get();
                $data['stores'] = Store::where('company_id',Auth::user()->company_id)->get();
                $data['pendingstock'] = NewStock::where('user_id',Auth::user()->id)->where('company_id',Auth::user()->company_id)->where('status','sent')->groupBy('shop_id')->groupBy('store_id')->get();
                return view('ceo.new-stock',compact('data'));
            }
            if ($check2 == "adjust") {
                $data['shops'] = Shop::where('company_id',Auth::user()->company_id)->get();
                $data['stores'] = Store::where('company_id',Auth::user()->company_id)->get();
                return view('ceo.adjust-stock',compact('data'));
            }
            if ($check2 == "taking") {
                $data['shops'] = Shop::where('company_id',Auth::user()->company_id)->get();
                $data['stores'] = Store::where('company_id',Auth::user()->company_id)->get();
                return view('ceo.stock-taking',compact('data'));
            }
            if ($check2 == "adjust-records") {
                $data['shops'] = Shop::where('company_id',Auth::user()->company_id)->get();
                $data['stores'] = Store::where('company_id',Auth::user()->company_id)->get();
                return view('ceo.adjustment-records',compact('data'));
            }
            if ($check2 == "staking-records") {
                $data['shops'] = Shop::where('company_id',Auth::user()->company_id)->get();
                $data['stores'] = Store::where('company_id',Auth::user()->company_id)->get();
                return view('ceo.stock-taking-records',compact('data'));
            }
        }
        if ($check == "business-owner") {
            Session::put('role','Business Owner');
            if ($check2 == "adjust-records") {
                $data['shops'] = Shop::where('company_id',Auth::user()->company_id)->get();
                $data['stores'] = Store::where('company_id',Auth::user()->company_id)->get();
                return view('ceo.adjustment-records',compact('data'));
            }
            if ($check2 == "staking-records") {
                $data['shops'] = Shop::where('company_id',Auth::user()->company_id)->get();
                $data['stores'] = Store::where('company_id',Auth::user()->company_id)->get();
                return view('ceo.stock-taking-records',compact('data'));
            }
        }
    }

    public function store(Request $request) {
        $store = Store::create(['name' => $request->name, 'location' => $request->location, 'company_id'=>Auth::user()->company_id, 'user_id' => Auth::user()->id]);
        if (!$store) {
            return response()->json(['error'=>'Error! Store not created.']);
        } 
        if ($request->user) {
            DB::connection('tenant')->table('user_stores')->insert(['user_id' => $request->user, 'store_id'=>$store->id, 'who'=>'store master']);
            $check = DB::table('user_roles')->where('user_id',$request->user)->where('role_id',8)->get();
            if ($check->isEmpty()) {
                DB::table('user_roles')->insert(['user_id' => $request->user, 'role_id'=>8]);
            }
        }
        return response()->json(['success'=>'Success! Store created successfully.']);
    }
    
    public function instore($store_id) {
        // check if ceo / BU .. display all stores else display responsible stores
        if (Auth::user()->isCEOorAdminorBusinessOwner()) {
            $data['isCEO'] = "yes";
            $data['store'] = Store::where('id',$store_id)->where('company_id',Auth::user()->company_id)->first();
            $data['stores'] = Store::where('company_id',Auth::user()->company_id)->where('id','!=',$store_id)->get();
            $data['users'] = User::where('company_id',Auth::user()->company_id)->get();
        } else {
            if(Auth::user()->isStoreMaster()){
                $data['isCEO'] = "no";
                $data['store'] = Store::where('id',$store_id)->where('company_id',Auth::user()->company_id)->first();
                $data['users'] = User::where('id','!=',1)->where('status','!=','deleted')->where('company_id',Auth::user()->company_id)->get();
                $data['stores'] = DB::connection('tenant')->table('stores')->join('user_stores','user_stores.store_id','stores.id')->where('user_stores.user_id',Auth::user()->id)->where('stores.id','!=',$store_id)->where('user_stores.who','store master')->select('*','stores.id AS sid')->get();
            } else {
                return redirect()->back()->with('error','Sorry! It seems like you dont have permission in this store.');
            }            
        }
        
        return view('store',compact('data'));
    }

    public function update(Request $request) {
        $store = Store::where('id',$request->store)->where('company_id',Auth::user()->company_id)->first();
        if ($store) {
            $update = $store->update(['name' => $request->name, 'location' => $request->location, 'user_id' => Auth::user()->id]);
            if ($update) {
                return response()->json(['success'=>'Success! Store updated successfully.']);
            }
        }
        return response()->json(['error'=>'Error! Something went wrong. Please try again.']);
    }

    public function stores() {
        if(Auth::user()->isCEOorAdminorBusinessOwner()) {
            $data['isCEO'] = "yes";
            $data['stores'] = Store::where('company_id',Auth::user()->company_id)->get();
            $data['users'] = User::where('id','!=',1)->where('status','!=','deleted')->where('company_id',Auth::user()->company_id)->get();
        } else {
            if(Auth::user()->isStoreMaster()){
                $data['isCEO'] = "no";
                $data['users'] = User::where('id','!=',1)->where('status','!=','deleted')->where('company_id',Auth::user()->company_id)->get();
                $data['stores'] = DB::connection('tenant')->table('stores')->join('user_stores','user_stores.store_id','stores.id')->where('user_stores.user_id',Auth::user()->id)->where('user_stores.who','store master')->select('*','stores.id AS sid')->get();
            } else {
                return redirect()->back()->with('error','Sorry! It seems like you dont have permission in view shops.');
            }
        }
        return view('stores',compact('data'));
    }

    public function untouch_store_master(Request $request) {
        $delete = DB::connection('tenant')->table('user_stores')->where('user_id',$request->uid)->where('store_id',$request->store)->where('who','store master')->delete();
        if ($delete) {
            $check = DB::connection('tenant')->table('user_stores')->where('user_id',$request->uid)->where('who','store master')->get();
            if ($check->isEmpty()) {
                DB::table('user_roles')->where('user_id',$request->uid)->where('role_id',8)->delete();
            }
            return response()->json(['success'=>'Done! The user is no longer store master in this store.', 'store'=>$request->store, 'id'=>$request->uid]);
        }
        return response()->json(['error'=>'Error! Something went wrong. Please try again.']);
    }

    public static function storeById($sid) {
        return Store::where('id',$sid)->where('company_id',Auth::user()->company_id)->first();
    }

    public function get_user_store() {
        $stores = '';
        $count = DB::connection('tenant')->table('user_stores')->where('user_id',Auth::user()->id)->get()->count('id');
        if ($count > 1) {
            $stores = DB::connection('tenant')->table('stores')->join('user_stores','user_stores.store_id','stores.id')->where('stores.company_id',Auth::user()->company_id)->where('user_stores.user_id',Auth::user()->id)->get();
        } elseif ($count == 1) {
            $stores = DB::connection('tenant')->table('user_stores')->where('user_id',Auth::user()->id)->first();
        }
        return response()->json(['total'=>$count,'stores'=>$stores]);
    }

    public function check($sid,$check) {
        $data['store'] = Store::where('id',$sid)->where('company_id',Auth::user()->company_id)->first();
        if ($check == "stock") {
            $store = DB::connection('tenant')->table('user_stores')->where('user_id',Auth::user()->id)->where('store_id',$sid)->first();
            if ($store) {
                $data['shops'] = Shop::where('company_id',Auth::user()->company_id)->get(); 
                $data['stores'] = Store::where('id','!=',$sid)->where('company_id',Auth::user()->company_id)->get();
                $data['otherroles'] = Auth::user()->roles()->where('name','!=','Store Master')->get();
                $data['pendingstock'] = NewStock::where('store_id',$sid)->where('company_id',Auth::user()->company_id)->where('status','sent')->get();
                return view('store-master.stock',compact('data'));
            } else {
                return redirect()->back()->with('error','Sorry! It seems like you dont have permission in this store.');
            }
        }
        if ($check == "products") {
            $data['products'] = $data['store']->products()->orderBy('products.name')->get();
            return view('store-master.products',compact('data'));
        }
        if ($check == "transfer-form") {
            $store = DB::connection('tenant')->table('user_stores')->where('user_id',Auth::user()->id)->where('store_id',$sid)->first();
            if ($store) {
                $data['users'] = User::where('company_id',Auth::user()->company_id)->where('status','!=','deleted')->get();
                $data['shops'] = Shop::where('company_id',Auth::user()->company_id)->get(); 
                $data['stores'] = Store::where('id','!=',$sid)->where('company_id',Auth::user()->company_id)->get();
                $data['store'] = Store::where('id',$sid)->where('company_id',Auth::user()->company_id)->first();
                $data['products'] = $data['store']->products()->get();
                return view('store-master.transfer-stock',compact('data'));
            } else {
                return redirect()->back()->with('error','Sorry! It seems like you dont have permission in this store.');
            }
        }
        if ($check == "transfers") {
            $data['store'] = Store::where('id',$sid)->where('company_id',Auth::user()->company_id)->first();
            return view('store-master.transfers',compact('data'));
        }
    }

    public function add_stock($from,$from_id,$pid,$supplier_id,$whereto) {
        if ($from == 'store') {
            $shop_id = null;
            $store_id = $from_id;
            $status = 'draft';
        }
        if ($from == 'shop') {
            $store_id = null;
            $shop_id = $from_id;
            $status = 'draft';
        }
        if ($from == 'ceo') {
            if ($whereto == 'shop') {
                $store_id = null;
                $shop_id = $from_id;
            }
            if ($whereto == 'store') {
                $store_id = $from_id;
                $shop_id = null;
            }
            $status = 'request';
        }
        $product = Product::where('id',$pid)->where('company_id',Auth::user()->company_id)->first();
        
        $item = NewStock::where('user_id',Auth::user()->id)->where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->where('store_id',$store_id)->where('product_id',$pid)->where('status',$status)->first();
        if ($item) {
            return response()->json(['error1'=>'This item is already in cart','id'=>$item->id]);
        } else {
            $insert = NewStock::create([
                'product_id'=>$pid,'shop_id'=>$shop_id,'store_id'=>$store_id,
                'added_quantity'=>1,'company_id'=>Auth::user()->company_id,
                'user_id'=>Auth::user()->id,'status'=>$status
                ]);
            if ($insert) {
                $data['id'] = $insert->id;
                $data['qty'] = $insert->added_quantity;
                $data['quantity'] = NewStock::where('user_id',Auth::user()->id)->where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->where('store_id',$store_id)->where('status',$status)->sum('added_quantity');

                return response()->json(['pname'=>$product->name,'shopro'=>$product->shopProductRelation($shop_id),'data'=>$data]);
            } else {
                return response()->json(['error'=>'Oops! Something wrong, fail to add.']);
            }      
        }
    }

    public function remove_row($check,$id) {
        if ($check == "stock") {
            $row = NewStock::where('id',$id)->where('company_id',Auth::user()->company_id)->first();
            if ($row) {
                $row->delete();
                $data['quantity'] = NewStock::where('user_id',Auth::user()->id)->where('company_id',Auth::user()->company_id)->where('shop_id',$row->shop_id)->where('store_id',$row->store_id)->where('status',$row->status)->sum('added_quantity');
                return response()->json(['success'=>'removed','id'=>$id,'data'=>$data]);
            } else {
                return response()->json(['error'=>'Error! Something wrong. Failed to clear row.']);
            }
        }
        if ($check == "returned-item") {
            $row = ReturnSoldItem::where('id',$id)->where('company_id',Auth::user()->company_id)->first();
            if ($row) {
                if ($row->status == "received") {
                    $q = DB::connection('tenant')->table('shop_products')->where('shop_id',$row->shop_id)->where('product_id',$row->product_id)->where('active','yes');
                    if ($q->first()) {
                        $currQ = $q->first()->quantity;
                        $quantity = ($currQ - $row->quantity);
                        $row->delete();
                        $q->update(['quantity'=>$quantity]);

                        Log::channel('custom')->info('PID: '.$row->product_id.', newQ = '.$quantity.' .. returned_SQ = '.$row->quantity.' .. prevQ = '.$currQ);
                    }                     
                } 
                if ($row->status == "draft") {
                    $q = DB::connection('tenant')->table('shop_products')->where('shop_id',$row->shop_id)->where('product_id',$row->product_id)->where('active','yes');
                    if ($q->first()) {
                        $currQ = $q->first()->quantity;
                        $quantity = ($currQ - $row->quantity);
                        $row->delete();
                        $q->update(['quantity'=>$quantity]);

                        Log::channel('custom')->info('PID: '.$row->product_id.', newQ = '.$quantity.' .. returned_SQ = '.$row->quantity.' .. prevQ = '.$currQ);
                    }                     
                } 
                $data['quantity'] = ReturnSoldItem::where('user_id',Auth::user()->id)->where('company_id',Auth::user()->company_id)->where('shop_id',$row->shop_id)->where('status','draft')->sum('quantity');
                return response()->json(['success'=>'removed','id'=>$id,'data'=>$data]);
                
            } else {
                return response()->json(['error'=>'Error! Something wrong. Failed to clear row.']);
            }
        }
    }

    public function update_quantity($status,$id,$qty) {
        if ($status == "stock") {
            if ($qty > 0) {
                $row = NewStock::where('id',$id)->where('company_id',Auth::user()->company_id)->first();
                if ($row) {
                    $update = $row->update(['added_quantity'=>$qty]);
                    $data['quantity'] = NewStock::where('user_id',Auth::user()->id)->where('company_id',Auth::user()->company_id)->where('shop_id',$row->shop_id)->where('store_id',$row->store_id)->where('status',$row->status)->sum('added_quantity');
                    return response()->json(['id'=>$id,'data'=>$data]);
                } 
            }
        }
        if ($status == "returned-item") {
            if ($qty > 0) {
                $row = ReturnSoldItem::where('id',$id)->where('company_id',Auth::user()->company_id)->first();
                if ($row) {
                    $update = $row->update(['quantity'=>$qty]);
                    $data['quantity'] = ReturnSoldItem::where('user_id',Auth::user()->id)->where('company_id',Auth::user()->company_id)->where('shop_id',$row->shop_id)->where('status','draft')->sum('quantity');
                    return response()->json(['data'=>$data]);
                } 
            }
        }
        // customer paid / us paying customer
        if ($status == "debt") {
            if ($qty > 0) {
                $row = CustomerDebt::where('id',$id)->where('company_id',Auth::user()->company_id)->first();                
                if ($row) {
                    // $qty = amount paid 
                    $data['id'] = $row->id;
                    $data['new_paid'] = $qty;
                    $data['old_debt'] = $row->debt_amount;
                    $data['new_debt'] = $new_debt = $row->stock_value - $qty;
                    if ($row->status == "lend money" || $row->status == "refund" || $row->status == "pay debt") {
                        $data['new_debt'] = $new_debt = $qty;
                        $qty = null;
                    }
                    $row->update(['debt_amount'=>$new_debt,'amount_paid'=>$qty,'user_id'=>Auth::user()->id]);
                    return response()->json(['data'=>$data]);
                }
            }
        }
    }

    public function get_new_stock($check,$from,$sid) {
        $output = array();
        $totalStQ = 0;
        if ($from == 'store') {
            $shop_id = null;
            $store_id = $sid;
        }
        if ($from == 'shop') {
            $store_id = null;
            $shop_id = $sid;
        }
        if ($check == "pending") {
            $items = NewStock::where('user_id',Auth::user()->id)->where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->where('store_id',$store_id)->where('status','draft')->get();
            if ($items->isNotEmpty()) {
                foreach($items as $value) {
                    $totalStQ = $totalStQ + $value->added_quantity;                
                    $output[] = '<tr class="str-'.$value->id.'"><td>'.$value->product->name.'</td>'
                        .'<td><input type="number" class="form-control form-control-sm st-quantity" placeholder="Q" name="quantity" value="'.sprintf('%g',$value->added_quantity).'" step="0.01" sid="'.$value->id.'" style="width:80px"></td>'
                        .'<td><span class="p-1 text-danger remove-str" val="'.$value->id.'" style="cursor: pointer;"><i class="fa fa-times"></i></span></td></tr>';
                }
            } else {
                $output[] = '<tr class="empty-row"><td colspan="3" align="center"><i>-- No items --</i></td></tr>';
            }
            return response()->json(['items'=>$output,'totalStQ'=>$totalStQ]);
        } 

        if ($check == "received") {
            $status = $sender = $receiver = "";
            $items = NewStock::where('shop_id',$shop_id)->where('company_id',Auth::user()->company_id)->where('store_id',$store_id)->where('status','updated')->orderBy('id','desc')->limit(25)->get();
            if ($items->isNotEmpty()) {
                foreach($items as $value) {    
                    if ($value->status == "updated") {
                         $status = "Received";
                    }     
                    if ($value->sender) {
                        $sender = $value->sender->name;
                    }
                    if ($value->receiver) {
                        $receiver = $value->receiver->name;
                    }
                    $output[] = '<tr><td>'.$value->product->name.'</td>'
                        .'<td>'.sprintf('%g',$value->added_quantity).'</td>'
                        .'<td><span class="badge badge-success">'.$status.'</span></td>'
                        .'<td class="table-details"><b>Added by: </b>'.$sender.'<br><b>Added at: </b>'.$value->sent_at.'<br><b>Received by: </b>'.$receiver.'<br><b>Received at: </b>'.$value->received_at.'</td>'
                        .'</tr>';
                    $status = $sender = $receiver = "";
                }
            } else {
                $output[] = '<tr class="empty-row"><td colspan="7" align="center"><i>-- No items --</i></td></tr>';
            }
            return response()->json(['items'=>$output]);
        }
    }

    public function add_new_stock(Request $request) {
        if ($request->from == 'store') {
            $shop_id = null;
            $store_id = $request->storeid; 
            $status = "draft";         
            $newStatus = "updated";
        }
        if ($request->from == 'shop') {
            $store_id = null;
            $shop_id = $request->shopid;
            $status = "draft";
            $newStatus = "updated";
        }
        if ($request->from == 'ceo') {
            $item = NewStock::where('user_id',Auth::user()->id)->where('company_id',Auth::user()->company_id)->where('status','request')->first();
            if ($item) {
                $store_id = $item->store_id;
                $shop_id = $item->shop_id;
                $status = "request";
                if ($request->approvalRequired == "yes") {
                    $newStatus = "sent";
                } else {
                    $newStatus = "updated";
                }         
            } else {
                return response()->json(['error'=>'Error! Please select items/products first.']);
            }   
        }
        $items = NewStock::where('user_id',Auth::user()->id)->where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->where('store_id',$store_id)->where('status',$status)->get();
        $sent_at = date('Y-m-d H:i:s');
        if ($items->isNotEmpty()) {
            foreach($items as $value) {
                if ($value->shop_id == null) {
                    $pro = \DB::connection('tenant')->table('store_products')->where('store_id',$store_id)->where('product_id',$value->product_id)->where('active','yes');
                } else {
                    $pro = \DB::connection('tenant')->table('shop_products')->where('shop_id',$shop_id)->where('product_id',$value->product_id)->where('active','yes');
                }
                
                if ($request->from == "ceo" && $newStatus == "sent") {
                    $update = $value->update(['status'=>$newStatus,"sent_at"=>$sent_at]);
                } else {
                    if ($pro->first()) {
                        $av_qty = $pro->first()->quantity;
                        $new_qty = $av_qty + $value->added_quantity;
                        $update = $value->update(['available_quantity'=>$av_qty,'new_quantity'=>$new_qty,'status'=>$newStatus,"sent_at"=>$sent_at,'received_by'=>Auth::user()->id,'received_at'=>$sent_at]);
                        if($update) {
                            $pro->update(['quantity'=>$new_qty]);

                            Log::channel('custom')->info('PID: '.$value->product_id.', newQ = '.$new_qty.' .. newStockQ = '.$value->added_quantity.' .. prevQ = '.$av_qty);
                        }
                    } else {
                        if ($value->shop_id == null && $value->store_id != null) {
                            $add = DB::connection('tenant')->table('store_products')->insert(['store_id' => $value->store_id, 'product_id'=>$value->product_id, 'quantity'=>$value->added_quantity, 'active'=>'yes', 'created_at' =>  \Carbon\Carbon::now(), 'updated_at' =>  \Carbon\Carbon::now()]);
                            if ($add) {
                                $value->update(['available_quantity'=>0,'new_quantity'=>$value->added_quantity,'status'=>$newStatus,"sent_at"=>$sent_at,'received_by'=>Auth::user()->id,'received_at'=>$sent_at]);
                            }
                        } 
                        if ($value->store_id == null && $value->shop_id != null) {
                            $add = DB::connection('tenant')->table('shop_products')->insert(['shop_id' => $value->shop_id, 'product_id'=>$value->product_id, 'quantity'=>$value->added_quantity, 'active'=>'yes', 'created_at' =>  \Carbon\Carbon::now(), 'updated_at' =>  \Carbon\Carbon::now()]);
                            if ($add) {

                                Log::channel('custom')->info('PID: '.$value->product_id.', newQ = '.$value->added_quantity.' .. newStockQ = '.$value->added_quantity.' .. prevQ = 0');

                                $value->update(['available_quantity'=>0,'new_quantity'=>$value->added_quantity,'status'=>$newStatus,"sent_at"=>$sent_at,'received_by'=>Auth::user()->id,'received_at'=>$sent_at]);
                            }
                        }
                    }
                }
            }
        }
        return response()->json(['success'=>'Success! New stock has been added successfully.']);
    }

    public function adjust_stock($check3,$check,$check2) {
        $output = array();
        if ($check3 == "adjust") {
            if ($check == "shop") {
                $rows = \DB::connection('tenant')->table('shop_products')->join('products','products.id','shop_products.product_id')->where('shop_products.shop_id',$check2)->where('shop_products.active','yes')->select('*','shop_products.id as pid')->orderBy('products.name')->get();
            }
            if ($check == "store") {
                $rows = \DB::connection('tenant')->table('store_products')->join('products','products.id','store_products.product_id')->where('store_products.store_id',$check2)->where('store_products.active','yes')->select('*','store_products.id as pid')->orderBy('products.name')->get();
            }
            if ($rows->isNotEmpty()) {
                $num = 1;
                foreach($rows as $row) {
                    $output[] = "<tr><td>".$num."</td><td>".$row->name."</td><td class='aq-".$row->pid."'>".sprintf('%g',$row->quantity)."</td><td><input type='number' class='form-control form-control-sm q-".$row->pid."' name=''></td><td><input type='text' class='form-control form-control-sm d-".$row->pid."' name=''></td><td><button type='button' class='btn btn-info btn-sm update-stc u-".$row->pid."' status='".$check."' row='".$row->pid."'>Update</button></td></tr>";
                    $num++;
                }
            } else {
                $output[] = "<tr><td colspan='6' class='align-center'><i>-- No stock available here --</i></td></tr>";
            }
            return response()->json(['items'=>$output]);
        }
        if ($check3 == "records") {
            // count all adjustments
            if ($check == "all" && $check2 == "all") {
                $shops = StockAdjustment::where('from','shop')->where('company_id',Auth::user()->company_id)->where('status','stock adjustment')->groupBy('from_id')->get();
                if ($shops->isNotEmpty()) {
                    foreach($shops as $shop) {
                        $count = StockAdjustment::where('from','shop')->where('company_id',Auth::user()->company_id)->where('status','stock adjustment')->where('from_id',$shop->from_id)->get()->count();
                        $output[] = '<div class="col-lg-3 col-md-3 col-6 sa-block">'.
                                    '<div class="body xl-turquoise">'.
                                    '<span> <h5 class="titems">'.$count.'</h5> adjustments from <b>'.$shop->shop->name.'</b> shop</span>'.
                                    '</div></div>';
                    }
                }
                $stores = StockAdjustment::where('from','store')->where('company_id',Auth::user()->company_id)->where('status','stock adjustment')->groupBy('from_id')->get();
                if ($stores->isNotEmpty()) {
                    foreach($stores as $store) {
                        $count = StockAdjustment::where('from','store')->where('company_id',Auth::user()->company_id)->where('status','stock adjustment')->where('from_id',$store->from_id)->get()->count();
                        $output[] = '<div class="col-lg-3 col-md-3 col-6 sa-block">'.
                                    '<div class="body xl-turquoise">'.
                                    '<span> <h5 class="titems">'.$count.'</h5> adjustments from <b>'.$store->store->name.'</b> store</span>'.
                                    '</div></div>';
                    }
                }
                if ($shops->isEmpty() && $stores->isEmpty()) {
                    $output[] = '<div class="col-lg-3 col-md-3 col-6 sa-block">'.
                                    '<div class="body xl-turquoise">'.
                                    '<span><b>No adjustment has been done yet.</b></span>'.
                                    '</div></div>';
                }
                return response()->json(['items'=>$output]);
            }
            if ($check == "shop") {
                $rows = StockAdjustment::where('from','shop')->where('company_id',Auth::user()->company_id)->where('status','stock adjustment')->where('from_id',$check2)->orderBy('id','desc')->get();
            }
            if ($check == "store") {
                $rows = StockAdjustment::where('from','store')->where('company_id',Auth::user()->company_id)->where('status','stock adjustment')->where('from_id',$check2)->orderBy('id','desc')->get();
            }
            if ($rows->isNotEmpty()) {
                $num = 1;
                foreach($rows as $row) {
                    $output[] = "<tr><td>".$num."</td><td>".$row->product->name."</td><td>".sprintf('%g',$row->av_quantity)."</td><td>".sprintf('%g',$row->new_quantity)."</td><td>".$row->description."</td><td>".$row->user->name."</td><td>".date('d/m/Y',strtotime($row->created_at))."</td></tr>";
                    $num++;
                }
            } else {
                $output[] = "<tr><td colspan='7' class='align-center'><i>-- No adjustment records yet --</i></td></tr>";
            }
            return response()->json(['items'=>$output]);
        }
        if ($check3 == "taking") {
            if ($check == "shop") {
                $rows = \DB::connection('tenant')->table('shop_products')->join('products','products.id','shop_products.product_id')->where('shop_products.shop_id',$check2)->where('shop_products.active','yes')->select('*','shop_products.id as pid')->orderBy('products.name')->get();
            }
            if ($check == "store") {
                $rows = \DB::connection('tenant')->table('store_products')->join('products','products.id','store_products.product_id')->where('store_products.store_id',$check2)->where('store_products.active','yes')->select('*','store_products.id as pid')->orderBy('products.name')->get();
            }
            if ($rows->isNotEmpty()) {
                $num = 1;
                foreach($rows as $row) {
                    $output[] = "<tr><td>".$num."</td><td>".$row->name."</td><td class='aq-".$row->pid."'>".sprintf('%g',$row->quantity)."</td><td><input type='number' class='form-control form-control-sm qt-".$row->pid."' name=''></td><td><button type='button' class='btn btn-info btn-sm update-stt u-".$row->pid."' status='".$check."' row='".$row->pid."'>Update</button></td></tr>";
                    $num++;
                }
            } else {
                $output[] = "<tr><td colspan='6' class='align-center'><i>-- No stock available here --</i></td></tr>";
            }
            return response()->json(['items'=>$output]);
        }
        if ($check3 == "st-records") {
            $data['balance'] = 0;
            $data['increase'] = 0; $incQ = 0; $incA = 0;
            $data['decrease'] = 0; $decQ = 0; $decA = 0;
            $data['titems'] = 0;
            if ($check == "shop") {
                $rows = StockAdjustment::where('from','shop')->where('company_id',Auth::user()->company_id)->where('status','stock taking')->where('from_id',$check2)->orderBy('id','desc')->get();
            }
            if ($check == "store") {
                $rows = StockAdjustment::where('from','store')->where('company_id',Auth::user()->company_id)->where('status','stock taking')->where('from_id',$check2)->orderBy('id','desc')->get();
            }
            if ($rows->isNotEmpty()) {
                $num = 1;
                $data['titems'] = StockAdjustment::where('from',$check)->where('company_id',Auth::user()->company_id)->where('status','stock taking')->where('from_id',$check2)->get()->groupBy('product_id')->count();
                foreach($rows as $row) {
                    $item = Product::find($row->product_id);
                    $q = $row->new_quantity - $row->av_quantity;
                    if ($q == 0) {
                        $data['balance'] = $data['balance'] + 1;
                        $impact = "<b class='text-success'>Balance</b>";
                    } else {
                        if ($q < 0) {
                            // loss
                            $amount = ($q * $item->retail_price);
                            $decQ = $decQ + $q;
                            $decA = $decA + $amount;
                            $data['decrease'] = $decQ."Q = ".number_format($decA);
                            $impact = "<b class='text-danger'>Loss:</b> ".$q."Q = ".number_format($amount);
                        }
                        if ($q > 0) {
                            // ongezeko
                            $amount = $q * $item->retail_price;
                            $incQ = $incQ + $q;
                            $incA = $incA + $amount;
                            $data['increase'] = $incQ."Q = ".number_format($incA);
                            $impact = "<b class='text-primary'>Increase:</b> ".$q."Q = ".number_format($amount);
                        }
                    }
                    $output[] = "<tr><td>".$num."</td><td>".$row->product->name."</td><td>".sprintf('%g',$row->av_quantity)."</td><td>".sprintf('%g',$row->new_quantity)."</td><td>".$impact."</td><td>".$row->user->name."</td><td>".date('d/m/Y',strtotime($row->created_at))."</td></tr>";
                    $num++;
                }
            } else {
                $output[] = "<tr><td colspan='7' class='align-center'><i>-- No st. taking records yet --</i></td></tr>";
            }
            return response()->json(['items'=>$output,'data'=>$data]);
        }
    }

    public function update_a_s(Request $request) {    
        // check for minimum stock level 
        if(Auth::user()->company->isCheckingStockLevel()){ $min_stock = "yes"; } else { $min_stock = "no"; }  

        if ($request->status == "shop") {
            $row = \DB::connection('tenant')->table('shop_products')->where('id',$request->id)->where('active','yes');
            if ($row->first()) {
                $product_id = $row->first()->product_id;
                $currQ = $row->first()->quantity;
                $diffQ = $request->quantity - $currQ;
                $insert = StockAdjustment::create(['from'=>'shop','from_id'=>$row->first()->shop_id,'product_id'=>$product_id,'av_quantity'=>$currQ,'company_id'=>Auth::user()->company_id, 'new_quantity'=>$request->quantity,'status'=>'stock adjustment','description'=>$request->desc,'user_id'=>Auth::user()->id]);                
                if ($insert) {
                    $update = $row->update(['quantity'=>$request->quantity]);

                    Log::channel('custom')->info('PID: '.$product_id.', newQ = '.$request->quantity.' .. adjustment_2Q = '.$diffQ.' .. prevQ = '.$currQ);

                    if($min_stock == "yes") {          
                        $pro = \App\Product::find($row->first()->product_id);      
                        if($pro->min_stock_level >= $request->quantity) {
                            ProductController::insertMSL($pro->id,'shop',$row->first()->shop_id,$pro->min_stock_level);
                        } else {
                            $check = \App\Notification::where('shop_id',$row->first()->shop_id)->where('product_id',$pro->id)->first();
                            if($check) {
                                $check->update(['product_id'=>null]);
                            }
                        }
                    }
                }
            }
        }       
        if ($request->status == "store") {
            $row = \DB::connection('tenant')->table('store_products')->where('id',$request->id)->where('active','yes');
            if ($row->first()) {
                $insert = StockAdjustment::create(['from'=>'store','company_id'=>Auth::user()->company_id,'from_id'=>$row->first()->store_id,'product_id'=>$row->first()->product_id,'av_quantity'=>$row->first()->quantity,'new_quantity'=>$request->quantity,'status'=>'stock adjustment','description'=>$request->desc,'user_id'=>Auth::user()->id]);                
                if ($insert) {
                    $update = $row->update(['quantity'=>$request->quantity]);
                    
                    if($min_stock == "yes") {          
                        $pro = \App\Product::find($row->first()->product_id);          
                        if($pro->min_stock_level >= $request->quantity) {
                            ProductController::insertMSL($pro->id,'store',$row->first()->store_id,$pro->min_stock_level);
                        } else {
                            $check = \App\Notification::where('store_id',$row->first()->store_id)->where('product_id',$pro->id)->first();
                            if($check) {
                                $check->update(['product_id'=>null]);
                            }
                        }
                    }
                }
            }
        }
        return response()->json(['id'=>$request->id,'quantity'=>$request->quantity]);
    }

    public function update_s_t(Request $request) {        
        if ($request->status == "shop") {
            $row = \DB::connection('tenant')->table('shop_products')->where('id',$request->id)->where('active','yes');
            if ($row->first()) {
                $product_id = $row->first()->product_id;
                $currQ = $row->first()->quantity;
                $diffQ = $request->quantity - $row->first()->quantity;
                $insert = StockAdjustment::create(['from'=>'shop','company_id'=>Auth::user()->company_id,'from_id'=>$row->first()->shop_id,'product_id'=>$product_id,'av_quantity'=>$currQ,'new_quantity'=>$request->quantity,'status'=>'stock taking','user_id'=>Auth::user()->id]);            
                if ($insert) {
                    $update = \DB::connection('tenant')->table('shop_products')->where('id',$request->id)->update(['quantity'=>$request->quantity]);

                    Log::channel('custom')->info('PID: '.$product_id.', newQ = '.$request->quantity.' .. stakingQ = '.$diffQ.' .. prevQ = '.$currQ);
                }
            }
        }       
        if ($request->status == "store") {
            $row = \DB::connection('tenant')->table('store_products')->where('id',$request->id)->where('active','yes');
            if ($row->first()) {
                $insert = StockAdjustment::create(['from'=>'store','company_id'=>Auth::user()->company_id,'from_id'=>$row->first()->store_id,'product_id'=>$row->first()->product_id,'av_quantity'=>$row->first()->quantity,'new_quantity'=>$request->quantity,'status'=>'stock taking','user_id'=>Auth::user()->id]);            
                if ($insert) {
                    $update = $row->update(['quantity'=>$request->quantity]);
                }
            }
        }
        return response()->json(['id'=>$request->id,'quantity'=>$request->quantity]);
    }

}
