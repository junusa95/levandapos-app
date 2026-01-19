<?php

namespace App\Http\Controllers;

use DB;
use App\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Log;

class SupplierController extends Controller
{
    
    public function check_get_data($check, $conditions) {
        $data = array();
        if($check == "shop-suppliers") {
            $sid = $conditions;
            $data['shopstore'] = 'shop'; 
            $data['shop'] = \App\Shop::find($sid);
            $data['suppliers'] = Supplier::where('shop_id',$sid)->where('status','active')->limit(10)->get(); 
            $view = view('tabs.suppliers',compact('data'))->render();

            return response()->json(['status'=>'success','view'=>$view]); 
        }
        if ($check == "shop-suppliers-2") { // borrow status has been used on the data of 2024.. since 2025 i removed borrowing money
            $sid = $conditions;
            $suppliers = Supplier::query()->select([
                DB::raw('suppliers.id as sid, suppliers.name as sname, suppliers.location as slocation, SUM(CASE WHEN shop_store_suppliers.status = "deposit" THEN amount ELSE 0 END) as deposits, SUM(CASE WHEN shop_store_suppliers.status = "purchase" THEN total_buying ELSE 0 END) as purchases, SUM(CASE WHEN shop_store_suppliers.status = "borrow" THEN amount ELSE 0 END) as debts')
            ])
            ->leftJoin('shop_store_suppliers', function ($join) {
                $join->on('suppliers.id','=','shop_store_suppliers.supplier_id')->where('shop_store_suppliers.status','!=','deleted');
            })
            ->where('suppliers.status','active')
            ->where('suppliers.shop_id',$sid)
            ->groupBy('suppliers.id')->orderBy('suppliers.name')
            ->get();

            return response()->json(['suppliers'=>$suppliers]);
        }
        
        if($check == "store-suppliers") {
            $sid = $conditions;
            $data['shopstore'] = 'store';
            $data['store'] = \App\Store::find($sid);
            $data['suppliers'] = Supplier::where('store_id',$sid)->where('status','active')->limit(10)->get(); 
            $view = view('tabs.suppliers-store',compact('data'))->render();

            return response()->json(['status'=>'success','view'=>$view]); 
        }
        if ($check == "store-suppliers-2") { // borrow status has been used on the data of 2024.. since 2025 i removed borrowing money
            $sid = $conditions;
            $suppliers = Supplier::query()->select([
                DB::raw('suppliers.id as sid, suppliers.name as sname, suppliers.location as slocation, SUM(CASE WHEN shop_store_suppliers.status = "deposit" THEN amount ELSE 0 END) as deposits, SUM(CASE WHEN shop_store_suppliers.status = "purchase" THEN total_buying ELSE 0 END) as purchases, SUM(CASE WHEN shop_store_suppliers.status = "borrow" THEN amount ELSE 0 END) as debts')
            ])
            ->leftJoin('shop_store_suppliers', function ($join) {
                $join->on('suppliers.id','=','shop_store_suppliers.supplier_id')->where('shop_store_suppliers.status','!=','deleted');
            })
            ->where('suppliers.status','active')
            ->where('suppliers.store_id',$sid)
            ->groupBy('suppliers.id')->orderBy('suppliers.name')
            ->get();

            return response()->json(['suppliers'=>$suppliers]);
        }

        if($check == "get-shop-supplier") {
            $con = explode("~",$conditions);
            $shopid = $con[0];
            $suppid = $con[1]; 
            
            $data['shop'] = \App\Shop::where('id',$shopid)->where('company_id',Auth::user()->company_id)->first();
            $data['suppliers'] = Supplier::where('shop_id',$shopid)->where('status','active')->get();
            $data['supplier'] = Supplier::where('id',$suppid)->where('status','active')->where('shop_id', $shopid)->first();
            if ($data['supplier']) {
                $view = view('tabs.supplier',compact('data'))->render();
                return response()->json(['view'=>$view]);
            }
        }
        if($check == "get-store-supplier") {
            $con = explode("~",$conditions);
            $storeid = $con[0];
            $suppid = $con[1]; 
            
            $data['store'] = \App\Store::where('id',$storeid)->where('company_id',Auth::user()->company_id)->first();
            $data['suppliers'] = Supplier::where('store_id',$storeid)->where('status','active')->get();
            $data['supplier'] = Supplier::where('id',$suppid)->where('status','active')->where('store_id', $storeid)->first();
            if ($data['supplier']) {
                $view = view('tabs.supplier-store',compact('data'))->render();
                return response()->json(['view'=>$view]);
            }
        }

        if($check == "get-supplier-details") {
            $sid = $conditions;
            $details = "";
            $supplier = Supplier::find($sid);
            if($supplier) {
                $details = '<h5>'.$supplier->name.'</h5><div>'.$supplier->phone.'</div><div style="margin-top: -2px;"><small>'.$supplier->location.'</small></div>'.
                            '<div class="supp-action">'.
                                '<button class="btn btn-outline-warning edit-supplier-btn" sid="'.$supplier->id.'" sname="'.$supplier->name.'" sphone="'.$supplier->phone.'" slocation="'.$supplier->location.'"><i class="fa fa-pencil"></i></button>'.
                                '<button class="btn btn-outline-danger"><i class="fa fa-trash"></i></button></div>';
            }
            return response()->json(['details'=>$details]);
        }
        
        if($check == "get-purchases-deposits") {
            $con = explode("~",$conditions);
            $sid = $con[0];
            $suppid = $con[1]; 
            $from2 = $con[2]; 
            $details = array();
            if($from2 == "shop") {
                $records = \App\ShopStoreSupplier::where('shop_id',$sid)->where('supplier_id',$suppid)->groupBy(\DB::raw('Date(added_at)'))->orderBy('created_at','desc')->limit(10)->get();
                if($records->isNotEmpty()){
                    foreach($records as $h) {
                        $date = date('d/m/Y', strtotime($h->added_at));
                        $date_2 = date('Y-m-d', strtotime($h->added_at));
                        $from = date('Y-m-d 00:00:00', strtotime($h->added_at));
                        $to = date('Y-m-d 23:59:59', strtotime($h->added_at));
                        $q_row = $d_row = $b_row = $p_row = "";
                        $dblock = '<div class="col-12 mt-2"><small>'.$date.'</small></div>';
    
                        $totalq = \App\ShopStoreSupplier::where('status','purchase')->where('shop_id',$sid)->where('supplier_id',$suppid)->whereBetween('added_at', [Carbon::parse($from),Carbon::parse($to)])->sum('quantity');
                        $totalp = \App\ShopStoreSupplier::where('status','purchase')->where('shop_id',$sid)->where('supplier_id',$suppid)->whereBetween('added_at', [Carbon::parse($from),Carbon::parse($to)])->sum('total_buying');
                        $deposits = \App\ShopStoreSupplier::where('shop_id',$sid)->where('supplier_id',$suppid)->where('status','deposit')->whereBetween('added_at', [Carbon::parse($from),Carbon::parse($to)])->sum('amount');
                        $borrow = \App\ShopStoreSupplier::where('shop_id',$sid)->where('supplier_id',$suppid)->where('status','borrow')->whereBetween('added_at', [Carbon::parse($from),Carbon::parse($to)])->sum('amount');
                        $totalq = $totalq + 0;
                        if($totalq) {
                            $q_row = '<div class="col-12"><div style="float: left;">Items bought</div><div style="float: right;"><b>'.$totalq.'</b></div></div>';
                        }
                        if($totalp) {
                            $p_row = '<div class="col-12"><div style="float: left;">Value of Items</div><div style="float: right;"><b>'.number_format($totalp).'</b></div></div>';
                        }
                        if($borrow) {
                            $b_row = '<div class="col-12"><div style="float: left;">Borrowed Amount</div><div style="float: right;"><b>'.number_format($borrow).'</b></div></div>';
                        }
                        if($deposits) {
                            $d_row = '<div class="col-12"><div style="float: left;">Deposited Amount</div><div style="float: right;"><b style="color: #41B06E;">'.number_format($deposits).'</b></div></div>';
                        }
    
                        $details[] = '<div class="row rec-row">'.$dblock.'<div class="col-12"><div class="row px-0 py-2 mx-0" style="background: #f9f6f2;">'.$q_row.''.$p_row.''.$b_row.''.$d_row.
                                     '<div class="col-12 d-edit-block" align="right"><button class="btn btn-outline-danger d-edit-details" date="'.$date_2.'"><i class="fa fa-pencil"></i></button></div></div></div></div>';
    
                    }
                }
            }
            if($from2 == "store") {
                $records = \App\ShopStoreSupplier::where('store_id',$sid)->where('supplier_id',$suppid)->groupBy(\DB::raw('Date(added_at)'))->orderBy('created_at','desc')->limit(10)->get();
                if($records->isNotEmpty()){
                    foreach($records as $h) {
                        $date = date('d/m/Y', strtotime($h->added_at));
                        $date_2 = date('Y-m-d', strtotime($h->added_at));
                        $from = date('Y-m-d 00:00:00', strtotime($h->added_at));
                        $to = date('Y-m-d 23:59:59', strtotime($h->added_at));
                        $q_row = $d_row = $b_row = $p_row = "";
                        $dblock = '<div class="col-12 mt-2"><small>'.$date.'</small></div>';
    
                        $totalq = \App\ShopStoreSupplier::where('status','purchase')->where('store_id',$sid)->where('supplier_id',$suppid)->whereBetween('added_at', [Carbon::parse($from),Carbon::parse($to)])->sum('quantity');
                        $totalp = \App\ShopStoreSupplier::where('status','purchase')->where('store_id',$sid)->where('supplier_id',$suppid)->whereBetween('added_at', [Carbon::parse($from),Carbon::parse($to)])->sum('total_buying');
                        $deposits = \App\ShopStoreSupplier::where('store_id',$sid)->where('supplier_id',$suppid)->where('status','deposit')->whereBetween('added_at', [Carbon::parse($from),Carbon::parse($to)])->sum('amount');
                        $borrow = \App\ShopStoreSupplier::where('store_id',$sid)->where('supplier_id',$suppid)->where('status','borrow')->whereBetween('added_at', [Carbon::parse($from),Carbon::parse($to)])->sum('amount');
                        $totalq = $totalq + 0;
                        if($totalq) {
                            $q_row = '<div class="col-12"><div style="float: left;">Items bought</div><div style="float: right;"><b>'.$totalq.'</b></div></div>';
                        }
                        if($totalp) {
                            $p_row = '<div class="col-12"><div style="float: left;">Value of Items</div><div style="float: right;"><b>'.number_format($totalp).'</b></div></div>';
                        }
                        if($borrow) {
                            $b_row = '<div class="col-12"><div style="float: left;">Borrowed Amount</div><div style="float: right;"><b>'.number_format($borrow).'</b></div></div>';
                        }
                        if($deposits) {
                            $d_row = '<div class="col-12"><div style="float: left;">Deposited Amount</div><div style="float: right;"><b style="color: #41B06E;">'.number_format($deposits).'</b></div></div>';
                        }
    
                        $details[] = '<div class="row rec-row">'.$dblock.'<div class="col-12"><div class="row px-0 py-2 mx-0" style="background: #f9f6f2;">'.$q_row.''.$p_row.''.$b_row.''.$d_row.
                                     '<div class="col-12 d-edit-block" align="right"><button class="btn btn-outline-danger d-edit-details" date="'.$date_2.'"><i class="fa fa-pencil"></i></button></div></div></div></div>';
    
                    }
                }
            }
            return response()->json(['details'=>$details]);
        }

        if($check == "supplier-year-summary") {
            $con = explode("~",$conditions);
            $sid = $con[0];
            $suppid = $con[1]; 
            $from = $con[2]; 
            $new_year_balance = 0;
            $thisyear = date('Y');
            if($from == "shop") {
                $deposits = \App\ShopStoreSupplier::where('shop_id',$sid)->where('supplier_id',$suppid)->where('status','deposit')->whereYear('added_at', $thisyear)->sum('amount'); 
                $borrow = \App\ShopStoreSupplier::where('shop_id',$sid)->where('supplier_id',$suppid)->where('status','borrow')->whereYear('added_at', $thisyear)->sum('amount');            
                $new_year_balance = \App\ShopStoreSupplier::where('shop_id',$sid)->where('supplier_id',$suppid)->where('status',$thisyear)->first();
                $totalq = \App\ShopStoreSupplier::where('status','purchase')->where('shop_id',$sid)->where('supplier_id',$suppid)->whereYear('added_at', $thisyear)->sum('quantity');
                $totalp = \App\ShopStoreSupplier::where('status','purchase')->where('shop_id',$sid)->where('supplier_id',$suppid)->whereYear('added_at', $thisyear)->sum('total_buying');
            }
            if($from == "store") {
                $deposits = \App\ShopStoreSupplier::where('store_id',$sid)->where('supplier_id',$suppid)->where('status','deposit')->whereYear('added_at', $thisyear)->sum('amount'); 
                $borrow = \App\ShopStoreSupplier::where('store_id',$sid)->where('supplier_id',$suppid)->where('status','borrow')->whereYear('added_at', $thisyear)->sum('amount');            
                $new_year_balance = \App\ShopStoreSupplier::where('store_id',$sid)->where('supplier_id',$suppid)->where('status',$thisyear)->first();
                $totalq = \App\ShopStoreSupplier::where('status','purchase')->where('store_id',$sid)->where('supplier_id',$suppid)->whereYear('added_at', $thisyear)->sum('quantity');
                $totalp = \App\ShopStoreSupplier::where('status','purchase')->where('store_id',$sid)->where('supplier_id',$suppid)->whereYear('added_at', $thisyear)->sum('total_buying');
            }
            if($new_year_balance) {
                $new_year_balance = $new_year_balance->amount;
            }
            $data['deposits'] = number_format($deposits);
            $data['borrow'] = number_format($borrow);
            $data['totalq'] = $totalq + 0;
            $data['totalp'] = number_format($totalp);
            $balance = $deposits - $totalp - $borrow;
            $balance = $balance + $new_year_balance;
            if($balance == 0) {
                $data['balance'] = '<h5>0</h5><small>Balance</small>';
            } elseif ($balance > 0) {
                $data['balance'] = '<h5 style="color:#41B06E">'.number_format($balance).'</h5><small>Balance</small>';
            } elseif ($balance < 0) {
                $data['balance'] = '<h5 style="color:red">'.number_format(abs($balance)).'</h5><small>Debt</small>';
            }
            return response()->json(['data'=>$data]);
        }

        if($check == "edit-submitted-details") {
            $con = explode("~",$conditions);
            $sid = $con[0];
            $suppid = $con[1];
            $date = $con[2];
            $from2 = $con[3];
            $output = $output2 = $output3 = array();
            
            $from = date('Y-m-d 00:00:00', strtotime($date));
            $to = date('Y-m-d 23:59:59', strtotime($date));

            if($from2 == "shop") {
                $items = \App\ShopStoreSupplier::where('status','purchase')->where('shop_id',$sid)->where('supplier_id',$suppid)->whereBetween('added_at', [Carbon::parse($from),Carbon::parse($to)])->get();
                $totalp = \App\ShopStoreSupplier::where('status','purchase')->where('shop_id',$sid)->where('supplier_id',$suppid)->whereBetween('added_at', [Carbon::parse($from),Carbon::parse($to)])->sum('total_buying');
                $deposits = \App\ShopStoreSupplier::where('shop_id',$sid)->where('supplier_id',$suppid)->where('status','deposit')->whereBetween('added_at', [Carbon::parse($from),Carbon::parse($to)])->get();
                $borrows = \App\ShopStoreSupplier::where('shop_id',$sid)->where('supplier_id',$suppid)->where('status','borrow')->whereBetween('added_at', [Carbon::parse($from),Carbon::parse($to)])->get();
            }
            if($from2 == "store") {
                $items = \App\ShopStoreSupplier::where('status','purchase')->where('store_id',$sid)->where('supplier_id',$suppid)->whereBetween('added_at', [Carbon::parse($from),Carbon::parse($to)])->get();
                $totalp = \App\ShopStoreSupplier::where('status','purchase')->where('store_id',$sid)->where('supplier_id',$suppid)->whereBetween('added_at', [Carbon::parse($from),Carbon::parse($to)])->sum('total_buying');
                $deposits = \App\ShopStoreSupplier::where('store_id',$sid)->where('supplier_id',$suppid)->where('status','deposit')->whereBetween('added_at', [Carbon::parse($from),Carbon::parse($to)])->get();
                $borrows = \App\ShopStoreSupplier::where('store_id',$sid)->where('supplier_id',$suppid)->where('status','borrow')->whereBetween('added_at', [Carbon::parse($from),Carbon::parse($to)])->get();
            }
            $totalq = 0;
            if($items->isNotEmpty()) {
                foreach($items as $i) {
                    $q = $i->quantity + 0;
                    $output[] = '<div class="mb-3 item-row prow-'.$i->id.'"><div class="item-col">'.$i->product->name.
                                '<br><input type="number" class="form-control form-control-sm updated-bq" name="epq'.$i->id.'" value="'.$q.'" val="'.$i->id.'"><span>x</span><span class="epqq'.$i->id.'">'.number_format($i->buying_price).'</span><span>=</span><span class="epqqq'.$i->id.'">'.number_format($i->total_buying).'</span>'.
                                '</div><div class="i-calcul">'.
                                '<button class="btn btn-outline-danger btn-sm delete-purchased-item" pid="'.$i->id.'"><i class="fa fa-times"></i></button></div></div>';
                }
                $output[] = '<div><button class="btn btn-success btn-sm update-purchased-items">Update <i class="fa fa-check pl-1"></i></button><button class="btn btn-warning close-modal btn-sm ml-2" data-dismiss="modal">Close <i class="fa fa-ban pl-1"></i></button></div>';
            } else {
                $output[] = '<div class="mb-1"><small>- No purchases -</small></div>';
            }
            if($deposits->isNotEmpty()) {
                foreach($deposits as $d) {
                    $amount = $d->amount + 0;
                    $output2[] = '<div class="mb-2"><div class="" style="width:100px;display:inline-block"><input type="number" class="form-control form-control-sm spa-'.$d->id.'" value="'.$amount.'"></div><button class="btn btn-info ml-3 update-deposited-amount" val="'.$d->id.'" style="display:inline-block"><i class="fa fa-check pl-1"></i></button></div>';
                }
            } else {
                $output2[] = '<div class="mb-1"><small>- No deposits -</small></div>';
            }

            return response()->json(['status'=>'success','output'=>$output,'output2'=>$output2,'output3'=>$output3]);
        }
        
        if($check == "supplier-purchases-cart") {
            $con = explode("~",$conditions);
            $sid = $con[0];
            $suppid = $con[1]; 
            $from = $con[2]; 
            $output = array();
            if($from == "shop") {
                $data['shop'] = \App\Shop::find($sid);
                $data['allproducts'] = $data['shop']->products()->orderBy('products.name','asc')->get();
                $draft = \App\ShopStoreSupplier::where('status','draft')->where('shop_id',$sid)->where('supplier_id',$suppid)->where('user_id',Auth::user()->id)->get();
                if($draft->isNotEmpty()) {
                    $totalq = \App\ShopStoreSupplier::where('status','draft')->where('shop_id',$sid)->where('supplier_id',$suppid)->where('user_id',Auth::user()->id)->sum('quantity');
                    $totalp = \App\ShopStoreSupplier::where('status','draft')->where('shop_id',$sid)->where('supplier_id',$suppid)->where('user_id',Auth::user()->id)->sum('total_buying');
                    $data['totalq'] = $totalq + 0; $data['totalp'] = number_format($totalp);
                    foreach($draft as $d) {
                        $q = $d->quantity + 0;
                        $output[] = '<div class="form-group pq-row-'.$d->id.'"><label>'.$d->product->name.'</label>'.
                                    '<input type="number" name="pq-'.$d->id.'" rowid="'.$d->id.'" class="form-control p-quantity" placeholder="0" value="'.$q.'" step=".01" required>'.
                                    '<span class="pl-2"></span><span class="clear-pq-row2 p-2" rid="'.$d->id.'"><i class="fa fa-times"></i></span>'.
                                    '<div class="bb-price"><div><span class="rowq-'.$d->id.'">'.$q.'</span> x '.number_format($d->buying_price).' = <span class="rowp-'.$d->id.'">'.number_format($d->total_buying).'</span></div></div></div>';
                    }
                }
            }
            if($from == "store") {
                $data['store'] = \App\Store::find($sid);
                $data['allproducts'] = $data['store']->products()->orderBy('products.name','asc')->get();
                $draft = \App\ShopStoreSupplier::where('status','draft')->where('store_id',$sid)->where('supplier_id',$suppid)->where('user_id',Auth::user()->id)->get();
                if($draft->isNotEmpty()) {
                    $totalq = \App\ShopStoreSupplier::where('status','draft')->where('store_id',$sid)->where('supplier_id',$suppid)->where('user_id',Auth::user()->id)->sum('quantity');
                    $totalp = \App\ShopStoreSupplier::where('status','draft')->where('store_id',$sid)->where('supplier_id',$suppid)->where('user_id',Auth::user()->id)->sum('total_buying');
                    $data['totalq'] = $totalq + 0; $data['totalp'] = number_format($totalp);
                    foreach($draft as $d) {
                        $q = $d->quantity + 0;
                        $output[] = '<div class="form-group pq-row-'.$d->id.'"><label>'.$d->product->name.'</label>'.
                                    '<input type="number" name="pq-'.$d->id.'" rowid="'.$d->id.'" class="form-control p-quantity" placeholder="0" value="'.$q.'" step=".01" required>'.
                                    '<span class="pl-2"></span><span class="clear-pq-row2 p-2" rid="'.$d->id.'"><i class="fa fa-times"></i></span>'.
                                    '<div class="bb-price"><div><span class="rowq-'.$d->id.'">'.$q.'</span> x '.number_format($d->buying_price).' = <span class="rowp-'.$d->id.'">'.number_format($d->total_buying).'</span></div></div></div>';
                    }
                }
            }
            return response()->json(['data'=>$data,'output'=>$output]);
        }
        
        if($check == "add-purchased-item") {
            $con = explode("~",$conditions);
            $sid = $con[0];
            $suppid = $con[1]; 
            $pid = $con[2]; 
            $from = $con[3]; 
            $product = \App\Product::find($pid);
            if($product) {
                if($from == "shop") {
                    $add = \App\ShopStoreSupplier::create(['product_id'=>$pid,'shop_id'=>$sid,'supplier_id'=>$suppid,'quantity'=>1,'buying_price'=>$product->buying_price,'total_buying'=>$product->buying_price,'user_id'=>Auth::user()->id,'status'=>'draft','company_id'=>Auth::user()->company_id]);
                }
                if($from == "store") {
                    $add = \App\ShopStoreSupplier::create(['product_id'=>$pid,'store_id'=>$sid,'supplier_id'=>$suppid,'quantity'=>1,'buying_price'=>$product->buying_price,'total_buying'=>$product->buying_price,'user_id'=>Auth::user()->id,'status'=>'draft','company_id'=>Auth::user()->company_id]);
                }
                if($add) {
                    return response()->json(['status'=>'success','product'=>$product,'row'=>$add]);
                }
            }
        }

        if($check == "update-purchased-quantity") {
            $con = explode("~",$conditions);
            $rowid = $con[0];
            $val = $con[1]; 
            $stock = \App\ShopStoreSupplier::where('id',$rowid)->where('user_id',Auth::user()->id)->first();
            if($stock) {
                $total = $val * $stock->buying_price;
                $stock->update(['quantity'=>$val,'total_buying'=>$total]);
                $totalq = \App\ShopStoreSupplier::where('status','draft')->where('shop_id',$stock->shop_id)->where('store_id',$stock->store_id)->where('supplier_id',$stock->supplier_id)->where('user_id',Auth::user()->id)->sum('quantity');
                $totalp = \App\ShopStoreSupplier::where('status','draft')->where('shop_id',$stock->shop_id)->where('store_id',$stock->store_id)->where('supplier_id',$stock->supplier_id)->where('user_id',Auth::user()->id)->sum('total_buying');
                $data['rowid'] = $rowid; $data['newq'] = $val; $data['newp'] = number_format($total);
                $data['totalq'] = $totalq + 0; $data['totalp'] = number_format($totalp);
                return response()->json(['status'=>'success','data'=>$data]);
            }
        }
        
        if($check == "clear-purchased-row") { //before submitting cart
            $rowid = $conditions;
            $stock = \App\ShopStoreSupplier::where('id',$rowid)->where('user_id',Auth::user()->id)->first();
            if($stock) {
                $stock->delete();
                $totalq = \App\ShopStoreSupplier::where('status','draft')->where('shop_id',$stock->shop_id)->where('store_id',$stock->store_id)->where('supplier_id',$stock->supplier_id)->where('user_id',Auth::user()->id)->sum('quantity');
                $totalp = \App\ShopStoreSupplier::where('status','draft')->where('shop_id',$stock->shop_id)->where('store_id',$stock->store_id)->where('supplier_id',$stock->supplier_id)->where('user_id',Auth::user()->id)->sum('total_buying');
                $data['rowid'] = $rowid;
                $data['totalq'] = $totalq + 0; $data['totalp'] = number_format($totalp);
                return response()->json(['status'=>'success','data'=>$data]);
            }
        }
        
        if($check == "clear-purchased-row-2") { //after submitting cart
            $con = explode("~",$conditions);
            $rowid = $con[0];
            $from = $con[1]; 
            $stock = \App\ShopStoreSupplier::where('id',$rowid)->where('company_id',Auth::user()->company_id)->first();
            if($stock) {
                $stock->update(['status'=>'deleted']);
                $quantity = $stock->quantity;
                if($from == "shop") {
                    $row = \DB::connection('tenant')->table('shop_products')->where('shop_id',$stock->shop_id)->where('product_id',$stock->product_id)->where('active','yes');
                    if ($row->first()) {
                        $currQ = $row->first()->quantity;
                        $new_q = $currQ - $quantity;
                        $insert = \App\StockAdjustment::create(['from'=>'shop','from_id'=>$row->first()->shop_id,'product_id'=>$row->first()->product_id,'av_quantity'=>$currQ,'company_id'=>Auth::user()->company_id, 'new_quantity'=>$new_q,'status'=>'stock adjustment','user_id'=>Auth::user()->id]);                
                        if ($insert) {
                            $update = $row->update(['quantity'=>$new_q]);

                            Log::channel('custom')->info('PID: '.$stock->product_id.', newQ = '.$new_q.' .. clearPurchasedQ = '.$quantity.' .. prevQ = '.$currQ);
                        }
                    } 
                }
                if($from == "store") {
                    $row = \DB::connection('tenant')->table('store_products')->where('store_id',$stock->store_id)->where('product_id',$stock->product_id)->where('active','yes');
                    if ($row->first()) {
                        $new_q = $row->first()->quantity - $quantity;
                        $insert = \App\StockAdjustment::create(['from'=>'store','from_id'=>$row->first()->store_id,'product_id'=>$row->first()->product_id,'av_quantity'=>$row->first()->quantity,'company_id'=>Auth::user()->company_id, 'new_quantity'=>$new_q,'status'=>'stock adjustment','user_id'=>Auth::user()->id]);                
                        if ($insert) {
                            $update = $row->update(['quantity'=>$new_q]);
                        }
                    } 
                }
                return response()->json(['status'=>'success','id'=>$rowid]);
            }
        }
        
        if($check == "clear-purchased-cart") {
            $con = explode("~",$conditions);
            $sid = $con[0];
            $suppid = $con[1]; 
            $from = $con[2]; 
            if($from == "shop") {
                $delete = \App\ShopStoreSupplier::where('status','draft')->where('shop_id',$sid)->where('supplier_id',$suppid)->where('user_id',Auth::user()->id)->delete();
            }
            if($from == "store") {
                $delete = \App\ShopStoreSupplier::where('status','draft')->where('store_id',$sid)->where('supplier_id',$suppid)->where('user_id',Auth::user()->id)->delete();
            }
            if($delete) {
                
                return response()->json(['status'=>'success']);
            }            
        }

        if($check == "submit-purchased-cart") {
            $con = explode("~",$conditions);
            $sid = $con[0];
            $suppid = $con[1]; 
            $from = $con[2]; 
            if($from == "shop") {
                $draft = \App\ShopStoreSupplier::where('status','draft')->where('shop_id',$sid)->where('supplier_id',$suppid)->where('user_id',Auth::user()->id)->get();
                if($draft->isNotEmpty()) {  
                    // check for minimum stock level 
                    if(Auth::user()->company->isCheckingStockLevel()){ $min_stock = "yes"; } else { $min_stock = "no"; }
    
                    foreach($draft as $d) {
                        $d->update(['status'=>'purchase','added_at'=>date('Y-m-d H:i:s')]);
                        $spro = \DB::connection('tenant')->table('shop_products')->where('shop_id',$sid)->where('product_id',$d->product_id)->where('active','yes');
                        if($spro->first()) {
                            $av_q = $spro->first()->quantity;
                        } else {
                            $av_q = 0;
                        }
                        $new_q = $av_q + $d->quantity;
                        $insert = \App\NewStock::create(['product_id'=>$d->product_id,'shop_id'=>$sid,'supplier_id'=>$suppid,'available_quantity'=>$av_q,'added_quantity'=>$d->quantity,'new_quantity'=>$new_q,'buying_price'=>$d->buying_price,'total_buying'=>$d->total_buying,'sent_at'=>date('Y-m-d H:i:s'),'received_by'=>$d->user_id,'received_at'=>date('Y-m-d H:i:s'),'user_id'=>$d->user_id,'status'=>'updated','company_id'=>$d->company_id]);
                        
                        if($insert) {
                            if ($spro->first()) {
                                $spro->update(['quantity'=>$new_q]);

                                Log::channel('custom')->info('PID: '.$d->product_id.', newQ = '.$new_q.' .. purchasedQ = '.$d->quantity.' .. prevQ = '.$av_q);
                            } else {
                                $add = DB::connection('tenant')->table('shop_products')->insert(['shop_id' => $sid, 'product_id'=>$d->product_id, 'quantity'=>$d->quantity, 'active'=>'yes', 'created_at' =>  \Carbon\Carbon::now(), 'updated_at' =>  \Carbon\Carbon::now()]);

                                Log::channel('custom')->info('PID: '.$d->product_id.', newQ = '.$d->quantity.' .. purchasedQ = '.$d->quantity.' .. prevQ = 0');
                            }
    
                            if($min_stock == "yes") {          
                                $pro = \App\Product::find($d->product_id);                  
                                if($pro->min_stock_level >= $new_q) {
                                    ProductController::insertMSL($pro->id,'shop',$sid,$pro->min_stock_level);
                                } else {
                                    $check = \App\Notification::where('shop_id',$sid)->where('product_id',$pro->id)->first();
                                    if($check) {
                                        $check->update(['product_id'=>null]);
                                    }
                                }
                            }
                        }
                    }
                    return response()->json(['status'=>'success']);
                }       
            }     
            if($from == "store") {
                $draft = \App\ShopStoreSupplier::where('status','draft')->where('store_id',$sid)->where('supplier_id',$suppid)->where('user_id',Auth::user()->id)->get();
                if($draft->isNotEmpty()) {  
                    // check for minimum stock level 
                    if(Auth::user()->company->isCheckingStockLevel()){ $min_stock = "yes"; } else { $min_stock = "no"; }
    
                    foreach($draft as $d) {
                        $d->update(['status'=>'purchase','added_at'=>date('Y-m-d H:i:s')]);
                        $spro = \DB::connection('tenant')->table('store_products')->where('store_id',$sid)->where('product_id',$d->product_id)->where('active','yes');
                        if($spro->first()) {
                            $av_q = $spro->first()->quantity;
                        } else {
                            $av_q = 0;
                        }
                        $new_q = $av_q + $d->quantity;
                        $insert = \App\NewStock::create(['product_id'=>$d->product_id,'store_id'=>$sid,'supplier_id'=>$suppid,'available_quantity'=>$av_q,'added_quantity'=>$d->quantity,'new_quantity'=>$new_q,'buying_price'=>$d->buying_price,'total_buying'=>$d->total_buying,'sent_at'=>date('Y-m-d H:i:s'),'received_by'=>$d->user_id,'received_at'=>date('Y-m-d H:i:s'),'user_id'=>$d->user_id,'status'=>'updated','company_id'=>$d->company_id]);
                        
                        if($insert) {
                            if ($spro->first()) {
                                $spro->update(['quantity'=>$new_q]);
                            } else {
                                $add = DB::connection('tenant')->table('store_products')->insert(['store_id' => $sid, 'product_id'=>$d->product_id, 'quantity'=>$d->quantity, 'active'=>'yes', 'created_at' =>  \Carbon\Carbon::now(), 'updated_at' =>  \Carbon\Carbon::now()]);
                            }
    
                            if($min_stock == "yes") {          
                                $pro = \App\Product::find($d->product_id);                  
                                if($pro->min_stock_level >= $new_q) {
                                    ProductController::insertMSL($pro->id,'store',$sid,$pro->min_stock_level);
                                } else {
                                    $check = \App\Notification::where('store_id',$sid)->where('product_id',$pro->id)->first();
                                    if($check) {
                                        $check->update(['product_id'=>null]);
                                    }
                                }
                            }
                        }
                    }
                    return response()->json(['status'=>'success']);
                }       
            }     
        }
        
        if($check == "supplier-close-year-balance") {
            $suppliers = \App\Supplier::where('status','active')->get();
            if ($suppliers->isNotEmpty()) {
                foreach ($suppliers as $supp) {
                    if($supp->shop_id) { // update shop suppliers
                        $shopid = $supp->shop_id;
                        $suppid = $supp->id; 
                        $thisyear = date('Y');
                        $lastyear = $thisyear - 1;
                        $last_year_balance = 0;
                        
                        $deposits = \App\ShopStoreSupplier::where('shop_id',$shopid)->where('supplier_id',$suppid)->where('status','deposit')->whereYear('added_at', $lastyear)->sum('amount'); 
                        $borrow = \App\ShopStoreSupplier::where('shop_id',$shopid)->where('supplier_id',$suppid)->where('status','borrow')->whereYear('added_at', $lastyear)->sum('amount');            
                        $last_year_balance = \App\ShopStoreSupplier::where('shop_id',$shopid)->where('supplier_id',$suppid)->where('status',$lastyear)->first();
                        $totalp = \App\ShopStoreSupplier::where('status','purchase')->where('shop_id',$shopid)->where('supplier_id',$suppid)->whereYear('added_at', $lastyear)->sum('total_buying');
            
                        if($last_year_balance) {
                            $last_year_balance = $last_year_balance->amount;
                        }
                        $balance = $deposits - $totalp - $borrow;
                        $balance = $balance + $last_year_balance;
                        if($balance != 0) {
                            \App\ShopStoreSupplier::create(['shop_id'=>$shopid,'supplier_id'=>$suppid,'amount'=>$balance,'status'=>$thisyear]);
                        }
                    }
                    if($supp->store_id) { // update shop suppliers
                        $storeid = $supp->store_id;
                        $suppid = $supp->id; 
                        $thisyear = date('Y');
                        $lastyear = $thisyear - 1;
                        $last_year_balance = 0;
                        
                        $deposits = \App\ShopStoreSupplier::where('store_id',$storeid)->where('supplier_id',$suppid)->where('status','deposit')->whereYear('added_at', $lastyear)->sum('amount'); 
                        $borrow = \App\ShopStoreSupplier::where('store_id',$storeid)->where('supplier_id',$suppid)->where('status','borrow')->whereYear('added_at', $lastyear)->sum('amount');            
                        $last_year_balance = \App\ShopStoreSupplier::where('store_id',$storeid)->where('supplier_id',$suppid)->where('status',$lastyear)->first();
                        $totalp = \App\ShopStoreSupplier::where('status','purchase')->where('store_id',$storeid)->where('supplier_id',$suppid)->whereYear('added_at', $lastyear)->sum('total_buying');
            
                        if($last_year_balance) {
                            $last_year_balance = $last_year_balance->amount;
                        }
                        $balance = $deposits - $totalp - $borrow;
                        $balance = $balance + $last_year_balance;
                        if($balance != 0) {
                            \App\ShopStoreSupplier::create(['store_id'=>$storeid,'supplier_id'=>$suppid,'amount'=>$balance,'status'=>$thisyear]);
                        }
                    }
                }
                return response()->json(['status'=>'success']);
            }
        }
        
        if ($check == "update-sale-table") {
            # code...
            $sales = \App\Sale::where('customer_id',null)->where('created_at','>=',Carbon::parse('2025-05-02'))->get();
            // $update = \App\Sale::where('customer_id',0)->update(['customer_id'=>null]);
            foreach ($sales as $sale) {
                $sale->update(['updated_at'=>$sale->submitted_at]);
                // return response()->json(['status'=>'success']);
            }
        }

    }
}
