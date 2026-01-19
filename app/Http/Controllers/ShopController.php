<?php

namespace App\Http\Controllers;

use DB;
use Session;
use App\Shop;
use App\User;
use App\Customer;
use App\CustomerDebt;
use App\Sale;
use App\Product;
use App\ProductCategory;
use App\Expense;
use App\ClosureSale;
use App\ShopExpense;
use App\ReturnSoldItem;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Services\TenantService;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Log;

class ShopController extends Controller
{

    public function shop($shop_id) {
        // check if ceo / BU .. display all shops else display responsible shops   
        $data['countries'] = \App\Country::query()->select([
                DB::raw('id,name')
            ])->get();     
        if (Auth::user()->isCEOorAdminorBusinessOwner()) {
            $data['isCEO'] = "yes";
            $data['shop'] = Shop::where('id',$shop_id)->where('company_id',Auth::user()->company_id)->first();
            $data['who'] = DB::connection('tenant')->table('user_shops')->where('user_id',Auth::user()->id)->where('shop_id',$shop_id)->first();
            if($data['who']) {
                $data['who'] = $data['who']->who;
            } else {
                $data['who'] = "";
            }            
            $data['shops'] = Shop::where('company_id',Auth::user()->company_id)->where('id','!=',$shop_id)->get();
            $data['users'] = User::where('company_id',Auth::user()->company_id)->where('status','!=','deleted')->get();
        } else {
            if(Auth::user()->hasCashierRole() || Auth::user()->isSalePerson()){
                $data['isCEO'] = "no";
                $data['shop'] = Shop::where('id',$shop_id)->where('company_id',Auth::user()->company_id)->first();
                $data['who'] = DB::connection('tenant')->table('user_shops')->where('user_id',Auth::user()->id)->where('shop_id',$shop_id)->first();
                if($data['who']) {
                    $data['who'] = $data['who']->who;
                } else {
                    $data['who'] = "";
                }            
                $data['users'] = User::where('id','!=',1)->where('status','!=','deleted')->where('company_id',Auth::user()->company_id)->get();
                $data['shops'] = DB::connection('tenant')->table('shops')->join('user_shops','user_shops.shop_id','shops.id')->where('user_shops.user_id',Auth::user()->id)->where('shops.id','!=',$shop_id)->whereIn('user_shops.who',['cashier','sale person'])->select('*','shops.id AS sid')->get();
            } else {
                return redirect()->back()->with('error','Sorry! It seems like you dont have permission in this shop.');
            }            
        }
        
        return view('shop',compact('data')); 
    }

    public function store(Request $request) {
        $shop = Shop::create(['name' => $request->name, 'location' => $request->location, 'has_customers'=>$request->crecords, 'company_id'=>Auth::user()->company_id, 'user_id' => Auth::user()->id]);
        if (!$shop) {
            return response()->json(['error'=>'Error! Shop not created.']);
        } 
        if ($request->user) {
            DB::connection('tenant')->table('user_shops')->insert(['user_id' => $request->user, 'shop_id'=>$shop->id, 'who'=>'cashier']);
            $check = DB::table('user_roles')->where('user_id',$request->user)->where('role_id',6)->get();
            if ($check->isEmpty()) {
                DB::table('user_roles')->insert(['user_id' => $request->user, 'role_id'=>6]);
            }
        }
        return response()->json(['success'=>'Success! Shop created successfully.']);
    }

    public function update(Request $request) {
        $shop = Shop::where('id',$request->shopid)->where('company_id',Auth::user()->company_id)->first();
        if($request->region_id == "-") {
            $request->region_id = null;
        }
        if($request->district_id == "-") {
            $request->district_id = null;
        }
        if($request->ward_id == "-") {
            $request->ward_id = null;
        }
        if ($shop) {
            $update = $shop->update(['name' => $request->name, 'location' => $request->shoplocation, 'has_customers'=>'yes', 'user_id' => Auth::user()->id,
                        'country_id'=>$request->country_id,
                        'region_id'=>$request->region_id,
                        'district_id'=>$request->district_id,
                        'ward_id'=>$request->ward_id]);
            if ($update) {
                return response()->json(['status'=>'success']);
            }
        }
    }

    public function shops() {
        $data['countries'] = \App\Country::query()->select([
                DB::raw('id,name')
            ])->get();
        if(Auth::user()->isCEOorAdminorBusinessOwner()) {
            $data['isCEO'] = "yes";
            $data['users'] = User::where('id','!=',1)->where('status','!=','deleted')->where('company_id',Auth::user()->company_id)->get();
                $data['shops'] = Shop::query()->select([
                        DB::raw('shops.id as sid, shops.name as sname, shops.country_id as cid, shops.region_id as rid, shops.district_id as did, shops.ward_id as wid, shops.location as location, wards.name as wname, districts.name as dname')
                    ])
                    ->leftJoin('countries','countries.id','shops.company_id')
                    ->leftJoin('districts','districts.id','shops.district_id')
                    ->leftJoin('wards','wards.id','shops.ward_id')
                    ->where('shops.company_id',Auth::user()->company_id)
                    ->get();
            // $data['shops'] = Shop::where('company_id',Auth::user()->company_id)->get();
        } else { 
            if(Auth::user()->isCashier() || Auth::user()->hasSalePersonRole()){
                $data['isCEO'] = "no";
                $data['users'] = User::where('id','!=',1)->where('status','!=','deleted')->where('company_id',Auth::user()->company_id)->get();
                $data['shops'] = Shop::query()->select([
                        DB::raw('shops.id as sid, shops.name as sname, shops.country_id as cid, shops.region_id as rid, shops.district_id as did, shops.ward_id as wid, shops.location as location, wards.name as wname, districts.name as dname')
                    ])
                    ->leftJoin('countries','countries.id','shops.company_id')
                    ->leftJoin('districts','districts.id','shops.district_id')
                    ->leftJoin('wards','wards.id','shops.ward_id')
                    ->where('shops.company_id',Auth::user()->company_id)
                    ->join('user_shops','user_shops.shop_id','shops.id')->where('user_shops.user_id',Auth::user()->id)->whereIn('user_shops.who',['cashier','sale person'])
                    ->get();
            } else {
                return redirect()->back()->with('error','Sorry! It seems like you dont have permission in view shops.');
            }
        }
        return view('shops',compact('data'));
    }

    public function untouch_cashier(Request $request) {
        $delete = DB::connection('tenant')->table('user_shops')->where('user_id',$request->uid)->where('shop_id',$request->shop)->where('who','cashier')->delete();
        if ($delete) {
            $check = DB::connection('tenant')->table('user_shops')->where('user_id',$request->uid)->where('who','cashier')->get();
            if ($check->isEmpty()) {
                DB::table('user_roles')->where('user_id',$request->uid)->where('role_id',6)->delete();
            }
            return response()->json(['success'=>'Done! The user is no longer cashier in this shop.', 'shop'=>$request->shop, 'id'=>$request->uid]);
        }
        return response()->json(['error'=>'Error! Something went wrong. Please try again.']);
    }

    public function untouch_sperson(Request $request) {
        $delete = DB::connection('tenant')->table('user_shops')->where('user_id',$request->uid)->where('shop_id',$request->shop)->where('who','sale person')->delete();
        if ($delete) {
            $check = DB::connection('tenant')->table('user_shops')->where('user_id',$request->uid)->where('who','sale person')->get();
            if ($check->isEmpty()) {
                DB::table('user_roles')->where('user_id',$request->uid)->where('role_id',7)->delete();
            }
            return response()->json(['success'=>'Done! The user is no longer sale person in this shop.', 'shop'=>$request->shop, 'id'=>$request->uid]);
        }
        return response()->json(['error'=>'Error! Something went wrong. Please try again.']);
    }

    public function untouch_smaster(Request $request) {
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

    public static function shopById($sid) {
        return Shop::where('id',$sid)->where('company_id',Auth::user()->company_id)->first();
    }

    public function sales($sid) {
        $shop = DB::connection('tenant')->table('user_shops')->where('user_id',Auth::user()->id)->where('shop_id',$sid)->where('who','cashier')->first(); // check cashier
        if ($shop) {
            $data['customers'] = Customer::where('status','active')->where('company_id',Auth::user()->company_id)->orderBy('name')->get();
            $data['shop'] = Shop::where('id',$sid)->where('company_id',Auth::user()->company_id)->first();
            $data['categories'] = ProductCategory::where('company_id',Auth::user()->company_id)->where('status',null)->get();
            // $data['recent'] = Sale::where('shop_id',$sid)->where('status','sold')->groupBy('product_id')->orderBy('id','desc')->limit(12)->get();
            // $data['products'] = $data['shop']->products()->limit(10)->get();
            Session::put('role','Cashier');
            Session::put('shoid',$sid);
            return view('cashier.sales',compact('data'));
        } else {
            $shop = DB::connection('tenant')->table('user_shops')->where('user_id',Auth::user()->id)->where('shop_id',$sid)->where('who','sale person')->first(); // check sale person
            if ($shop) {
                $data['customers'] = Customer::where('status','active')->where('company_id',Auth::user()->company_id)->orderBy('name')->get();
                $data['shop'] = Shop::where('id',$sid)->where('company_id',Auth::user()->company_id)->first();
                $data['categories'] = ProductCategory::where('company_id',Auth::user()->company_id)->where('status',null)->get();
                Session::put('role','Sales Person');
                Session::put('shoid',$sid);
                return view('cashier.sales',compact('data'));
            } else {
                return redirect()->back()->with('error','Sorry! It seems like you dont have permission in this shop.');
            }
        }
    }

    public function sales_report($sid) {
        $data['customers'] = Customer::where('company_id',Auth::user()->company_id)->where('status','active')->orderBy('name')->get();
        $data['shop'] = Shop::where('id',$sid)->where('company_id',Auth::user()->company_id)->first();
        $data['categories'] = ProductCategory::where('company_id',Auth::user()->company_id)->where('status',null)->get();
        $data['products'] = $data['shop']->products()->limit(10)->get();
        return view('cashier.sales-report',compact('data'));
    }

    public function add_sale($shop_id,$pid,$customer_id) {
        $data['disabled'] = "";
        if ($customer_id == 'null') {
            $customer_id = null;
        }
        
        $item = Sale::where('company_id',Auth::user()->company_id)->where('user_id',Auth::user()->id)->where('shop_id',$shop_id)->where('product_id',$pid)->where('status','draft')->first();
        if ($item) {
            $qty = $data['qty'] = $item->quantity + 1;
            $total_buying = ($item->buying_price * $qty);
            $subtotal = ($item->selling_price * $qty);
            $data['subtotal'] = number_format($subtotal, 0);
            $update = $item->update(['quantity'=>$qty,'total_buying'=>$total_buying,'sub_total'=>$subtotal]);
            $sale = Sale::query()->select([
                DB::raw('SUM(quantity) as squantity, SUM(sub_total) as sprice')
            ])
            ->where('user_id',Auth::user()->id)->where('company_id',Auth::user()->company_id)
            ->where('shop_id',$shop_id)->where('status','draft')->get();
            return response()->json(['status'=>'double-click','id'=>$item->id,'data'=>$data,'sale'=>$sale]);
        } else {
            $product = Product::where('id',$pid)->where('company_id',Auth::user()->company_id)->first();
            $insert = Sale::create([
                'customer_id'=>$customer_id,'shop_id'=>$shop_id,'product_id'=>$pid,
                'quantity'=>1,'buying_price'=>$product->buying_price,'total_buying'=>$product->buying_price, 'company_id'=>Auth::user()->company_id,
                'selling_price'=>$product->retail_price,'sub_total'=>$product->retail_price,
                'user_id'=>Auth::user()->id,'sale_type'=>'retail','status'=>'draft'
                ]);
            if ($insert) {
                if($insert->shop->change_s_price == "no"){
                    $data['disabled'] = 'disabled=""';
                }
                $data['id'] = $insert->id;
                $data['qty'] = $insert->quantity;
                $data['pname'] = $product->name;
                $sale = Sale::query()->select([
                    DB::raw('SUM(quantity) as squantity, SUM(sub_total) as sprice')
                ])
                ->where('user_id',Auth::user()->id)->where('company_id',Auth::user()->company_id)
                ->where('shop_id',$shop_id)->where('status','draft')->get();
                $data['selling_price'] = $insert->selling_price;
                $data['subtotal'] = str_replace(".00", "", number_format($insert->selling_price, 2));
                return response()->json(['data'=>$data,'sale'=>$sale]);
            } else {
                return response()->json(['error'=>'Oops! Something wrong, fail to add.']);
            }      
        }
    }

    public function addNewSale(Request $request){
        $data = $p_ids = array();
        $user_id = Auth::user()->id;
        $company_id = Auth::user()->company_id;
        $productIds = $request->input('product_ids');
        $customer_id = $request->input('customer_id');
        $shop_id =  $request->input('shop_id');
        $quantities =  $request->input('quantities');
        $prices =  $request->input('prises');
        $paymentmethod =  $request->input('paymentmethod');
        $saledate =  $request->input('saledate');
        $curtime = date('H:i:s');
        $saledateB = $saledate;
        $saledate = date("Y-m-d H:i:s", strtotime($saledate.$curtime));
        $paidamount =  $request->input('paidamount');
        if ($customer_id == 'null') {
            $customer_id = null;
        }

        try {
            DB::beginTransaction();
 
            $shop = Shop::find($shop_id);

            $check = Sale::where('company_id',$company_id)->orderBy('sale_val','desc')->first();

            $val = $check ? ($check->sale_val + 1) : 1;
            $valStr = str_pad($val, 2, '0', STR_PAD_LEFT);
            $s_no = "SLN" . $user_id .'-'. $valStr;

            if(Session::get('min-stock-level') == "yes"){ $min_stock = "yes"; } else { $min_stock = "no"; }

            $submitted_at = date('Y-m-d H:i:s');
            foreach ($productIds as $key => $product_id) {
                $product = Product::find($product_id);

                $sale =  Sale::create([
                    'customer_id' => $customer_id,
                    'shop_id' => $shop_id,
                    'product_id' => $product_id,
                    'quantity' => $quantities[$key],
                    'buying_price' => $product->buying_price,
                    'total_buying' => $quantities[$key] * $product->buying_price,
                    'company_id' => $company_id,
                    'selling_price' => $prices[$key],
                     'sub_total' => $prices[$key] * $quantities[$key],
                    'user_id' => $user_id,
                    'sale_type' => 'retail',
                    'payment_option_id' => $paymentmethod,
                    'status' => 'sold',
                    'submitted_at' => $submitted_at,
                    'updated_at' => $saledate,
                    'paid_amount' => $paidamount,
                    'sale_val' => $val,
                    'sale_no' => $s_no,
                ]);

                if ($min_stock == "yes") { // check min stock level
                    $p_ids[] = $product_id;
                }

                $q = DB::connection('tenant')->table('shop_products')->where('shop_id',$shop_id)->where('product_id',$product_id)->where('active','yes');
                if ($q->first()) {
                    $currQ = $q->first()->quantity;
                    $quantity = ($q->first()->quantity - $quantities[$key]);
                    $q->update(['quantity'=>$quantity]);

                    Log::channel('custom')->info('PID: '.$product_id.', newQ = '.$quantity.' .. soldQ = '.$quantities[$key].' .. prevQ = '.$currQ);
                }
            }

            DB::commit();

            $data['saleno'] = $s_no;
            $data['predate'] = "no";
            if($saledateB != date('d-m-Y')) { // check if adding for previous date, then update DailySale table
                $data['predate'] = $saledateB;
            }

            return response()->json(['status' => 'success','data'=>$data,'ids'=>$p_ids]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function addNewOrder(Request $request){
        $company_id = Auth::user()->company_id;
        $productIds = $request->input('product_ids');
        $customer_id = $request->input('customer_id');
        $shop_id =  $request->input('shop_id');
        $quantities =  $request->input('quantities');
        $prices =  $request->input('prises');
        $saledate =  $request->input('saledate');
        $curtime = date('H:i:s');
        $saledate = date("Y-m-d H:i:s", strtotime($saledate.$curtime));
        if ($customer_id == 'null') {
            $customer_id = null;
        }

        try {
            DB::beginTransaction();

            $shop = Shop::find($shop_id);

            $check = Sale::where('status','!=','draft')->where('company_id',$company_id)->groupBy('sale_val')->orderBy('sale_val','desc')->first();

            $val = $check ? ($check->sale_val + 1) : 1;
            $valStr = str_pad($val, 2, '0', STR_PAD_LEFT);
            $s_no = "SLN" . Auth::user()->id . $valStr;

            $submitted_at = date('Y-m-d H:i:s');
            foreach ($productIds as $key => $product_id) {
                $product = Product::where('id', $product_id)
                    ->where('company_id', $company_id)
                    ->first();

                $sale =  Sale::create([
                    'customer_id' => $customer_id,
                    'shop_id' => $shop_id,
                    'product_id' => $product_id,
                    'quantity' => $quantities[$key],
                    'buying_price' => $product->buying_price,
                    'total_buying' => $quantities[$key] * $product->buying_price,
                    'company_id' => $company_id,
                    'selling_price' => $prices[$key],
                     'sub_total' => $prices[$key] * $quantities[$key],
                    'user_id' => Auth::user()->id,
                    'ordered_by' => Auth::user()->id,
                    'sale_type' => 'retail',
                    'status' => 'order',
                    'is_order'=>'yes',
                    'submitted_at' => $submitted_at,
                    'updated_at' => $saledate,
                    'sale_val' => $val,
                    'sale_no' => $s_no,
                ]);
            }

            DB::commit();

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()]);
        }

    }

    public function add_returned_item($shop_id,$pid) {
        $product = Product::where('id',$pid)->where('company_id',Auth::user()->company_id)->first();
        
        $item = ReturnSoldItem::where('company_id',Auth::user()->company_id)->where('user_id',Auth::user()->id)->where('shop_id',$shop_id)->where('product_id',$pid)->where('status','draft')->first();
        if ($item) {
            return response()->json(['error1'=>'This item is already in cart','id'=>$item->id]);
        } else {
            $insert = ReturnSoldItem::create([
                'shop_id'=>$shop_id,'product_id'=>$pid,'company_id'=>Auth::user()->company_id,
                'quantity'=>1,'user_id'=>Auth::user()->id,'status'=>'draft'
                ]);
            if ($insert) {
                $data['id'] = $insert->id;
                $data['qty'] = $insert->quantity;
                $data['quantity'] = ReturnSoldItem::where('user_id',Auth::user()->id)->where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->where('status','draft')->sum('quantity');
                return response()->json(['pname'=>$product->name,'data'=>$data]);
            } else {
                return response()->json(['error'=>'Oops! Something wrong, fail to add.']);
            }      
        }
    }

    public function return_sold_item($status,$shop_id) {
        if ($status == "pending") {
            $totalQr = 0;
            $items = ReturnSoldItem::where('user_id',Auth::user()->id)->where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->where('status','draft')->get();
            if ($items->isNotEmpty()) {     
                foreach ($items as $value) {
                    $totalQr = $totalQr + $value->quantity;
                    $output[] = '<tr class="ri-'.$value->id.'"><td>'.$value->product->name.'</td>'
                        .'<td><input type="number" class="form-control rquantity" name="quantity" value="'.sprintf('%g',$value->quantity).'" rid="'.$value->id.'"></td>'
                        .'<td><span class="p-1 text-danger remove-ri" val="'.$value->id.'" style="cursor: pointer;"><i class="fa fa-times"></i></span></td></tr>';
                }
                
                return response()->json(['items'=>$output,'totalQr'=>$totalQr]);
            }
        }        
    }

    public function submit_returned_items(Request $request) { // this is disabled now
        $items = ReturnSoldItem::where('user_id',Auth::user()->id)->where('company_id',Auth::user()->company_id)->where('shop_id',$request->shopid)->where('status','draft')->get();   

        $c_date = explode('/', $request->date_sold);
        $date = $c_date[0].'-'.$c_date[1].'-'.$c_date[2];
        $date = date("Y-m-d 00:00:00", strtotime($date));
        if ($items->isNotEmpty()) {     
            // check for minimum stock level 
            if(Auth::user()->company->isCheckingStockLevel()){ $min_stock = "yes"; } else { $min_stock = "no"; }  

            foreach ($items as $value) {
                $update = $value->update(['when_sold'=>$date,'status'=>'received']);
                if ($update) {
                    $q = DB::connection('tenant')->table('shop_products')->where('shop_id',$value->shop_id)->where('product_id',$value->product_id)->where('active','yes');
                    if ($q->first()) {
                        $currQ = $q->first()->quantity;
                        $quantity = ($currQ + $value->quantity);
                        $q->update(['quantity'=>$quantity]);

                        Log::channel('custom')->info('PID: '.$value->product_id.', newQ = '.$quantity.' .. returnedQ = '.$value->quantity.' .. prevQ = '.$currQ);
                        
                        if($min_stock == "yes") {          
                            $pro = \App\Product::find($value->product_id);      
                            if($pro->min_stock_level >= $quantity) {
                                ProductController::insertMSL($pro->id,'shop',$value->shop_id,$pro->min_stock_level);
                            } else {
                                $check = \App\Notification::where('shop_id',$value->shop_id)->where('product_id',$pro->id)->first();
                                if($check) {
                                    $check->update(['product_id'=>null]);
                                }
                            }
                        }
                    }                        
                }
            }
            
            return response()->json(['success'=>'done']);
        }        
    }

    public function pending_sale($shop_id) {
        $output = array();
        $totalQ = 0;
        $totalP = 0;
        $data['0'] = '';
        $disabled = "";
        $item = Sale::where('user_id',Auth::user()->id)->where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->where('status','draft')->first();
        $shop = Shop::find($shop_id);
        if ($item) {
            // $customer = User::find($item->shipper_id);   
            if ($item->customer_id) {
                $data['customer'] = $item->customer->name;
            }
            if($shop->change_s_price == "no"){
                $disabled = 'disabled=""';
            }
            $items = Sale::where('user_id',Auth::user()->id)->where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->where('status','draft')->get();         
            foreach ($items as $value) {
                $totalQ = $totalQ + $value->quantity;
                $totalP = $totalP + $value->sub_total;
                $totalP2 = str_replace(".00", "", number_format($totalP, 2));
                $shopro = \DB::connection('tenant')->table('shop_products')->where('shop_id',$shop_id)->where('product_id',$value->product_id)->where('active','yes')->first();
                if ($shopro) {
                    $output[] = '<tr class="sr-'.$value->id.'"><td><div class="row py-1">'
                    .'<span class="pull-right remove-sr" val="'.$value->id.'"><i class="fa fa-times"></i></span>'
                    .'<div class="col-12 r-name mb-1">'.$value->product->name.'<span class="aq ml-2"></span></div>'
                    .'<div class="col-12 s-nums" align="right"> <span><input type="number" class="form-control quantity" name="quantity" value="'.sprintf('%g',$value->quantity).'" rid="'.$value->id.'"></span> <span><i class="fa fa-times"></i></span> <span><input type="number" class="form-control sprice" name="sprice" value="'.str_replace(".00", "", $value->selling_price).'" rid="'.$value->id.'" style="display:inline-block" '.$disabled.'></span> <span>= </span><span><b class="srp-'.$value->id.'">'.str_replace(".00", "", number_format($value->sub_total, 2)).'</b></span></div>'
                    .'</div></td></tr>';
                }
            }

            return response()->json(['item'=>$item,'items'=>$output,'totalQ'=>$totalQ,'totalP'=>$totalP2,'data'=>$data]);
        } else {
            $output[] = '<tr class="empty-row"><td><div class="py-3"><i>- Empty Cart -</i></div></td></tr>';
            return response()->json(['items'=>$output,'totalQ'=>$totalQ,'totalP'=>0,'data'=>$data]);
        }
    }
    public function pending_sale2($shop_id) { // this function is not used anymore
        $output = array();
        $totalQ = 0;
        $totalP = 0;
        $item = Sale::where('user_id',Auth::user()->id)->where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->where('status','draft')->first();
        if ($item) {
            // $customer = User::find($item->shipper_id);   
            $items = Sale::where('user_id',Auth::user()->id)->where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->where('status','draft')->get();         
            foreach ($items as $value) {
                $totalQ = $totalQ + $value->quantity;
                $totalP = $totalP + $value->sub_total;
                $totalP2 = number_format($totalP);
                $shopro = \DB::connection('tenant')->table('shop_products')->where('shop_id',$shop_id)->where('product_id',$value->product_id)->where('active','yes')->first();
                if ($shopro) {
                    $output[] = '<tr class="sr-'.$value->id.'"><td>'.$value->product->name.'</td>'
                    .'<td><input type="number" class="form-control quantity" name="quantity" value="'.$value->quantity.'" rid="'.$value->id.'"><span class="aqty">'.$shopro->quantity.'</span></td>'
                    .'<td><input type="number" class="form-control sprice" name="sprice" value="'.round($value->selling_price, 0).'" rid="'.$value->id.'"></td>'
                    .'<td class="srp-'.$value->id.'">'.number_format($value->sub_total, 0).'</td><td><span class="p-1 text-danger remove-sr" val="'.$value->id.'" style="cursor: pointer;"><i class="fa fa-times"></i></span></td></tr>';
                }
            }

            return response()->json(['item'=>$item,'items'=>$output,'totalQ'=>$totalQ,'totalP'=>$totalP2]);
        }
    }

    public function sales_summary($check,$shop_id) { 
        if ($check == "all") {
            $data['today_quantity'] = Sale::whereDate('updated_at', Carbon::today())->where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->where('status','sold')->sum('quantity');
            $today_price = Sale::whereDate('updated_at', Carbon::today())->where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->where('status','sold')->sum('sub_total');
            $data['week_quantity'] = Sale::whereBetween('updated_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('shop_id',$shop_id)->where('company_id',Auth::user()->company_id)->where('status','sold')->sum('quantity');
            $week_price = Sale::whereBetween('updated_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('shop_id',$shop_id)->where('company_id',Auth::user()->company_id)->where('status','sold')->sum('sub_total');
            $data['month_quantity'] = Sale::whereBetween('updated_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->where('shop_id',$shop_id)->where('company_id',Auth::user()->company_id)->where('status','sold')->sum('quantity');
            $month_price = Sale::whereBetween('updated_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->where('shop_id',$shop_id)->where('company_id',Auth::user()->company_id)->where('status','sold')->sum('sub_total');
            $data['today_price'] = str_replace(".00", "", number_format($today_price, 2));
            $data['week_price'] = str_replace(".00", "", number_format($week_price, 2));
            $data['month_price'] = str_replace(".00", "", number_format($month_price, 2));
            return response()->json(['data'=>$data]);
        }
        if ($check == "today") {
            $data['today_quantity'] = Sale::whereDate('updated_at', Carbon::today())->where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->where('status','sold')->sum('quantity');
            $today_price = Sale::whereDate('updated_at', Carbon::today())->where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->where('status','sold')->sum('sub_total');
            $data['today_price'] = str_replace(".00", "", number_format($today_price, 2));
            $data['today_expenses'] = ShopExpense::whereDate('created_at', Carbon::today())->where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->sum('amount');
            $data['today_expenses'] = number_format($data['today_expenses']);
            // deni = lend money + buy stock 
            $data['today_deni'] = CustomerDebt::whereDate('created_at', Carbon::today())->where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->where('debt_amount','>',0)->whereIn('status',['lend money','buy stock'])->sum('debt_amount');
            $data['today_deni'] = number_format($data['today_deni']);
            $data['today_refund'] = CustomerDebt::whereDate('created_at', Carbon::today())->where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->where('debt_amount','>',0)->where('status','refund')->sum('debt_amount');
            $data['today_refund'] = number_format($data['today_refund']);
            $data['today_paydebt'] = CustomerDebt::whereDate('created_at', Carbon::today())->where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->where('debt_amount','>',0)->where('status','pay debt')->sum('debt_amount');
            $data['today_paydebt'] = number_format($data['today_paydebt']);
            // negative inachukua weka pesa status na buy stock
            $data['today_ameweka'] = CustomerDebt::whereDate('created_at', Carbon::today())->where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->where('debt_amount','<',0)->whereIn('status',['buy stock','weka pesa'])->sum('debt_amount');
            $data['today_ameweka'] = number_format(abs($data['today_ameweka']));
            return response()->json(['data'=>$data]);
        }
    }

    public function expenses_summary($shop_id) {
        $data['today_expenses'] = ShopExpense::whereDate('created_at', Carbon::today())->where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->sum('amount');
        $data['week_expenses'] = ShopExpense::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->sum('amount');
        $data['month_expenses'] = ShopExpense::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->sum('amount');
        $data['today_expenses'] = number_format($data['today_expenses']);
        $data['week_expenses'] = number_format($data['week_expenses']);
        $data['month_expenses'] = number_format($data['month_expenses']);
        return response()->json(['data'=>$data]);
    }

    public function orders($orders,$sid) {
        $output = array();        
        $isCashier = \DB::connection('tenant')->table('user_shops')->where('user_id',Auth::user()->id)->where('shop_id',$sid)->where('who','cashier')->first();
        if ($orders == "pendingorders") {            
            if ($isCashier) {
                $orders = Sale::where('shop_id',$sid)->where('company_id',Auth::user()->company_id)->where('status','order')->groupBy('sale_no')->orderBy('updated_at','desc')->selectRaw('*, sum(quantity) as sumQ, sum(sub_total) as sumP')->get();
            } else {
                $orders = Sale::where('shop_id',$sid)->where('company_id',Auth::user()->company_id)->where('ordered_by',Auth::user()->id)->where('status','order')->groupBy('sale_no')->orderBy('updated_at','desc')->selectRaw('*, sum(quantity) as sumQ, sum(sub_total) as sumP')->get();
            }
            if ($orders->isNotEmpty()) {
                foreach($orders as $value) {
                    $custom_no = "";
                    if ($value->custom_no) {
                        $custom_no = " - ".$value->custom_no;
                    }
                    $output[] = '<tr class="or-'.$value->sale_no.'"><td><b><a href="#" class="order-items" order="'.$value->sale_no.'">'.$value->sale_no.$custom_no.'</a></b></td><td>'.sprintf('%g',$value->sumQ).'</td><td>'.number_format($value->sumP).'</td></tr>';
                }
            }       
            return response()->json(['items'=>$output]);     
        }
        if ($orders == "soldorders") {
            $ssi = explode("~",$sid); // sid contains shop_id, fromdate and todate
            $sid = $ssi[0]; 
            $fromdate = $ssi[1]; 
            $todate = $ssi[2]; 
            $fromdate = date("Y-m-d 00:00:00", strtotime($fromdate));
            $todate = date("Y-m-d 23:59:59", strtotime($todate));
            if ($isCashier) {
                $orders = Sale::whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->where('shop_id',$sid)->where('company_id',Auth::user()->company_id)->where('status','sold')->where('is_order','yes')->groupBy('sale_no')->orderBy('updated_at','desc')->selectRaw('*, sum(quantity) as sumQ, sum(sub_total) as sumP')->get();
            } else {
                $orders = Sale::whereBetween('updated_at', [Carbon::parse($fromdate),Carbon::parse($todate)])->where('shop_id',$sid)->where('company_id',Auth::user()->company_id)->where('ordered_by',Auth::user()->id)->where('status','sold')->where('is_order','yes')->groupBy('sale_no')->groupBy('sale_no')->orderBy('updated_at','desc')->selectRaw('*, sum(quantity) as sumQ, sum(sub_total) as sumP')->get();
            }
            if ($orders->isNotEmpty()) {
                foreach($orders as $value) {
                    $custom_no = "";
                    if ($value->custom_no) {
                        $custom_no = " - ".$value->custom_no;
                    }
                    $output[] = '<tr class="ors-'.$value->sale_no.'"><td><b><a href="#" class="order-items" order="'.$value->sale_no.'">'.$value->sale_no.$custom_no.'</a></b></td><td>'.sprintf('%g',$value->sumQ).'</td><td>'.number_format($value->sumP).'</td></tr>';
                }
            }
            return response()->json(['items'=>$output]);
        }
        if($orders == "count-pending-orders") {
            $orders = Sale::where('shop_id',$sid)->where('company_id',Auth::user()->company_id)->where('status','order')->groupBy('sale_no')->count();
            return response()->json(['total'=>$orders]);
        }
    }

    public function order_items($check,$ono) { 

        if ($check == "list") {
            $output = array(); 
            $output2 = array(); 
            $data['totaloQ'] = 0;
            $data['totaloP'] = 0;
            $data['creator'] = "";
            
            $sales = Sale::query()->select([
                        DB::raw('sales.id as sid, products.name as pname, users.id as uid, users.name as uname, customers.name as cname, quantity, selling_price as sprice, sub_total as stotal, custom_no, sale_no as saleno, paid_amount, sales.status as status')
                    ])
                    ->join('products','products.id','sales.product_id')
                    ->join('users','users.id','sales.ordered_by')
                    ->leftJoin('customers', function ($join) {
                        $join->on('customers.id','=','sales.customer_id');
                    })
                    ->where('sale_no',$ono)->where('sales.status','order')->get();

            return response()->json(['sales'=>$sales]);   

            // $sale = Sale::where('sale_no',$ono)->where('company_id',Auth::user()->company_id)->first();
            // if ($rows->isNotEmpty()) {
            //     $shop = Shop::find($sale->shop_id);
            //     if($shop->change_s_price == "no") {
            //         $disabled3 = "disabled";
            //     } else {
            //         $disabled3 = "";
            //     }
            //     foreach($rows as $row) {
            //         $data['totaloQ'] = $data['totaloQ'] + $row->quantity;
            //         $data['totaloP'] = $data['totaloP'] + $row->sub_total;
            //         $data['custom_no'] = $row->custom_no;
            //         $data['saleno'] = $row->sale_no;
            //         $paid_amount = $row->paid_amount;
            //         $data['paidamount'] = number_format($paid_amount);
            //         if($row->orderedBy) {
            //             $data['creator'] = $row->orderedBy->name;
            //         }                    
            //         if($row->customer) {
            //             $data['customer'] = $row->customer->name;
            //         }                    
            //         $data['status'] = $row->status;
            //         $sub_total = number_format($data['totaloP']);
            //         $disabled2 = "";
            //         $clear = "";
            //         if ($row->ordered_by == Auth::user()->id) {
            //             $disabled = "";                    
            //             $data['canchange'] = "yes";
            //         } else {
            //             $disabled = "disabled";
            //             $data['canchange'] = "no";
            //         }
            //         if ($row->status == "sold") {
            //             $output[] = '<tr class="sor-'.$row->id.'"><th style="width:50% !important">'
            //             .'<div class="r-name">'.$row->product->name.'</div></th>'
            //             .'<th style="width:15% !important"><div align="center">'.sprintf('%g',$row->quantity).'</div></th>'
            //             .'<th style="width:35% !important"><div class="" align="right">  <span><b class="totaloP-'.$row->id.'">'.number_format($row->sub_total, 0).'</b></span></div>'
            //             .'</th></tr>';
            //         } else {
            //             $clear = "<span class='pull-right text-danger remove-sor' val='".$row->id."' style='cursor: pointer;font-size:1.2rem;'><i class='fa fa-times'></i></span>";
            //             $output[] = '<tr class="sor-'.$row->id.'"><td><div class="row py-1">'
            //             .'<div class="col-12 r-name">'.$row->product->name.''.$clear.'</div>'
            //             .'<div class="col-12" align="right"> <span><input type="number" class="form-control soquantity" name="quantity" value="'.sprintf('%g',$row->quantity).'" rid="'.$row->id.'" '.$disabled.' '.$disabled2.'></span> <span><i class="fa fa-times"></i></span> <span><input type="number" class="form-control soprice" name="price" value="'.round($row->selling_price, 0).'" rid="'.$row->id.'" '.$disabled.' '.$disabled2.' '.$disabled3.' style="display:inline-block"></span> <span>=</span> <span><b class="totaloP-'.$row->id.'">'.number_format($row->sub_total, 0).'</b></span></div>'
            //             .'</div></td></tr>';
                        
            //             $output2[] = '<tr class="sor-'.$row->id.'"><td><div class="row">'
            //             .'<div class="col-12 r-name">'.$row->product->name.'</div>'
            //             .'<div class="col-12" align="right"> <span>'.sprintf('%g',$row->quantity).'</span> <span>x</span> <span>'.round($row->selling_price, 0).'</span> <span>=</span> <span><b class="totaloP-'.$row->id.'">'.number_format($row->sub_total, 0).'</b></span></div>'
            //             .'</div></td></tr>';
            //         }
            //         // $output[] = "<tr class='sor-".$row->id."'><td>".$row->product->name."</td><td><input type='number' class='form-control soquantity' name='quantity' value='".$row->quantity."' rid='".$row->id."' ".$disabled." ".$disabled2."></td><td><input type='number' class='form-control soprice' name='price' value='".round($row->selling_price,0)."' rid='".$row->id."' ".$disabled." ".$disabled2."></td><td class='totaloP-".$row->id."'>".number_format($row->sub_total)."</td><td>".$clear."</td></tr>";

            //     }   
            //     $change = ($paid_amount - $data['totaloP']);
            //     $data['change'] = number_format($change);
            //     return response()->json(['items'=>$output,'items2'=>$output2,'data'=>$data,'subtotal'=>$sub_total]);         
            // } else {
            //     return response()->json(['error'=>"Sorry! this order is empty."]);     
            // }          
        }
        if ($check == "receipt-preview") {
            $sales = Sale::query()->select([
                        DB::raw('sales.id as sid, products.name as pname, quantity, selling_price as sprice, sub_total as stotal,  sale_no as saleno, sales.status as status')
                    ])
                    ->join('products','products.id','sales.product_id')
                    ->where('sale_no',$ono)->where('sales.status','sold')->get();

            return response()->json(['sales'=>$sales]);   
        }   
        if ($check == "list-bkp") { // this is no longer used
            $output = array(); 
            $output2 = array(); 
            $data['totaloQ'] = 0;
            $data['totaloP'] = 0;
            $data['creator'] = "";
            $sale = Sale::where('sale_no',$ono)->where('company_id',Auth::user()->company_id)->first();
            $rows = Sale::where('sale_no',$ono)->where('company_id',Auth::user()->company_id)->whereIn('status',['order','sold'])->get();
            if ($rows->isNotEmpty()) {
                $shop = Shop::find($sale->shop_id);
                if($shop->change_s_price == "no") {
                    $disabled3 = "disabled";
                } else {
                    $disabled3 = "";
                }
                foreach($rows as $row) {
                    $data['totaloQ'] = $data['totaloQ'] + $row->quantity;
                    $data['totaloP'] = $data['totaloP'] + $row->sub_total;
                    $data['custom_no'] = $row->custom_no;
                    $data['saleno'] = $row->sale_no;
                    $paid_amount = $row->paid_amount;
                    $data['paidamount'] = number_format($paid_amount);
                    if($row->orderedBy) {
                        $data['creator'] = $row->orderedBy->name;
                    }                    
                    if($row->customer) {
                        $data['customer'] = $row->customer->name;
                    }                    
                    $data['status'] = $row->status;
                    $sub_total = number_format($data['totaloP']);
                    $disabled2 = "";
                    $clear = "";
                    if ($row->ordered_by == Auth::user()->id) {
                        $disabled = "";                    
                        $data['canchange'] = "yes";
                    } else {
                        $disabled = "disabled";
                        $data['canchange'] = "no";
                    }
                    if ($row->status == "sold") {
                        $output[] = '<tr class="sor-'.$row->id.'"><th style="width:50% !important">'
                        .'<div class="r-name">'.$row->product->name.'</div></th>'
                        .'<th style="width:15% !important"><div align="center">'.sprintf('%g',$row->quantity).'</div></th>'
                        .'<th style="width:35% !important"><div class="" align="right">  <span><b class="totaloP-'.$row->id.'">'.number_format($row->sub_total, 0).'</b></span></div>'
                        .'</th></tr>';
                    } else {
                        $clear = "<span class='pull-right text-danger remove-sor' val='".$row->id."' style='cursor: pointer;font-size:1.2rem;'><i class='fa fa-times'></i></span>";
                        $output[] = '<tr class="sor-'.$row->id.'"><td><div class="row py-1">'
                        .'<div class="col-12 r-name">'.$row->product->name.''.$clear.'</div>'
                        .'<div class="col-12" align="right"> <span><input type="number" class="form-control soquantity" name="quantity" value="'.sprintf('%g',$row->quantity).'" rid="'.$row->id.'" '.$disabled.' '.$disabled2.'></span> <span><i class="fa fa-times"></i></span> <span><input type="number" class="form-control soprice" name="price" value="'.round($row->selling_price, 0).'" rid="'.$row->id.'" '.$disabled.' '.$disabled2.' '.$disabled3.' style="display:inline-block"></span> <span>=</span> <span><b class="totaloP-'.$row->id.'">'.number_format($row->sub_total, 0).'</b></span></div>'
                        .'</div></td></tr>';
                        
                        $output2[] = '<tr class="sor-'.$row->id.'"><td><div class="row">'
                        .'<div class="col-12 r-name">'.$row->product->name.'</div>'
                        .'<div class="col-12" align="right"> <span>'.sprintf('%g',$row->quantity).'</span> <span>x</span> <span>'.round($row->selling_price, 0).'</span> <span>=</span> <span><b class="totaloP-'.$row->id.'">'.number_format($row->sub_total, 0).'</b></span></div>'
                        .'</div></td></tr>';
                    }
                    // $output[] = "<tr class='sor-".$row->id."'><td>".$row->product->name."</td><td><input type='number' class='form-control soquantity' name='quantity' value='".$row->quantity."' rid='".$row->id."' ".$disabled." ".$disabled2."></td><td><input type='number' class='form-control soprice' name='price' value='".round($row->selling_price,0)."' rid='".$row->id."' ".$disabled." ".$disabled2."></td><td class='totaloP-".$row->id."'>".number_format($row->sub_total)."</td><td>".$clear."</td></tr>";

                }   
                $change = ($paid_amount - $data['totaloP']);
                $data['change'] = number_format($change);
                return response()->json(['items'=>$output,'items2'=>$output2,'data'=>$data,'subtotal'=>$sub_total]);         
            } else {
                return response()->json(['error'=>"Sorry! this order is empty."]);     
            }          
        }   
        if ($check == "list-printable") {
            $output = array(); 
            $data['totaloQ'] = 0;
            $data['totaloP'] = 0;
            $data['creator'] = "";
            $ssi = explode("~",$ono);
            $ono = $ssi[0]; 
            $custom_ono = $ssi[1]; 
            $check = Sale::where('sale_no',$ono)->where('company_id',Auth::user()->company_id)->first();
            if ($check->status != "sold") {
                if ($custom_ono) {
                    Sale::where('sale_no',$ono)->where('company_id',Auth::user()->company_id)->update(['custom_no'=>$custom_ono]);
                }
            }
            $rows = Sale::where('sale_no',$ono)->where('company_id',Auth::user()->company_id)->whereIn('status',['order','sold'])->get();
            if ($rows->isNotEmpty()) {
                foreach($rows as $row) {
                    $data['totaloQ'] = $data['totaloQ'] + $row->quantity;
                    $data['totaloP'] = $data['totaloP'] + $row->sub_total;
                    if($row->orderedBy) {
                        $data['creator'] = $row->orderedBy->name;
                    }                    
                    if($row->customer) {
                        $data['customer'] = $row->customer->name;
                    }                    
                    $data['status'] = $row->status;
                    $sub_total = number_format($data['totaloP']); 

                    $output[] = '<tr class="sor-'.$row->id.'"><td><div class="row">'
                    .'<div class="col-12 r-name">'.$row->product->name.'</div>'
                    .'<div class="col-12" align="right"> <span>'.sprintf('%g',$row->quantity).'</span> <span>x</span> <span>'.round($row->selling_price, 0).'</span> <span>=</span> <span><b class="totaloP-'.$row->id.'">'.number_format($row->sub_total, 0).'</b></span></div>'
                    .'</div></td></tr>';

                    // $output[] = '<tr class="sor-'.$row->id.'" style="font-size:3rem !important;font-color:#000 !important;border-bottom: 2px solid #000;"><td><div class="row">'
                    // .'<div class="col-12 r-name">'.$row->product->name.'</div>'
                    // .'<div class="col-12" align="right"> <span>'.$row->quantity.'</span> <span><i class="fa fa-times"></i></span> <span>'.round($row->selling_price, 0).'</span> <span>=</span> <span><b class="totaloP-'.$row->id.'">'.number_format($row->sub_total, 0).'</b></span></div>'
                    // .'</div></td></tr>';
                }   
                return response()->json(['items'=>$output,'data'=>$data,'subtotal'=>$sub_total]);         
            } else {
                return response()->json(['error'=>"Sorry! this order is empty."]);     
            }          
        }   
        if ($check == "delete") {
           $update = Sale::where('sale_no',$ono)->where('company_id',Auth::user()->company_id)->where('status','order')->update(['status'=>'deleted']);
           if ($update) {
               return response()->json(['success'=>"success",'ono'=>$ono]);
           } else {
               return response()->json(['error'=>"Sorry! Something not okay, please refresh the page first."]);
           }
        }
        if ($check == "sold") {
            // separate order number with paid amount
            $c_ono = null;
            $ssi = explode("~",$ono);
            $amount = $ssi[0];
            $ono = $ssi[1]; 
            $custom_ono = $ssi[2]; 
            $p_ids = array();
            $totalamount = 0;
            $company_id = Auth::user()->company_id;
            $customer_id = null;
            if ($custom_ono) {
                $c_ono = $custom_ono;
            }
            $data = $output = array();
            $items = Sale::where('sale_no',$ono)->where('company_id',$company_id)->where('status','order')->get();
            if ($items->isNotEmpty()) {

                $data['paidamount'] = number_format($amount);

                // check for minimum stock level 
                if(Session::get('min-stock-level') == "yes"){ $min_stock = "yes"; } else { $min_stock = "no"; }

                foreach($items as $item) {
                    $totalamount = $totalamount + $item->sub_total;
                    $shop_id = $item->shop_id;
                    $customer_id = $item->customer_id;
                    $q = DB::connection('tenant')->table('shop_products')->where('shop_id',$item->shop_id)->where('product_id',$item->product_id)->where('active','yes');
                    if ($q->first()) {
                        $update = $item->update(['custom_no'=>$c_ono,'paid_amount'=>$amount,'status'=>'sold','user_id'=>Auth::user()->id]);
                        $currQ = $q->first()->quantity;
                        $quantity = ($currQ - $item->quantity);
                        $q->update(['quantity'=>$quantity]);

                        Log::channel('custom')->info('PID: '.$item->product_id.', newQ = '.$quantity.' .. soldOrderQ = '.$item->quantity.' .. prevQ = '.$currQ);
                        
                        $output[] = '<tr><th style="width:50% !important">'
                        .'<div class="r-name">'.$item->product->name.'</div></th>'
                        .'<th style="width:15% !important"><div align="center">'.sprintf('%g',$item->quantity).'</div></th>'
                        .'<th style="width:35% !important"><div class="" align="right">  <span><b class="totaloP-'.$item->id.'">'.number_format($item->sub_total, 0).'</b></span></div>'
                        .'</th></tr>';
                        
                        if ($min_stock == "yes") {
                            $p_ids[] = $item->product_id;
                        }
                    }        
                }

                $data['totalamount'] = $totalamount;
                $data['change'] = ($amount - $totalamount);
                $data['change'] = number_format($data['change']);
                
                // add to customer debts table
                if ($customer_id != null) {
                    if ($amount != "-") {
                        $debt = $totalamount - $amount;
                        CustomerDebt::create(['shop_id'=>$shop_id,'customer_id'=>$customer_id,'debt_amount'=>$debt,'status'=>"buy stock",'stock_value'=>$totalamount,'amount_paid'=>$amount,'reference'=>$ono,'company_id'=>$company_id,'user_id'=>Auth::user()->id]);
                    }
                }
                return response()->json(['success'=>"success",'data'=>$data,'items'=>$output,'ono'=>$ono,'ids'=>$p_ids]);
           } else {
               return response()->json(['error'=>"Sorry! Something not okay, please refresh the page first."]);
           }
       }
        if ($check == "sold-order") {
            $output = array(); 
            $output2 = array(); 
            $data['totaloQ'] = 0;
            $data['totaloP'] = 0;
            $data['creator'] = "";
            
            $sales = Sale::query()->select([
                        DB::raw('sales.id as sid, products.name as pname, users.id as uid, users.name as uname, customers.name as cname, quantity, selling_price as sprice, sub_total as stotal, custom_no, sale_no as saleno, paid_amount, sales.status as status')
                    ])
                    ->join('products','products.id','sales.product_id')
                    ->join('users','users.id','sales.ordered_by')
                    ->leftJoin('customers', function ($join) {
                        $join->on('customers.id','=','sales.customer_id');
                    })
                    ->where('sale_no',$ono)->where('sales.status','sold')->get();

            return response()->json(['sales'=>$sales]);   
       }
    }

    public function remove_sale_row($check,$shop_id,$id) {
        $row = Sale::find($id);
        $delete = $row->delete();
        if ($delete) {
            if ($check == "sale") {
                $data['quantity'] = Sale::where('user_id',Auth::user()->id)->where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->where('status','draft')->sum('quantity');
                $data['price'] = Sale::where('user_id',Auth::user()->id)->where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->where('status','draft')->sum('sub_total');
                return response()->json(['success'=>'removed','id'=>$id,'data'=>$data]);
            }
            if ($check == "order") {
                $data['totaloQ'] = Sale::where('user_id',Auth::user()->id)->where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->where('sale_no',$row->sale_no)->sum('quantity');
                $data['totaloP'] = Sale::where('user_id',Auth::user()->id)->where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->where('sale_no',$row->sale_no)->sum('sub_total');
                $sub_total = number_format($data['totaloP']);
                $data['totaloP'] = round($data['totaloP'],0);
                return response()->json(['success'=>'removed','id'=>$id,'data'=>$data,'subtotal'=>$sub_total]);
            }
        } else {
            return response()->json(['error'=>'Error! Something wrong. Failed to clear row.']);
        }
    }

    public function update_sale_quantity($check,$shop_id,$id,$qty) {
        if ($qty > 0) {
            if ($check == "sale") {
                $sale = Sale::where('id',$id)->where('company_id',Auth::user()->company_id)->first();
                if ($sale) {
                    $total_buying = ($sale->buying_price * $qty);
                    $subtotal = ($sale->selling_price * $qty);
                    $data['subtotal'] = number_format($subtotal, 0);
                    $update = $sale->update(['quantity'=>$qty,'total_buying'=>$total_buying,'sub_total'=>$subtotal]);
                    $data['quantity'] = Sale::where('user_id',Auth::user()->id)->where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->where('status','draft')->sum('quantity');
                    $data['price'] = Sale::where('user_id',Auth::user()->id)->where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->where('status','draft')->sum('sub_total');
                    return response()->json(['id'=>$id,'data'=>$data]);
                } 
            }
            if ($check == "order") {
                $sale = Sale::where('id',$id)->where('company_id',Auth::user()->company_id)->first();
                if ($sale) {
                    $total_buying = ($sale->buying_price * $qty);
                    $subtotal = ($sale->selling_price * $qty);
                    $data['subsubtotal'] = number_format($subtotal);
                    $update = $sale->update(['quantity'=>$qty,'total_buying'=>$total_buying,'sub_total'=>$subtotal]);
                    $data['totaloQ'] = Sale::where('user_id',Auth::user()->id)->where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->where('sale_no',$sale->sale_no)->sum('quantity');
                    $data['totaloP'] = Sale::where('user_id',Auth::user()->id)->where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->where('sale_no',$sale->sale_no)->sum('sub_total');
                    $sub_total = number_format($data['totaloP']);
                    $data['totaloP'] = round($data['totaloP'],0);
                    return response()->json(['success'=>'updated','id'=>$id,'data'=>$data,'subtotal'=>$sub_total]);
                }
            }
        }
    }

    public function update_sale_price($check,$shop_id,$id,$price) {
        if ($price > 0) {
            if ($check == "sale") {
                $sale = Sale::where('id',$id)->where('company_id',Auth::user()->company_id)->first();
                if ($sale) {
                    $subtotal = ($sale->quantity * $price);
                    $data['subtotal'] = number_format($subtotal, 0);
                    $update = $sale->update(['selling_price'=>$price,'sub_total'=>$subtotal]);
                    $data['price'] = Sale::where('user_id',Auth::user()->id)->where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->where('status','draft')->sum('sub_total');
                    return response()->json(['id'=>$id,'data'=>$data]);
                } 
            }
            if ($check == "order") {
                $sale = Sale::where('id',$id)->where('company_id',Auth::user()->company_id)->first();
                if ($sale) {
                    $subtotal = ($sale->quantity * $price);
                    $data['subsubtotal'] = number_format($subtotal);
                    $update = $sale->update(['selling_price'=>$price,'sub_total'=>$subtotal]);
                    $data['totaloP'] = Sale::where('user_id',Auth::user()->id)->where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->where('sale_no',$sale->sale_no)->sum('sub_total');
                    $sub_total = number_format($data['totaloP']);
                    $data['totaloP'] = round($data['totaloP'],0);
                    return response()->json(['success'=>'updated','id'=>$id,'data'=>$data,'subtotal'=>$sub_total]);
                } 
            }
        }
    }

    public function clear_sale_cart($shop_id) {
        $delete = Sale::where('shop_id',$shop_id)->where('company_id',Auth::user()->company_id)->where('user_id',Auth::user()->id)->where('status','draft')->delete();
        if ($delete) {
            return response()->json(['success'=>'success']);
        }
    }

    public function update_cutomer_onsale($shop_id,$customer_id) {
        if ($customer_id == 'null') {
            $customer_id = null;
        }
        $item = Sale::where('shop_id',$shop_id)->where('company_id',Auth::user()->company_id)->where('user_id',Auth::user()->id)->where('status','draft');
        if ($item->first()) {
            Sale::where('shop_id',$shop_id)->where('company_id',Auth::user()->company_id)->where('user_id',Auth::user()->id)->where('status','draft')->update(['customer_id'=>$customer_id]);
            $customer = Customer::where('id',$item->first()->customer_id)->where('company_id',Auth::user()->company_id)->first();
            return response()->json(['success'=>'success','customer'=>$customer]);
        }
    }

    public function submit_sale_cart($check2,$shop_id,$amount){
        $ad = explode("~",$amount); // amount = paid amount and sale date
        $amount = $ad[0]; 
        $saledate = $ad[1]; 
        $curtime = date('H:i:s');
        $saledate = date("Y-m-d H:i:s", strtotime($saledate.$curtime));
        $check = Sale::where('status','!=','draft')->groupBy('sale_val')->where('company_id',Auth::user()->company_id)->orderBy('sale_val','desc')->first();
        $rows = Sale::where('user_id',Auth::user()->id)->where('shop_id',$shop_id)->where('company_id',Auth::user()->company_id)->where('status','draft')->get();
        if ($check) {
            $val = ($check->sale_val + 1);
            $val = "0".$val;
            $s_no = "SLN".Auth::user()->id.$val;
        } else {
            $val = "01";
            $s_no = "SLN".Auth::user()->id.$val;
        }
        $data = array();
        if ($rows->isNotEmpty()) {
            if ($check2 == "sale") {
                // checking for minimum stock level 
                if(Auth::user()->company->isCheckingStockLevel()){ $min_stock = "yes"; } else { $min_stock = "no"; }

                foreach($rows as $row) {
                    $submitted_at = date('Y-m-d H:i:s');
                    $q = DB::connection('tenant')->table('shop_products')->where('shop_id',$row->shop_id)->where('product_id',$row->product_id)->where('active','yes');
                    if ($q->first()) {
                        $row->update(['sale_no'=>$s_no,'sale_val'=>$val,'paid_amount'=>$amount,'submitted_at'=>$submitted_at,'status'=>'sold','updated_at'=>$saledate]);
                        $currQ = $q->first()->quantity;
                        $quantity = ($currQ - $row->quantity);
                        $q->update(['quantity'=>$quantity]);

                        Log::channel('custom')->info('PID: '.$row->product_id.', newQ = '.$quantity.' .. sold_2Q = '.$row->quantity.' .. prevQ = '.$currQ);

                        if($min_stock == "yes") {          
                            $pro = \App\Product::find($row->product_id);                  
                            if($pro->min_stock_level >= $quantity) {
                                ProductController::insertMSL($pro->id,'shop',$row->shop->id,$pro->min_stock_level);
                            }
                        }
                    }   
                }
                // add to customer debts table
                $check3 = Sale::where('sale_no',$s_no)->where('company_id',Auth::user()->company_id)->first();
                if ($check3->customer_id) {
                    $subtotal = Sale::where('sale_no',$s_no)->where('company_id',Auth::user()->company_id)->sum('sub_total');
                    if ($amount != "-") {
                        $debt = $subtotal - $amount;
                        CustomerDebt::create(['shop_id'=>$check3->shop_id,'customer_id'=>$check3->customer_id,'debt_amount'=>$debt,'status'=>"buy stock",'stock_value'=>$subtotal,'amount_paid'=>$amount,'reference'=>$check3->sale_no,'company_id'=>Auth::user()->company_id,'user_id'=>Auth::user()->id,'updated_at'=>$saledate]);
                    }
                }

                $data['predate'] = "no";
                if($ad[1] != date('d-m-Y')) { // check if adding for previous date, then update DailySale table
                    $data['predate'] = $ad[1];
                }
                return response()->json(['success'=>'Success! Sale submitted successfully.','saleno'=>$s_no,'data'=>$data]);
            }
            if ($check2 == "order") {
                foreach($rows as $row) {
                    $submitted_at = date('Y-m-d H:i:s');
                    $update = $row->update(['sale_no'=>$s_no,'sale_val'=>$val,'submitted_at'=>$submitted_at,'status'=>'order','is_order'=>'yes','ordered_by'=>Auth::user()->id,'updated_at'=>$saledate]);
                }
                $total_o = Sale::where('shop_id',$shop_id)->where('company_id',Auth::user()->company_id)->where('status','order')->groupBy('sale_no')->get()->count();
                return response()->json(['success'=>'Success! Order submitted successfully.','total'=>$total_o]);
            }
        }
    }

    public function submit_ava_cart($ecash,$acash,$shop_id) {
        $diff = $acash - $ecash;
        $create = ClosureSale::create(['expected_cash'=>$ecash,'submitted_cash'=>$acash,'difference'=>$diff,'company_id'=>Auth::user()->company_id,'shop_id'=>$shop_id,'closed_by'=>Auth::user()->id]);
        if ($create) {
            return response()->json(['success'=>'Success']);
        }
    }

    public function sales_by_date($from,$date,$month,$year,$shop_id) {
        // this function affects on cashier only for now
        $output = array();
        $output2 = array();
        $output3 = array();
        $data = array();
        $totalSQ = 0;
        $totalSP = 0;
        $deni = "";
        $i = 1;
        $date = $date.'-'.$month.'-'.$year;
        $date = date("Y-m-d", strtotime($date));
        $today = date("Y-m-d");
        if ($shop_id == 'all') {
            $items = Sale::whereDate('updated_at', $date)->where('status','sold')->where('company_id',Auth::user()->company_id)->orderBy('updated_at')->get();
            $totalSQ = Sale::whereDate('updated_at', $date)->where('status','sold')->where('company_id',Auth::user()->company_id)->orderBy('updated_at')->sum('quantity');  
            $totalSP = Sale::whereDate('updated_at', $date)->where('status','sold')->where('company_id',Auth::user()->company_id)->orderBy('updated_at')->sum('sub_total'); 
        } else {
            $data['deni'] = $data['ameweka'] = $data['tumelipa'] = $data['returned'] = $data['returned2'] = 0;
            if ($from == 'cashier-five-sold-items') {
                $items = Sale::query()->select([
                        DB::raw('sales.id as sid, products.name as pname, sales.quantity as sqty, sales.selling_price as sprice, sales.sub_total as tsales, sales.user_id as uid')
                    ])
                    ->join('products','products.id','sales.product_id')
                    ->whereDate('sales.updated_at', $date)->where('sales.shop_id',$shop_id)->where('sales.status','sold')->orderBy('sales.updated_at','desc')
                    ->get(); 
                $total = Sale::query()->select([
                        DB::raw('SUM(quantity) as totalQ, SUM(sub_total) as totalS, SUM(total_buying) as totalB')
                    ])
                    ->whereDate('updated_at', $date)->where('shop_id',$shop_id)->where('status','sold')
                    ->get(); 
                
                return response()->json(['items'=>$items,'total'=>$total,'data'=>$data]);
            } 
            if ($from == "today-sales") { // show all sales on sell products page
                $items = Sale::query()->select([
                        DB::raw('sales.id as sid, products.name as pname, sales.quantity as sqty, sales.selling_price as sprice, sales.sub_total as tsales, sales.user_id as uid')
                    ])
                    ->join('products','products.id','sales.product_id')
                    ->whereDate('sales.updated_at', $date)->where('sales.shop_id',$shop_id)->where('sales.status','sold')->orderBy('sales.updated_at','desc')
                    ->get(); 
                $data['is_ceo'] = Auth::user()->isCEOorAdmin();
                $data['uid'] = Auth::user()->id;
                
                return response()->json(['items'=>$items,'data'=>$data]);
            }
            if ($from == "cashier-15-sales") {
                $items = Sale::query()->select([
                        DB::raw('sales.id as sid, products.name as pname, sales.quantity as sqty, sales.selling_price as sprice, sales.sub_total as tsales, sales.user_id as uid, sales.updated_at as sdate')
                    ])
                    ->join('products','products.id','sales.product_id')
                    ->where('sales.shop_id',$shop_id)->where('sales.status','sold')->orderBy('sales.updated_at')->whereDate('sales.updated_at', $date)
                    ->limit(15)->get();
                $total = Sale::query()->select([
                        DB::raw('SUM(quantity) as totalQ, SUM(sub_total) as totalS')
                    ])
                    ->where('shop_id',$shop_id)->where('status','sold')->whereDate('updated_at', $date)
                    ->get(); 
                $data['count'] = Sale::whereDate('updated_at', $date)->where('shop_id',$shop_id)->where('status','sold')->count(); 
                // check expenses 
                $data['expenses'] = ShopExpense::whereDate('created_at', $date)->where('shop_id',$shop_id)->sum('amount');
                // check kama kuna mauzo yaliuzwa kwa deni
                $customerdeni = CustomerDebt::where('shop_id',$shop_id)->whereDate('updated_at', $date)->first();
                if ($customerdeni) {
                    $data['deni'] = CustomerDebt::where('shop_id',$shop_id)->whereDate('updated_at', $date)->whereIn('status',['buy stock','lend money'])->where('debt_amount','>',0)->sum('debt_amount');
                    $data['ameweka'] = CustomerDebt::where('shop_id',$shop_id)->whereDate('updated_at', $date)->whereIn('status',['buy stock','weka pesa'])->where('debt_amount','<',0)->sum('debt_amount');
                    $data['tumelipa'] = CustomerDebt::where('shop_id',$shop_id)->whereDate('updated_at', $date)->whereIn('status',['pay debt','refund'])->where('debt_amount','>',0)->sum('debt_amount');
                }
                // check kama kuna bidhaa zilirudishwa 
                $return = ReturnSoldItem::whereDate('updated_at', $date)->where('shop_id',$shop_id)->first();
                if ($return) {
                    $data['returned'] = ReturnSoldItem::query()->select([
                            DB::raw('return_sold_items.id as rid, DATE(return_sold_items.when_sold) as solddate, return_sold_items.quantity as rquantity, products.name as pname, DATE(return_sold_items.updated_at) as updated')
                        ])
                        ->join('products','products.id','return_sold_items.product_id')
                        ->whereDate('return_sold_items.updated_at', $date)->where('return_sold_items.shop_id',$shop_id)->where('return_sold_items.status','received')
                        ->get();
                    $data['returned2'] = ReturnSoldItem::query()->select([
                            DB::raw('return_sold_items.id as rid, return_sold_items.quantity as rquantity, products.name as pname, DATE(return_sold_items.updated_at) as updated')
                        ])
                        ->join('products','products.id','return_sold_items.product_id')
                        ->whereDate('return_sold_items.when_sold', $date)->where('return_sold_items.shop_id',$shop_id)->where('return_sold_items.status','received')
                        ->get();
                }
                $data['is_ceo'] = Auth::user()->isCEOorAdmin();
                $data['uid'] = Auth::user()->id;
                return response()->json(['items'=>$items,'total'=>$total,'data'=>$data]);
            }           
            if ($from == "cashier-all-sales") { // show all sales on sales report page
                $items = Sale::query()->select([
                        DB::raw('sales.id as sid, products.name as pname, sales.quantity as sqty, sales.selling_price as sprice, sales.sub_total as tsales, sales.user_id as uid, sales.updated_at as sdate')
                    ])
                    ->join('products','products.id','sales.product_id')
                    ->whereDate('sales.updated_at', $date)->where('sales.shop_id',$shop_id)->where('sales.status','sold')
                    ->orderBy('sales.updated_at')->get();
                $data['is_ceo'] = Auth::user()->isCEOorAdmin();
                $data['uid'] = Auth::user()->id;
                return response()->json(['items'=>$items,'data'=>$data]);
            }      
            if ($from == "cashier-view-changed") {
                $items = Sale::query()->select([
                        DB::raw('sales.id as sid, products.name as pname, sales.quantity as sqty, sales.selling_price as sprice, sales.sub_total as tsales, sales.user_id as uid, sales.updated_at as sdate')
                    ])
                    ->join('products','products.id','sales.product_id')
                    ->whereDate('sales.updated_at', $date)->where('sales.shop_id',$shop_id)->where('sales.status','sold')
                    ->orderBy('sales.updated_at')->get();
                $data['is_ceo'] = Auth::user()->isCEOorAdmin();
                $data['uid'] = Auth::user()->id;
                return response()->json(['items'=>$items,'data'=>$data]);
            }     
        }
        // only items with sold status: ignore edited,draft and deleted statuses 
        // if ($items->isNotEmpty()) {
        //     foreach ($items as $value) {
        //         if ($from == 'business-owner') {
        //             $tr = '<td>'.$value->shop->name.'</td>';
        //         } else {
        //             if(Auth::user()->isCEOorAdmin()) {
        //                 $tr = '<span class="p-1 pull-right text-danger edit-sr" val="'.$value->id.'" style="cursor: pointer;"><i class="fa fa-pencil-square-o" style="font-size:1.5rem;"></i></span>';
        //             } else {
        //                 if ($date == $today && Auth::user()->id == $value->user_id) {
        //                     $tr = '<span class="p-1 pull-right text-danger edit-sr" val="'.$value->id.'" style="cursor: pointer;"><i class="fa fa-pencil-square-o" style="font-size:1.5rem;"></i></span>';
        //                 } else { 
        //                     $tr = '';                  
        //                 }
        //             }
        //         }

        //         $data['last_r'] = $value->id;
        //         $output[] = '<tr class="sr-'.$value->id.'"><td><div class="row py-1">'
        //         .'<div class="col-12 r-name">'.$i.'). '.$value->product->name.''.$tr.'</div>'
        //         .'<div class="col-12" style="font-size:1rem" align="right"> <span>'.sprintf('%g',$value->quantity).'</span> <span><i class="fa fa-times"></i></span> <span>'.str_replace(".00", "", number_format($value->selling_price, 2)).'</span> <span>=</span><span><b>'.str_replace(".00", "", number_format($value->sub_total, 2)).'</b></span></div>'
        //         .'</div></td></tr>';
        //         $i++;
        //     }    

        // } else {
        //     $output[] = '<tr><td colspan="6"><i>-- No Sales --</i></td></tr>';
        // }    

        // $totalSQ = sprintf('%g',$totalSQ);
        // $totalSP = $totalSP;

        // check expenses 
        // $expenses = ShopExpense::where('company_id',Auth::user()->company_id)->whereDate('created_at', $date)->where('shop_id',$shop_id)->sum('amount');
        // $expenses = number_format($expenses);
        
        // check kama kuna mauzo yaliuzwa kwa deni
        // $deni = CustomerDebt::where('shop_id',$shop_id)->where('company_id',Auth::user()->company_id)->whereDate('updated_at', $date)->whereIn('status',['buy stock','lend money'])->where('debt_amount','>',0)->sum('debt_amount');
        // $deni = number_format($deni);
        // $ameweka = CustomerDebt::where('shop_id',$shop_id)->where('company_id',Auth::user()->company_id)->whereDate('updated_at', $date)->whereIn('status',['buy stock','weka pesa'])->where('debt_amount','<',0)->sum('debt_amount');
        // $ameweka = number_format(abs($ameweka));
        // $tumelipa = CustomerDebt::where('shop_id',$shop_id)->where('company_id',Auth::user()->company_id)->whereDate('updated_at', $date)->whereIn('status',['pay debt','refund'])->where('debt_amount','>',0)->sum('debt_amount');
        // $tumelipa = number_format($tumelipa);

        // returned items        
        // $items2 = ReturnSoldItem::whereDate('updated_at', $date)->where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->where('status','received')->get();
        // if ($items2->isNotEmpty()) {
        //     foreach($items2 as $value2) {
        //         if (date("Y-m-d", strtotime($value2->updated_at)) == $today) {
        //             $lrow = '<td><span class="p-1 text-danger remove-ri" val="'.$value2->id.'" style="cursor: pointer;"><i class="fa fa-times"></i></span></td>';
        //         } else {
        //             $lrow = "";
        //         }
        //         $output2[] = '<tr class="ri-'.$value2->id.'"><td>'.$value2->product->name.'</td>'
        //             .'<td>'.sprintf('%g',$value2->quantity).'</td>'
        //             .'<td class="align-right">'.date("d/m/Y", strtotime($value2->when_sold)).'</td>'
        //             .$lrow.'</tr>';
        //     }
        // }  
        // $items3 = ReturnSoldItem::whereDate('when_sold', $date)->where('shop_id',$shop_id)->where('company_id',Auth::user()->company_id)->where('status','received')->get();
        // if ($items3->isNotEmpty()) {
        //     foreach($items3 as $value3) {
        //         $output3[] = '<tr class="ri-'.$value3->id.'"><td>'.$value3->product->name.'</td>'
        //             .'<td>'.sprintf('%g',$value3->quantity).'</td>'
        //             .'<td class="align-right">'.date("d/m/Y", strtotime($value3->updated_at)).'</td></tr>';
        //     }
        // }
        // return response()->json(['items'=>$output,'items2'=>$output2,'items3'=>$output3,'totalSQ'=>$totalSQ,'totalSP'=>$totalSP,'deni'=>$deni,'ameweka'=>$ameweka,'tumelipa'=>$tumelipa,'expenses'=>$expenses,'data'=>$data]);
    }

    public function sales_by_date_with_customer($from,$date,$month,$year,$shop_id) {
        // this function affects on cashier only for now
        $data = array();
        $date = $date.'-'.$month.'-'.$year;
        $date = date("Y-m-d", strtotime($date));
        if ($from == "cashier-view-changed") {
            $sales = '';
            $customers = Sale::query()->select([
                    DB::raw('customers.id as cid, customers.name as cname')
                ])
                ->join('customers','customers.id','sales.customer_id')
                ->whereDate('sales.updated_at', $date)->whereNotNull('sales.customer_id')->where('sales.shop_id',$shop_id)->where('sales.status','sold')
                ->groupBy('sales.customer_id')->orderBy('sales.customer_id','desc')->get(); 
            if($customers->isNotEmpty()) {
                $sales = Sale::query()->select([
                        DB::raw('sales.customer_id as cid, sales.id as rid, products.name as pname, sales.quantity as squantity, sales.selling_price as sprice, sales.sub_total as tsales, DATE(sales.updated_at) as updated, sales.user_id as soldby')
                    ])
                    ->join('products','products.id','sales.product_id')
                    ->whereDate('sales.updated_at', $date)->whereNotNull('sales.customer_id')->where('sales.shop_id',$shop_id)->where('sales.status','sold')
                    ->orderBy('sales.customer_id','desc')->get(); 
            }
    
            return response()->json(['customers'=>$customers,'sales'=>$sales]);
        }

        if ($from == "cashier-no-customer") { // sales with no customer assigned 
            $sales = Sale::query()->select([
                DB::raw('sales.id as rid, products.name as pname, sales.quantity as squantity, sales.selling_price as sprice, sales.sub_total as tsales, DATE(sales.updated_at) as updated, sales.user_id as soldby')
            ])
            ->join('products','products.id','sales.product_id')
            ->whereDate('sales.updated_at', $date)->whereNull('sales.customer_id')->where('sales.shop_id',$shop_id)->where('sales.status','sold')
            ->orderBy('sales.updated_at','desc')->get(); 
            return response()->json(['sales'=>$sales]);
        }

        if ($from == "cashier-date-changed") {
            $sales = '';
            $data['deni'] = $data['ameweka'] = $data['tumelipa'] = $data['returned'] = $data['returned2'] = 0;
            $customers = Sale::query()->select([
                    DB::raw('customers.id as cid, customers.name as cname')
                ])
                ->join('customers','customers.id','sales.customer_id')
                ->whereDate('sales.updated_at', $date)->whereNotNull('sales.customer_id')->where('sales.shop_id',$shop_id)->where('sales.status','sold')
                ->groupBy('sales.customer_id')->orderBy('sales.customer_id','desc')->get(); 
            if($customers->isNotEmpty()) {
                $sales = Sale::query()->select([
                        DB::raw('sales.customer_id as cid, sales.id as rid, products.name as pname, sales.quantity as squantity, sales.selling_price as sprice, sales.sub_total as tsales, DATE(sales.updated_at) as updated, sales.user_id as soldby')
                    ])
                    ->join('products','products.id','sales.product_id')
                    ->whereDate('sales.updated_at', $date)->whereNotNull('sales.customer_id')->where('sales.shop_id',$shop_id)->where('sales.status','sold')
                    ->orderBy('sales.customer_id','desc')->get(); 
            }
            $total = Sale::query()->select([
                    DB::raw('SUM(quantity) as totalQ, SUM(sub_total) as totalS')
                ])
                ->whereDate('updated_at', $date)->where('shop_id',$shop_id)->where('status','sold')->where('company_id',Auth::user()->company_id)
                ->get(); 
            // check expenses 
            $data['expenses'] = ShopExpense::where('company_id',Auth::user()->company_id)->whereDate('created_at', $date)->where('shop_id',$shop_id)->sum('amount');
            // check kama kuna mauzo yaliuzwa kwa deni
            $customerdeni = CustomerDebt::where('shop_id',$shop_id)->where('company_id',Auth::user()->company_id)->whereDate('updated_at', $date)->first();
            if ($customerdeni) {
                $data['deni'] = CustomerDebt::where('shop_id',$shop_id)->where('company_id',Auth::user()->company_id)->whereDate('updated_at', $date)->whereIn('status',['buy stock','lend money'])->where('debt_amount','>',0)->sum('debt_amount');
                $data['ameweka'] = CustomerDebt::where('shop_id',$shop_id)->where('company_id',Auth::user()->company_id)->whereDate('updated_at', $date)->whereIn('status',['buy stock','weka pesa'])->where('debt_amount','<',0)->sum('debt_amount');
                $data['tumelipa'] = CustomerDebt::where('shop_id',$shop_id)->where('company_id',Auth::user()->company_id)->whereDate('updated_at', $date)->whereIn('status',['pay debt','refund'])->where('debt_amount','>',0)->sum('debt_amount');
            }
            // check kama kuna bidhaa zilirudishwa 
            $return = ReturnSoldItem::whereDate('updated_at', $date)->where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->first();
            if ($return) {
                $data['returned'] = ReturnSoldItem::query()->select([
                        DB::raw('return_sold_items.id as rid, DATE(return_sold_items.when_sold) as solddate, return_sold_items.quantity as rquantity, products.name as pname, DATE(return_sold_items.updated_at) as updated')
                    ])
                    ->join('products','products.id','return_sold_items.product_id')
                    ->whereDate('return_sold_items.updated_at', $date)->where('return_sold_items.company_id',Auth::user()->company_id)->where('return_sold_items.shop_id',$shop_id)->where('return_sold_items.status','received')
                    ->get();
                $data['returned2'] = ReturnSoldItem::query()->select([
                        DB::raw('return_sold_items.id as rid, return_sold_items.quantity as rquantity, products.name as pname, DATE(return_sold_items.updated_at) as updated')
                    ])
                    ->join('products','products.id','return_sold_items.product_id')
                    ->whereDate('return_sold_items.when_sold', $date)->where('return_sold_items.shop_id',$shop_id)->where('return_sold_items.company_id',Auth::user()->company_id)->where('return_sold_items.status','received')
                    ->get();
            }
            return response()->json(['customers'=>$customers,'sales'=>$sales,'total'=>$total,'data'=>$data]);
        }

        // $output = array();
        // $output2 = array();
        // $output3 = array();
        // $output4 = array();
        // $data = array();
        // $totalSQ = 0;
        // $totalSP = 0;
        // $deni = "";
        // $i = 1;
        // $today = date("Y-m-d");
        // $items = Sale::whereDate('updated_at', $date)->whereNull('customer_id')->where('shop_id',$shop_id)->where('status','sold')->where('company_id',Auth::user()->company_id)->orderBy('updated_at')->limit(15)->get(); 
        // $totalSQ = Sale::whereDate('updated_at', $date)->where('shop_id',$shop_id)->where('status','sold')->where('company_id',Auth::user()->company_id)->orderBy('updated_at')->sum('quantity'); 
        // $totalSP = Sale::whereDate('updated_at', $date)->where('shop_id',$shop_id)->where('status','sold')->where('company_id',Auth::user()->company_id)->orderBy('updated_at')->sum('sub_total'); 
        // // only items with sold status: ignore edited,draft and deleted statuses 
        // if ($data['citems']->isNotEmpty()) {
        //     foreach ($data['citems'] as $ci) {
        //         $cname = Customer::find($ci->customer_id);
        //         $output[] = '<tr><td class="pt-3"><div class="p-2" style="background:#fff;">'.$cname->name.'</div></td></tr>';
        //         $output[] = '<tbody class="cs-'.$ci->customer_id.'" style="display:block"><tr style="display:block" align="center"><td class="py-2"><i class="fa fa-spinner fa-spin"></i></td></tr></tbody>';
        //     }    
        // } 

        // if ($items->isNotEmpty()) {
        //     $data['last_l_r'] = Sale::whereDate('updated_at', $date)->whereNull('customer_id')->where('shop_id',$shop_id)->where('status','sold')->where('company_id',Auth::user()->company_id)->orderBy('id','desc')->first();             
        //     $output4[] = '<tr><td class="pt-3"><div class="p-2" style="background:#fff;">No Customer Assigned</div></td></tr>';
        //     foreach ($items as $value) {
        //         if ($from == 'business-owner') {
        //             $tr = '<td>'.$value->shop->name.'</td>';
        //         } else {
        //             if ($date == $today && Auth::user()->id == $value->user_id) {
        //                 $tr = '<span class="p-1 pull-right text-danger edit-sr" val="'.$value->id.'" style="cursor: pointer;"><i class="fa fa-pencil-square-o" style="font-size:1.5rem;"></i></span>';
        //             } else { 
        //                 $tr = '';                  
        //             }
        //         }

        //         $data['last_r'] = $value->id;
        //         $output4[] = '<tr class="sr-'.$value->id.'"><td><div class="row">'
        //         .'<div class="col-12 r-name">'.$i.'). '.$value->product->name.''.$tr.'</div>'
        //         .'<div class="col-12" style="font-size:1rem" align="right"> <span>'.sprintf('%g',$value->quantity).'</span> <span><i class="fa fa-times"></i></span> <span>'.str_replace(".00", "", number_format($value->selling_price, 2)).'</span> <span>=</span><span><b>'.str_replace(".00", "", number_format($value->sub_total, 2)).'</b></span></div>'
        //         .'</div></td></tr>';
        //         $i++;
        //     }    
        // } else {
        //     if($i == 1) {
        //         $output[] = '<tr><td colspan="6" align="center"><i>-- No Sales --</i></td></tr>';
        //     }            
        // }    

        // $totalSQ = sprintf('%g',$totalSQ);
        // $totalSP = $totalSP;

        // // check expenses 
        // $expenses = ShopExpense::where('company_id',Auth::user()->company_id)->whereDate('created_at', $date)->where('shop_id',$shop_id)->sum('amount');
        // $expenses = number_format($expenses);
        // // check kama kuna mauzo yaliuzwa kwa deni
        // $deni = CustomerDebt::where('shop_id',$shop_id)->where('company_id',Auth::user()->company_id)->whereDate('updated_at', $date)->whereIn('status',['buy stock','lend money'])->where('debt_amount','>',0)->sum('debt_amount');
        // $deni = number_format($deni);
        // $ameweka = CustomerDebt::where('shop_id',$shop_id)->where('company_id',Auth::user()->company_id)->whereDate('updated_at', $date)->whereIn('status',['buy stock','weka pesa'])->where('debt_amount','<',0)->sum('debt_amount');
        // $ameweka = number_format(abs($ameweka));
        // $tumelipa = CustomerDebt::where('shop_id',$shop_id)->where('company_id',Auth::user()->company_id)->whereDate('updated_at', $date)->whereIn('status',['pay debt','refund'])->where('debt_amount','>',0)->sum('debt_amount');
        // $tumelipa = number_format($tumelipa);

        // return response()->json(['items'=>$output,'items4'=>$output4,'totalSQ'=>$totalSQ,'totalSP'=>$totalSP,'deni'=>$deni,'ameweka'=>$ameweka,'tumelipa'=>$tumelipa,'expenses'=>$expenses,'data'=>$data]);
    }
    
    public function sales_by_date_with_sellers($from,$date,$month,$year,$shop_id) {
        // this function affects on cashier only for now
        $data = array();
        $date = $date.'-'.$month.'-'.$year;
        $date = date("Y-m-d", strtotime($date));
        if ($from == "cashier-date-changed") {
            $sales = '';
            $data['deni'] = $data['ameweka'] = $data['tumelipa'] = $data['returned'] = $data['returned2'] = 0;
            $sellers = Sale::query()->select([
                DB::raw('users.id as uid, users.name as uname, SUM(sales.sub_total) as tsales')
            ])
            ->join('users','users.id','sales.user_id')
            ->whereDate('sales.updated_at', $date)->where('sales.shop_id',$shop_id)->where('sales.status','sold')
            ->groupBy('sales.user_id')->get(); 
            if ($sellers->isNotEmpty()) {
                $sales = Sale::query()->select([
                    DB::raw('sales.user_id as uid, sales.id as rid, products.name as pname, sales.quantity as squantity, sales.selling_price as sprice, sales.sub_total as tsales, DATE(sales.updated_at) as updated')
                ])
                ->join('products','products.id','sales.product_id')
                ->whereDate('sales.updated_at', $date)->where('sales.shop_id',$shop_id)->where('sales.status','sold')
                ->orderBy('sales.updated_at')->get();
            }
            $total = Sale::query()->select([
                    DB::raw('SUM(quantity) as totalQ, SUM(sub_total) as totalS')
                ])
                ->whereDate('updated_at', $date)->where('shop_id',$shop_id)->where('status','sold')
                ->get(); 
            // check expenses 
            $data['expenses'] = ShopExpense::whereDate('created_at', $date)->where('shop_id',$shop_id)->sum('amount');
            // check kama kuna mauzo yaliuzwa kwa deni
            $customerdeni = CustomerDebt::where('shop_id',$shop_id)->whereDate('updated_at', $date)->first();
            if ($customerdeni) {
                $data['deni'] = CustomerDebt::where('shop_id',$shop_id)->whereDate('updated_at', $date)->whereIn('status',['buy stock','lend money'])->where('debt_amount','>',0)->sum('debt_amount');
                $data['ameweka'] = CustomerDebt::where('shop_id',$shop_id)->whereDate('updated_at', $date)->whereIn('status',['buy stock','weka pesa'])->where('debt_amount','<',0)->sum('debt_amount');
                $data['tumelipa'] = CustomerDebt::where('shop_id',$shop_id)->whereDate('updated_at', $date)->whereIn('status',['pay debt','refund'])->where('debt_amount','>',0)->sum('debt_amount');
            }
            // check kama kuna bidhaa zilirudishwa 
            $return = ReturnSoldItem::whereDate('updated_at', $date)->where('shop_id',$shop_id)->first();
            if ($return) {
                $data['returned'] = ReturnSoldItem::query()->select([
                        DB::raw('return_sold_items.id as rid, DATE(return_sold_items.when_sold) as solddate, return_sold_items.quantity as rquantity, products.name as pname, DATE(return_sold_items.updated_at) as updated')
                    ])
                    ->join('products','products.id','return_sold_items.product_id')
                    ->whereDate('return_sold_items.updated_at', $date)->where('return_sold_items.shop_id',$shop_id)->where('return_sold_items.status','received')
                    ->get();
                $data['returned2'] = ReturnSoldItem::query()->select([
                        DB::raw('return_sold_items.id as rid, return_sold_items.quantity as rquantity, products.name as pname, DATE(return_sold_items.updated_at) as updated')
                    ])
                    ->join('products','products.id','return_sold_items.product_id')
                    ->whereDate('return_sold_items.when_sold', $date)->where('return_sold_items.shop_id',$shop_id)->where('return_sold_items.status','received')
                    ->get();
            }

            return response()->json(['sellers'=>$sellers,'sales'=>$sales,'total'=>$total,'data'=>$data]);
        }

        if ($from == "cashier-view-changed") {
            $sales = '';
            $sellers = Sale::query()->select([
                DB::raw('users.id as uid, users.name as uname, SUM(sales.sub_total) as tsales')
            ])
            ->join('users','users.id','sales.user_id')
            ->whereDate('sales.updated_at', $date)->where('sales.shop_id',$shop_id)->where('sales.status','sold')
            ->groupBy('sales.user_id')->get(); 
            if ($sellers->isNotEmpty()) {
                $sales = Sale::query()->select([
                    DB::raw('sales.user_id as uid, sales.id as rid, products.name as pname, sales.quantity as squantity, sales.selling_price as sprice, sales.sub_total as tsales, DATE(sales.updated_at) as updated')
                ])
                ->join('products','products.id','sales.product_id')
                ->whereDate('sales.updated_at', $date)->where('sales.shop_id',$shop_id)->where('sales.status','sold')
                ->orderBy('sales.updated_at')->get();
            }

            return response()->json(['sellers'=>$sellers,'sales'=>$sales]);
        }
    }

    public function sales_by_date_with_payment_options($from,$date,$month,$year,$shop_id) {
        // this function affects on cashier only for now
        $data = array();
        $date = $date.'-'.$month.'-'.$year;
        $date = date("Y-m-d", strtotime($date));
        if ($from == "cashier-date-changed") {
            $sales = '';
            $data['deni'] = $data['ameweka'] = $data['tumelipa'] = $data['returned'] = $data['returned2'] = 0;
            $options = Sale::query()->select([
                DB::raw('payment_options.id as pid, payment_options.name as uname, SUM(sales.sub_total) as tsales')
            ])
            ->join('payment_options','payment_options.id','sales.payment_option_id')
            ->whereDate('sales.updated_at', $date)->where('sales.shop_id',$shop_id)->where('sales.status','sold')
            ->groupBy('sales.payment_option_id')->get(); 
            if ($options->isNotEmpty()) {
                $sales = Sale::query()->select([
                    DB::raw('sales.payment_option_id as pid, sales.id as rid, products.name as pname, sales.quantity as squantity, sales.selling_price as sprice, sales.sub_total as tsales, DATE(sales.updated_at) as updated')
                ])
                ->join('products','products.id','sales.product_id')
                ->whereDate('sales.updated_at', $date)->where('sales.shop_id',$shop_id)->where('sales.status','sold')
                ->orderBy('sales.updated_at')->get();
            }
            $total = Sale::query()->select([
                    DB::raw('SUM(quantity) as totalQ, SUM(sub_total) as totalS')
                ])
                ->whereDate('updated_at', $date)->where('shop_id',$shop_id)->where('status','sold')
                ->get(); 
            // check expenses 
            $data['expenses'] = ShopExpense::whereDate('created_at', $date)->where('shop_id',$shop_id)->sum('amount');
            // check kama kuna mauzo yaliuzwa kwa deni
            $customerdeni = CustomerDebt::where('shop_id',$shop_id)->whereDate('updated_at', $date)->first();
            if ($customerdeni) {
                $data['deni'] = CustomerDebt::where('shop_id',$shop_id)->whereDate('updated_at', $date)->whereIn('status',['buy stock','lend money'])->where('debt_amount','>',0)->sum('debt_amount');
                $data['ameweka'] = CustomerDebt::where('shop_id',$shop_id)->whereDate('updated_at', $date)->whereIn('status',['buy stock','weka pesa'])->where('debt_amount','<',0)->sum('debt_amount');
                $data['tumelipa'] = CustomerDebt::where('shop_id',$shop_id)->whereDate('updated_at', $date)->whereIn('status',['pay debt','refund'])->where('debt_amount','>',0)->sum('debt_amount');
            }
            // check kama kuna bidhaa zilirudishwa 
            $return = ReturnSoldItem::whereDate('updated_at', $date)->where('shop_id',$shop_id)->first();
            if ($return) {
                $data['returned'] = ReturnSoldItem::query()->select([
                        DB::raw('return_sold_items.id as rid, DATE(return_sold_items.when_sold) as solddate, return_sold_items.quantity as rquantity, products.name as pname, DATE(return_sold_items.updated_at) as updated')
                    ])
                    ->join('products','products.id','return_sold_items.product_id')
                    ->whereDate('return_sold_items.updated_at', $date)->where('return_sold_items.shop_id',$shop_id)->where('return_sold_items.status','received')
                    ->get();
                $data['returned2'] = ReturnSoldItem::query()->select([
                        DB::raw('return_sold_items.id as rid, return_sold_items.quantity as rquantity, products.name as pname, DATE(return_sold_items.updated_at) as updated')
                    ])
                    ->join('products','products.id','return_sold_items.product_id')
                    ->whereDate('return_sold_items.when_sold', $date)->where('return_sold_items.shop_id',$shop_id)->where('return_sold_items.status','received')
                    ->get();
            }

            return response()->json(['options'=>$options,'sales'=>$sales,'total'=>$total,'data'=>$data]);
        }

        if ($from == "cashier-view-changed") {
            $sales = '';
            $options = Sale::query()->select([
                DB::raw('payment_options.id as pid, payment_options.name as uname, SUM(sales.sub_total) as tsales')
            ])
            ->join('payment_options','payment_options.id','sales.payment_option_id')
            ->whereDate('sales.updated_at', $date)->where('sales.shop_id',$shop_id)->where('sales.status','sold')
            ->groupBy('sales.payment_option_id')->get(); 
            if ($options->isNotEmpty()) {
                $sales = Sale::query()->select([
                    DB::raw('sales.payment_option_id as pid, sales.id as rid, products.name as pname, sales.quantity as squantity, sales.selling_price as sprice, sales.sub_total as tsales, DATE(sales.updated_at) as updated')
                ])
                ->join('products','products.id','sales.product_id')
                ->whereDate('sales.updated_at', $date)->where('sales.shop_id',$shop_id)->where('sales.status','sold')
                ->orderBy('sales.updated_at')->get();
            }

            return response()->json(['options'=>$options,'sales'=>$sales]);
        }
    }


    public function sales_by_date_with_sale_numbers($from,$date,$month,$year,$shop_id) {
        // this function affects on cashier only for now
        $data = array();
        $date = $date.'-'.$month.'-'.$year;
        $date = date("Y-m-d", strtotime($date));
        if ($from == "cashier-date-changed") {
            $sales = "";
            $data['deni'] = $data['ameweka'] = $data['tumelipa'] = $data['returned'] = $data['returned2'] = 0;
            $snumbers = Sale::query()->select([
                DB::raw('sale_no as sale_no')
            ])
            ->whereDate('updated_at', $date)->where('shop_id',$shop_id)->where('status','sold')->where('company_id',Auth::user()->company_id)
            ->groupBy('sale_no')->get(); 
            if ($snumbers->isNotEmpty()) {
                $sales = Sale::query()->select([
                    DB::raw('sales.user_id as uid, sales.id as rid, sales.sale_no as sale_no, products.name as pname, sales.quantity as squantity, sales.selling_price as sprice, sales.sub_total as tsales, DATE(sales.updated_at) as updated')
                ])
                ->join('products','products.id','sales.product_id')
                ->whereDate('sales.updated_at', $date)->where('sales.shop_id',$shop_id)->where('sales.status','sold')
                ->orderBy('sales.updated_at')->get();
            }
            $total = Sale::query()->select([
                    DB::raw('SUM(quantity) as totalQ, SUM(sub_total) as totalS')
                ])
                ->whereDate('updated_at', $date)->where('shop_id',$shop_id)->where('status','sold')->where('company_id',Auth::user()->company_id)
                ->get(); 
            // check expenses 
            $data['expenses'] = ShopExpense::where('company_id',Auth::user()->company_id)->whereDate('created_at', $date)->where('shop_id',$shop_id)->sum('amount');
            // check kama kuna mauzo yaliuzwa kwa deni
            $customerdeni = CustomerDebt::where('shop_id',$shop_id)->where('company_id',Auth::user()->company_id)->whereDate('updated_at', $date)->first();
            if ($customerdeni) {
                $data['deni'] = CustomerDebt::where('shop_id',$shop_id)->where('company_id',Auth::user()->company_id)->whereDate('updated_at', $date)->whereIn('status',['buy stock','lend money'])->where('debt_amount','>',0)->sum('debt_amount');
                $data['ameweka'] = CustomerDebt::where('shop_id',$shop_id)->where('company_id',Auth::user()->company_id)->whereDate('updated_at', $date)->whereIn('status',['buy stock','weka pesa'])->where('debt_amount','<',0)->sum('debt_amount');
                $data['tumelipa'] = CustomerDebt::where('shop_id',$shop_id)->where('company_id',Auth::user()->company_id)->whereDate('updated_at', $date)->whereIn('status',['pay debt','refund'])->where('debt_amount','>',0)->sum('debt_amount');
            }
            // check kama kuna bidhaa zilirudishwa 
            $return = ReturnSoldItem::whereDate('updated_at', $date)->where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->first();
            if ($return) {
                $data['returned'] = ReturnSoldItem::query()->select([
                        DB::raw('return_sold_items.id as rid, DATE(return_sold_items.when_sold) as solddate, return_sold_items.quantity as rquantity, products.name as pname, DATE(return_sold_items.updated_at) as updated')
                    ])
                    ->join('products','products.id','return_sold_items.product_id')
                    ->whereDate('return_sold_items.updated_at', $date)->where('return_sold_items.company_id',Auth::user()->company_id)->where('return_sold_items.shop_id',$shop_id)->where('return_sold_items.status','received')
                    ->get();
                $data['returned2'] = ReturnSoldItem::query()->select([
                        DB::raw('return_sold_items.id as rid, return_sold_items.quantity as rquantity, products.name as pname, DATE(return_sold_items.updated_at) as updated')
                    ])
                    ->join('products','products.id','return_sold_items.product_id')
                    ->whereDate('return_sold_items.when_sold', $date)->where('return_sold_items.shop_id',$shop_id)->where('return_sold_items.company_id',Auth::user()->company_id)->where('return_sold_items.status','received')
                    ->get();
            }

            return response()->json(['snumbers'=>$snumbers,'sales'=>$sales,'total'=>$total,'data'=>$data]);
        }

        if ($from == "cashier-view-changed") {
            $sales = "";
            $snumbers = Sale::query()->select([
                DB::raw('sale_no as sale_no')
            ])
            ->whereDate('updated_at', $date)->where('shop_id',$shop_id)->where('status','sold')->where('company_id',Auth::user()->company_id)
            ->groupBy('sale_no')->get(); 
            if ($snumbers->isNotEmpty()) {
                $sales = Sale::query()->select([
                    DB::raw('sales.user_id as uid, sales.id as rid, sales.sale_no as sale_no, products.name as pname, sales.quantity as squantity, sales.selling_price as sprice, sales.sub_total as tsales, DATE(sales.updated_at) as updated')
                ])
                ->join('products','products.id','sales.product_id')
                ->whereDate('sales.updated_at', $date)->where('sales.shop_id',$shop_id)->where('sales.status','sold')
                ->orderBy('sales.updated_at')->get();
            }
            return response()->json(['snumbers'=>$snumbers,'sales'=>$sales]);
        }
    }

    public function edit_sale_form($id) {
        $rows = array();
        $row = Sale::where('id',$id)->where('company_id',Auth::user()->company_id)->first();        
        if ($row) {
            $data['id'] = $row->id;
            $data['qty'] = $row->quantity;
            $data['selling_price'] = $row->selling_price;
            $data['subtotal_b'] = $row->sub_total;
            $data['subtotal'] = str_replace(".00", "", number_format($row->sub_total, 2));
            // check if the sale has assigned customer with debt
            $debt = CustomerDebt::where('reference',$row->sale_no)->where('company_id',Auth::user()->company_id)->first();
            if ($debt) {
                if ($debt->customer) {
                    $data['customer'] = $debt->customer->name;
                    $data['paidamount'] = number_format($debt->amount_paid);
                }
                $sales = Sale::where('sale_no',$row->sale_no)->where('id','!=',$id)->where('company_id',Auth::user()->company_id)->where('status','sold')->get();
                if ($sales->isNotEmpty()) {
                    foreach($sales as $sale) {
                        // $rows[] = "<tr><td>".$sale->product->name."</td><td><input type='number' class='form-control quantity2' value='".$sale->quantity."' disabled></td><td><input type='number' class='form-control sprice2' value='".round($sale->selling_price,0)."' disabled></td><td>".number_format($sale->sub_total)."</td><td></td></tr>";

                        $rows[] = '<tr><td><div class="row">'
                        .'<div class="col-12 r-name">'.$sale->product->name.'</div>'
                        .'<div class="col-12" align="right"> <span><input type="number" class="form-control quantity2" value="'.sprintf('%g',$sale->quantity).'" disabled></span> <span><i class="fa fa-times"></i></span> <span><input type="number" class="form-control sprice2" value="'.round($sale->selling_price, 0).'" style="display:inline-block" disabled></span> <span>=</span> <span><b>'.number_format($sale->sub_total, 0).'</b></span></div>'
                        .'</div></td></tr>';
                    }
                }
                $data['totalqty'] = Sale::where('sale_no',$row->sale_no)->where('company_id',Auth::user()->company_id)->where('status','sold')->sum('quantity');
                $data['totalamount_b'] = Sale::where('sale_no',$row->sale_no)->where('company_id',Auth::user()->company_id)->where('status','sold')->sum('sub_total');
                $data['totalamount'] = number_format($data['totalamount_b']);
                $data['sale_no'] = $row->sale_no;
            }
            return response()->json(['pname'=>$row->product->name,'shopro'=>$row->product->shopProductRelation($row->shop_id),'data'=>$data,'rows'=>$rows]);
        } 
    }

    public function submit_edited_sale($id,$qty,$price) {
        $data = array();
        $row = Sale::where('id',$id)->where('company_id',Auth::user()->company_id)->first();
        if ($row) {
            if ($row->quantity == $qty && $row->selling_price == $price) {
                return response()->json(['success'=>'Nothing edited']);
            } else {
                $solddate = date("d-m-Y", strtotime($row->updated_at));
                $q = DB::connection('tenant')->table('shop_products')->where('shop_id',$row->shop_id)->where('product_id',$row->product_id)->where('active','yes');
                if ($q->first()) {
                    $edited_at = date('Y-m-d H:i:s');  
                    $total_buying = ($qty * $row->buying_price);    
                    $subtotal = $qty*$price;              
                    $diffQ = $row->quantity - $qty;
                    $update = \DB::connection('tenant')->table('sales')->where('id',$id)->where('company_id',Auth::user()->company_id)->update(['status'=>'edited']);
                    if ($update) {                        
                        $data = $row->replicate();
                        $data = $data->toArray();
                        $create = Sale::create($data);
                        $create->update(['quantity'=>$qty,'selling_price'=>$price,'total_buying'=>$total_buying,'sub_total'=>$subtotal,'edited_at'=>$edited_at,'edited_by'=>Auth::user()->id,'status'=>'sold','created_at'=>$row->created_at,'updated_at'=>$row->updated_at]);  
                        $currQ = $q->first()->quantity; 
                        $quantity = ($currQ + $diffQ);
                        $q->update(['quantity'=>$quantity]);   

                        Log::channel('custom')->info('PID: '.$row->product_id.', newQ = '.$quantity.' .. sold_DQ = '.$diffQ.' .. prevQ = '.$currQ);

                        $deni = CustomerDebt::where('reference',$row->sale_no)->where('company_id',Auth::user()->company_id)->first();
                        if ($deni) {
                            $stock_val = Sale::where('sale_no',$row->sale_no)->where('company_id',Auth::user()->company_id)->where('status','sold')->sum('sub_total');
                            $amount_paid = $deni->amount_paid;
                            $newdeni = $stock_val - $amount_paid;
                            $deni->update(['debt_amount'=>$newdeni,'stock_value'=>$stock_val]);
                        }
                    }
                }   
                
                $data['predate'] = "no";
                if ($solddate != date("d-m-Y")) { //check if deleting today sold item OR previous date
                    $data['predate'] = $solddate;
                }
                
                return response()->json(['success'=>'edited','data'=>$data]);
            }            
        }
    }

    public function expense_cost(Request $request) {
        $expense = ShopExpense::create(['shop_id' => $request->shop_id, 'expense_id' => $request->expense_id, 'amount' => $request->amount, 'description' => $request->description, 'company_id'=>Auth::user()->company_id, 'user_id' => Auth::user()->id]);
        if ($expense) {
            return redirect()->back()->with('success','Success! New expense record is submitted successfully.');
        } else {
            return redirect()->back()->with('error','Sorry! Something went wrong. Please try again.');
        }
    }

    public function edit_expense_cost(Request $request) {  // this is not used.. it is moved to HomeController - search = edit-submitted-expense    
        $row = ShopExpense::where('id',$request->row_id)->where('company_id',Auth::user()->company_id)->first();
        if ($row) {
            $expense = $row->update(['shop_id' => $request->shop_id, 'expense_id' => $request->expense_id, 'amount' => $request->eamount, 'description' => $request->edescription, 'user_id' => Auth::user()->id]);
        }
        
        if ($expense) {
            return redirect()->back()->with('success','Success! Expense record is updated successfully.');
        } else {
            return redirect()->back()->with('error','Sorry! Something went wrong. Please try again.');
        }
    }

    public function expenses_by_date($from,$date,$month,$year,$shop_id) {
        $data['from'] = $from;
        $output = array();
        $totalSQ = 0;
        $totalSP = 0;
        $i = 1;
        $date = $date.'-'.$month.'-'.$year;
        $data['date'] = $date = date("Y-m-d", strtotime($date));
        $data['today'] = $today = date("Y-m-d");

        $data['shopExpenses'] = ShopExpense::whereDate('created_at', $date)->where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->get();
        $data['sum'] = ShopExpense::whereDate('created_at', $date)->where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->sum('amount');

        $view = view('partials.expenses-cost', compact('data'))->render();   
          
        return response()->json(['view'=>$view]);
    }
    
    public function expenses_in_shop($from,$date,$month,$year,$shop_id) {
        $data['from'] = $from;
        $output = array();
        $totalSQ = 0;
        $totalSP = 0;
        $i = 1;
        $date = $date.'-'.$month.'-'.$year;
        $data['date'] = $date = date("Y-m-d", strtotime($date));
        $data['today'] = $today = date("Y-m-d");

        $data['shopExpenses'] = ShopExpense::whereDate('created_at', $date)->where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->get();
        $data['sum'] = ShopExpense::whereDate('created_at', $date)->where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->sum('amount');

        $view = view('partials.expenses-in-shop', compact('data'))->render();   
          
        return response()->json(['view'=>$view]);
    }

    public function expenses_by_id($id) {
        $row = ShopExpense::where('id',$id)->where('company_id',Auth::user()->company_id)->first();
        if ($row) {
            $data['id'] = $row->id;
            $data['expenseid'] = $row->expense_id;
            $data['amount'] = $row->amount;
            $data['description'] = $row->description;
        }          
        return response()->json(['data'=>$data]);
    }

    public function delete_expense($id) {
        $data = array();
        $row = ShopExpense::where('id',$id)->where('company_id',Auth::user()->company_id)->first();
        if ($row) {
            
            $solddate = date("d-m-Y", strtotime($row->created_at));
            $data['predate'] = "no";
            if ($solddate != date("d-m-Y")) { //check if deleting today sold item OR previous date
                $data['predate'] = $solddate;
            }

            $row->delete();
        }          
        return response()->json(['success'=>'success','data'=>$data]);
    }

}
 