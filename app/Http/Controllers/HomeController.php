<?php

namespace App\Http\Controllers; 

use DB;
use PDF;
use File;
use Image;
use Session;
use DateTime;
use DatePeriod;
use DateInterval;
use App\User;
use App\Role;
use App\Sale;
use App\Shop;
use App\Store;
use App\Delete;
use App\Company;
use App\Currency;
use App\Customer;
use App\Expense;
use App\Transfer;
use App\StockAdjustment;
use App\CustomerDebt;
use App\ShopExpense;
use App\ReturnSoldItem;
use App\NewStock;
use App\ClosureSale;
use App\Product;
use App\ProductCategory;
use App\AgentMonthlyPayment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\TenantService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
// use Illuminate\Support\Facades\Request;
use App\Http\Controllers\ProductController;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use Maestroerror\HeicToJpg;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        if (Auth::user()) {
            if (Auth::user()->roles()->get()->isNotEmpty()) {
                $toprole = Auth::user()->roles()->orderBy('id','asc')->first();

                if (!$toprole) { //check if has assigned to any role
                    return view('home');
                }

                if ($toprole->name == "Admin") {
                    return redirect('/admin');
                }
                
                if ($toprole->name == "Agent") {
                    return redirect('/agent');
                }

                if (Auth::user()->company_id) { //check if user has assigned to any company

                    $company = Company::find(Auth::user()->company_id);

                    Session::put('company_db', $company->dbname);

                    TenantService::connect($company->dbname);

                    if (!$toprole) { //check if has assigned to any role
                        return view('home');
                    }

                    if (Session::get('company')) {
                        // proceed
                    } else {                        
                        Session::put('company',['id'=>$company->id,'name'=>$company->name]);

                        // check for minimum stock level 
                        if(Auth::user()->company->isCheckingStockLevel()) { 
                            Session::put('min-stock-level','yes');
                        }
                    }

                    if ($toprole->name == "Business Owner") {
                        $shop = Shop::where('company_id',$company->id)->first();
                        if($shop) {
                            Session::put('role','Business Owner');
                            return redirect('/shops/'.$shop->id);
                        } else {
                            $store = Store::where('company_id',$company->id)->first();
                            if($store) {   
                                Session::put('role','Business Owner');
                                return redirect('/stores/'.$store->id);
                            }
                        }
                        // return redirect('/business-owner');
                    }

                    if ($toprole->name == "CEO") {
                        $shop = Shop::where('company_id',$company->id)->first();
                        if($shop) {                            
                            Session::put('role','CEO');
                            return redirect('/shops/'.$shop->id);
                        } else {
                            $store = Store::where('company_id',$company->id)->first();
                            if($store) {   
                                Session::put('role','CEO');
                                return redirect('/stores/'.$store->id);
                            }
                        }
                        // return redirect('/ceo');
                    } 
                    if ($toprole->name == "Cashier") {
                        $us = DB::connection('tenant')->table('user_shops')->where('user_id',Auth::user()->id)->where('who','cashier')->first();
                        if($us) {
                            Session::put('role','Cashier');
                            Session::put('shoid',$us->shop_id);
                            return redirect('/shops/'.$us->shop_id);
                        }
                        // return redirect('/cashier');
                    }
                    if ($toprole->name == "Sales Person") {
                        $us = DB::connection('tenant')->table('user_shops')->where('user_id',Auth::user()->id)->where('who','sale person')->first();
                        if($us) {
                            Session::put('role','Sales Person');
                            Session::put('shoid',$us->shop_id);
                            return redirect('/shops/'.$us->shop_id);
                        }
                        // return redirect('/sales-person');
                    }
                    if ($toprole->name == "Store Master") {
                        $us = DB::connection('tenant')->table('user_stores')->where('user_id',Auth::user()->id)->where('who','store master')->first();
                        if($us) {
                            Session::put('role','Store Master');
                            return redirect('/stores/'.$us->store_id);
                        }
                        // return redirect('/store-master');
                    }

                    return view('home');
                }                
                
            } else {
                return view('home');
            }
        } else {
            return view('home');
            // return redirect('/login');
        }        
    }

    public function submit_data(Request $request) {
        if ($request->status == "kopesha pesa") {
            $debt_amount = $request->kopesha_amount;
            $interest = $interest_amount = $amount_w_interest = null;
            if($request->purpose == "lend money") {
                if($request->interest && $request->interest != 0) {
                    $interest = $request->interest;
                    $interest_amount = $debt_amount * ($request->interest / 100);
                    $amount_w_interest = $debt_amount + $interest_amount;
                }
            }
            $add = CustomerDebt::create(['shop_id'=>$request->shop_k_h,'customer_id'=>$request->customer_k_h,'debt_amount'=>$debt_amount,'status'=>$request->purpose,'interest'=>$interest,'interest_amount'=>$interest_amount,'amount_with_interest'=>$amount_w_interest,'company_id'=>Auth::user()->company_id,'user_id'=>Auth::user()->id]);
            if ($add) {
                return response()->json(['success'=>'Success! Malipo yameongezwa kikamilifu.','shop_id'=>$request->shop_k_h,'customer_id'=>$request->customer_k_h]);
            } else {
                return response()->json(['error'=>'Error! Something wrong, please try again.']);
            }            
        }

        if ($request->status == "lipa hela") {
            $shop_id = $request->shop_l_h; $customer_id = $request->customer_l_h; $amount = $request->amount;
            $debt_amount = 0 - $amount;
            $add = CustomerDebt::create(['shop_id'=>$shop_id,'customer_id'=>$customer_id,'debt_amount'=>$debt_amount,'status'=>'weka pesa','amount_paid'=>$amount,'company_id'=>Auth::user()->company_id,'user_id'=>Auth::user()->id]);
            if ($add) {
                return response()->json(['success'=>'Success! Malipo yameongezwa kikamilifu.','shop_id'=>$shop_id,'customer_id'=>$customer_id]);
            } else {
                return response()->json(['error'=>'Error! Something wrong, please try again.']);
            }            
        }

        if ($request->status == "new company") {
            $add = Company::create(['name'=>$request->name,'status'=>$request->enabled,'cashier_stock_approval'=>'no','created_by'=>Auth::user()->id]);
            if ($add) {
                return response()->json(['status'=>'success']);
            } else {
                return response()->json(['status'=>'error']);
            }
        }

        if ($request->status == "upload products") {
            $request->validate([
                'products_file' => [
                    'required',
                    'file'
                ],
            ]);
            Session::put('shopstore',$request->shopstore);
            Session::put('sid',$request->sid);
            try {
                Excel::import(new \App\Imports\ProductImport, $request->file('products_file'));
                return response()->json(['status'=>'success']);
            } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
                 $failures = $e->failures();
                 $errors = "";
                 foreach ($failures as $failure) {
                    $errors = $errors."<br> Row no ".$failure->row().": ".$failure->errors()[0];
                    //  $failure->row(); // row that went wrong
                    //  $failure->attribute(); // either heading key (if using heading row concern) or column index
                    //  $failure->errors(); // Actual error messages from Laravel validator
                    //  $failure->values(); // The values of the row that has failed.
                 }
                 return response()->json(['status'=>'failures','errors'=>$errors]);
            }
                        
        }

        if ($request->status == "record min stock level") {
            $array = explode(",", $request->input('ids'));
            $details['ids'] = $array;
            $details['shop_id'] = $request->shop_id;

            dispatch(new \App\Jobs\UpdateMinimumStockLevel2($details));
        }

        if ($request->status == "update quantity after sale") {
            $details['saleno'] = $request->saleno;
            $details['shop_id'] = $request->shop_id;

            dispatch(new \App\Jobs\UpdateQuantityAfterSale($details));
        }

        if ($request->status == "search accounts") {
            if($request->type == "accounts") {
                $data['accounts'] = DB::table('companies')->where('name','like','%'.$request->name.'%')->limit(10)->get();
            }
            if($request->type == "users") {
                $data['users'] = DB::table('users')->where('username','like','%'.$request->name.'%')->limit(10)->get();
            }
            if($request->type == "shops") {
                $data['shops'] = DB::connection('tenant')->table('shops')->where('name','like','%'.$request->name.'%')->limit(10)->get();
            }

            return response()->json(['data'=>$data,'type'=>$request->type]);
        }

        if ($request->status == "new customer") {
            $customer = Customer::create(['name'=>$request->name,'gender'=>$request->gender,'phone'=>$request->phone,'location'=>$request->location,'status'=>'active','company_id'=>Auth::user()->company_id,'shop_id'=>$request->shopid,'user_id'=>Auth::user()->id]);
            if ($customer) {
                return response()->json(['status'=>'success','customer'=>$customer]);
            } else {
                return response()->json(['status'=>'error']);
            }
        }
        if ($request->status == "update weka pesa") {
            $row = \App\CustomerDebt::where('company_id',Auth::user()->company_id)->where('id',$request->eid)->where('status','weka pesa')->first();
            $neg_amount = '-'.$request->amount;
            if ($row) {
                $row->debt_amount = $neg_amount;
                $row->amount_paid = $request->amount;
                $row->timestamps = false; // update without changing updated_at
                $row->save();
                return response()->json(['status'=>'success']);
            } 
        }
        if ($request->status == "update debt paid") {
            $row = \App\CustomerDebt::where('company_id',Auth::user()->company_id)->where('id',$request->eid)->where('status','pay debt')->first();
            if ($row) {
                $row->debt_amount = $request->amount;
                $row->timestamps = false; // update without changing updated_at
                $row->save();
                return response()->json(['status'=>'success']);
            } 
        }
        if ($request->status == "update refund") {
            $row = \App\CustomerDebt::where('company_id',Auth::user()->company_id)->where('id',$request->eid)->where('status','refund')->first();
            if ($row) {
                $row->debt_amount = $request->amount;
                $row->timestamps = false; // update without changing updated_at
                $row->save();
                return response()->json(['status'=>'success']);
            } 
        }
        
        if ($request->status == "new supplier") {
            if($request->shopstore == 'shop') {
                $shop_id = $request->sid;
                $store_id = null;
            }
            if($request->shopstore == 'store') {
                $shop_id = null;
                $store_id = $request->sid;
            }
            $supplier = \App\Supplier::create(['name'=>$request->name,'phone'=>$request->phone,'location'=>$request->location,'status'=>'active','company_id'=>Auth::user()->company_id,'shop_id'=>$shop_id,'store_id'=>$store_id,'user_id'=>Auth::user()->id]);
            if ($supplier) {
                return response()->json(['status'=>'success','supplier'=>$supplier]);
            } 
        }        
        if ($request->status == "update supplier details") {
            $supplier = \App\Supplier::find($request->id);
            if ($supplier) {
                $supplier->update(['name'=>$request->sname,'phone'=>$request->sphone,'location'=>$request->slocation]);
                return response()->json(['status'=>'success','sid'=>$supplier->id,'sname'=>$supplier->name]);
            }           
        }  
        if ($request->status == "supplier deposit money") {
            $deposit = "";
            if($request->amount && $request->amount > 0) {
                if($request->from == 'shop') {
                    $deposit = \App\ShopStoreSupplier::create(['supplier_id'=>$request->sid,'shop_id'=>$request->shopid,'amount'=>$request->amount,'user_id'=>Auth::user()->id,'status'=>'deposit','company_id'=>Auth::user()->company_id,'added_at'=>date('Y-m-d H:i:s')]);
                } elseif ($request->from == "store") {
                    $deposit = \App\ShopStoreSupplier::create(['supplier_id'=>$request->sid,'store_id'=>$request->storeid,'amount'=>$request->amount,'user_id'=>Auth::user()->id,'status'=>'deposit','company_id'=>Auth::user()->company_id,'added_at'=>date('Y-m-d H:i:s')]);
                }              
                if ($deposit) {
                    return response()->json(['status'=>'success','supplier'=>$request->sid]);
                }     
            } else {
                return response()->json(['supplier'=>$request->sid]);
            }
        }
        if ($request->status == "supplier borrow money") {
            if($request->amount && $request->amount > 0) {
                $deposit = \App\ShopStoreSupplier::create(['supplier_id'=>$request->sid,'shop_id'=>$request->shopid,'amount'=>$request->amount,'user_id'=>Auth::user()->id,'status'=>'borrow','company_id'=>Auth::user()->company_id,'added_at'=>date('Y-m-d H:i:s')]);
                if ($deposit) {
                    return response()->json(['status'=>'success','supplier'=>$request->sid]);
                }     
            } else {
                return response()->json(['supplier'=>$request->sid]);
            }
        }
        if ($request->status == "update deposited amount") {
            $sss = \App\ShopStoreSupplier::where('id',$request->id)->where('company_id',Auth::user()->company_id)->first();
            if($sss) {
                $sss->update(['amount'=>$request->amount,'user_id'=>Auth::user()->id]);
                return response()->json(['status'=>'success']);   
            } 
        }
        if ($request->status == "update purchased items") { // purchased items from shop supplier page
            $from = date('Y-m-d 00:00:00', strtotime($request->date));
            $to = date('Y-m-d 23:59:59', strtotime($request->date));

            $items = \App\ShopStoreSupplier::where('status','purchase')->where('shop_id',$request->shopid)->where('supplier_id',$request->suppid)->whereBetween('added_at', [Carbon::parse($from),Carbon::parse($to)])->get();
            if($items->isNotEmpty()) {
                // check for minimum stock level 
                if(Auth::user()->company->isCheckingStockLevel()){ $min_stock = "yes"; } else { $min_stock = "no"; }

                foreach($items as $i) { 
                    if($i->added_quantity == $request->input('epq'.$i->id)) { } else {
                        if($request->input('epq'.$i->id)) {
                            $quantity = $request->input('epq'.$i->id);
                            $diff_q = $quantity - $i->quantity;
                            $tb = $quantity * $i->buying_price;
                            $i->update(['quantity'=>$quantity,'total_buying'=>$tb,'user_id'=>Auth::user()->id]);                            
                            $row = \DB::connection('tenant')->table('shop_products')->where('shop_id',$i->shop_id)->where('product_id',$i->product_id)->where('active','yes');
                            if ($row->first()) {
                                $currQ = $row->first()->quantity;
                                $new_q = $currQ + $diff_q;
                                $insert = \App\StockAdjustment::create(['from'=>'shop','from_id'=>$row->first()->shop_id,'product_id'=>$row->first()->product_id,'av_quantity'=>$currQ,'company_id'=>Auth::user()->company_id, 'new_quantity'=>$new_q,'status'=>'stock adjustment','user_id'=>Auth::user()->id]);                
                                if ($insert) {                                                                      
                                    $update = $row->update(['quantity'=>$new_q]);

                                    Log::channel('custom')->info('PID: '.$i->product_id.', newQ = '.$new_q.' .. adjustedQ = '.$diff_q.' .. prevQ = '.$currQ);
                                    
                                    if($min_stock == "yes") {          
                                        $pro = \App\Product::find($i->product_id);                  
                                        if($pro->min_stock_level >= $new_q) {
                                            ProductController::insertMSL($pro->id,'shop',$request->shopid,$pro->min_stock_level);
                                        } else {
                                            $check = \App\Notification::where('shop_id',$request->shopid)->where('product_id',$pro->id)->first();
                                            if($check) {
                                                $check->update(['product_id'=>null]);
                                            }
                                        }
                                    }
                                }
                            } 
                        } 
                    }
                }
                return response()->json(['status'=>'success']);
            }            
        }     
        if ($request->status == "update purchased items store") { // purchased items from store supplier page
            $from = date('Y-m-d 00:00:00', strtotime($request->date));
            $to = date('Y-m-d 23:59:59', strtotime($request->date));

            $items = \App\ShopStoreSupplier::where('status','purchase')->where('store_id',$request->storeid)->where('supplier_id',$request->suppid)->whereBetween('added_at', [Carbon::parse($from),Carbon::parse($to)])->get();
            if($items->isNotEmpty()) {
                // check for minimum stock level 
                if(Auth::user()->company->isCheckingStockLevel()){ $min_stock = "yes"; } else { $min_stock = "no"; }

                foreach($items as $i) {
                    if($i->added_quantity == $request->input('epq'.$i->id)) { } else {
                        if($request->input('epq'.$i->id)) {
                            $quantity = $request->input('epq'.$i->id);
                            $diff_q = $quantity - $i->quantity;
                            $tb = $quantity * $i->buying_price;
                            $i->update(['quantity'=>$quantity,'total_buying'=>$tb,'user_id'=>Auth::user()->id]);                            
                            $row = \DB::connection('tenant')->table('store_products')->where('store_id',$i->store_id)->where('product_id',$i->product_id)->where('active','yes');
                            if ($row->first()) {
                                $new_q = $row->first()->quantity + $diff_q;
                                $insert = \App\StockAdjustment::create(['from'=>'store','from_id'=>$row->first()->store_id,'product_id'=>$row->first()->product_id,'av_quantity'=>$row->first()->quantity,'company_id'=>Auth::user()->company_id, 'new_quantity'=>$new_q,'status'=>'stock adjustment','user_id'=>Auth::user()->id]);                
                                if ($insert) {                                                                      
                                    $update = $row->update(['quantity'=>$new_q]);
                                    
                                    if($min_stock == "yes") {          
                                        $pro = \App\Product::find($i->product_id);                  
                                        if($pro->min_stock_level >= $new_q) {
                                            ProductController::insertMSL($pro->id,'store',$request->storeid,$pro->min_stock_level);
                                        } else {
                                            $check = \App\Notification::where('store_id',$request->storeid)->where('product_id',$pro->id)->first();
                                            if($check) {
                                                $check->update(['product_id'=>null]);
                                            }
                                        }
                                    }
                                }
                            } 
                        } 
                    }
                }
                return response()->json(['status'=>'success']);
            }            
        }    
        
        if ($request->status == "search customer") {
            $data['shop'] = Shop::find($request->shopid);
            $data['count'] = 0;
            $data['customers'] = DB::connection('tenant')->table('customers')->where('status','active')->where('shop_id',$request->shopid)->where('name','like','%'.$request->cname.'%')->limit(10)->get();
            $view = view('tables.more-customers',compact('data'))->render();
            return response()->json(['view'=>$view,'data'=>$data]);
        }

        if ($request->status == "new shop") {
            $data['shop'] = Shop::create(['name' => $request->name, 'location' => $request->shoplocation, 'has_customers'=>$request->crecords, 'company_id'=>Auth::user()->company_id, 'user_id' => Auth::user()->id,
                        'country_id'=>$request->change_country,
                        'region_id'=>$request->region_id,
                        'district_id'=>$request->district_id,
                        'ward_id'=>$request->ward_id]);
            if (!$data['shop']) {
                return response()->json(['error'=>'Error! Shop not created.']);
            } 
            if ($request->cashier) {
                DB::connection('tenant')->table('user_shops')->insert(['user_id' => $request->cashier, 'shop_id'=>$data['shop']->id, 'who'=>'cashier']);
                $check = DB::table('user_roles')->where('user_id',$request->cashier)->where('role_id',6)->get();
                if ($check->isEmpty()) {
                    DB::table('user_roles')->insert(['user_id' => $request->cashier, 'role_id'=>6]);
                }
            }
            return response()->json(['success'=>'Success! New shop created successfully.','data'=>$data]);
        }

        if($request->status == "new store") {
            $data['store'] = Store::create(['name' => $request->name, 'location' => $request->location, 'company_id'=>Auth::user()->company_id, 'user_id' => Auth::user()->id]);
            if (!$data['store']) {
                return response()->json(['error'=>'Error! Store not created.']);
            } 
            if ($request->user) {
                DB::connection('tenant')->table('user_stores')->insert(['user_id' => $request->user, 'store_id'=>$data['store']->id, 'who'=>'store master']);
                $check = DB::table('user_roles')->where('user_id',$request->user)->where('role_id',8)->get();
                if ($check->isEmpty()) {
                    DB::table('user_roles')->insert(['user_id' => $request->user, 'role_id'=>8]);
                }
            }
            return response()->json(['success'=>'Success! Store created successfully.','data'=>$data]);
        }

        if ($request->status == "edit company") {
            $company = Company::find($request->cid);
            if ($company) {
                $update = $company->update(['name'=>$request->name,'status'=>$request->enabled,'updated_by'=>Auth::user()->id]);
                if ($update) {
                    return response()->json(['status'=>'success']);
                } else {
                    return response()->json(['status'=>'error']);
                }
            }            
        }

        if ($request->status == "update company details") {
            $company = Company::find(Auth::user()->company_id);
            if ($company) {
                $update = $company->update(['name'=>$request->name,'about'=>$request->about,'updated_by'=>Auth::user()->id,'tin'=>$request->tin,'vrn'=>$request->vrn]);
                if ($update) {
                    return response()->json(['status'=>'success']);
                } else {
                    return response()->json(['status'=>'error']);
                }
            }            
        }

        if ($request->status == "new currency") {
            $add = Currency::create(['name'=>$request->name,'code'=>$request->code,'created_by'=>Auth::user()->id]);
            if ($add) {
                return response()->json(['status'=>'success']);
            } else {
                return response()->json(['status'=>'error']);
            }
        }

        if ($request->status == "new payment method") {
            $add = \App\PaymentOption::create(['name'=>$request->name]);
            if ($add) {
                return response()->json(['status'=>'success']);
            } else {
                return response()->json(['status'=>'error']);
            }
        }
        
        if ($request->status == "new setting") {
            $add = \App\Setting::create(['name'=>$request->name,'description'=>$request->description]);
            if ($add) {
                return response()->json(['status'=>'success']);
            } else {
                return response()->json(['status'=>'error']);
            }
        }

        if ($request->status == "change profile") {
            // $this->validate($request, [
            //     'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            // ]);

            if($request->hasFile('image')) {
                
                $f = $request->file('image');
                    
                if (HeicToJpg::isHeic($f)) { // heic format used by iphone users
                    $f = HeicToJpg::convert($f)->get();
                }

                $manager = new ImageManager(new Driver());
                $image = $manager->read($f);
                $image->scaleDown(width: 500);
                
                // check for directory availability
                $cfolder = Auth::user()->company->folder;
                if (! $cfolder) {
                    $fname = Auth::user()->company->name;
                    $fname = preg_replace("/\.[^.]+$/", "", $fname);
                    $fname = preg_replace("/[^a-zA-Z0-9]+/", "_", $fname);
                    $cfolder = Auth::user()->company->id.'_'.$fname;
                    Company::find(Auth::user()->company_id)->update(['folder'=>$cfolder]);
                }
                $main_path = public_path().'/images/companies/'.$cfolder;
                if (! File::exists($main_path)) {
                    File::makeDirectory($main_path, $mode = 0777, true, true);
                }                
                $profile_path = public_path().'/images/companies/'.$cfolder.'/profiles';
                if (! File::exists($profile_path)) {
                    File::makeDirectory($profile_path, $mode = 0777, true, true);
                }                

                // Main Image Upload on Folder Code
                $ext = $request->file('image')->getClientOriginalExtension();
                $orig_name = preg_replace("/\.[^.]+$/", "", $request->file('image')->getClientOriginalName());
                $orig_name = preg_replace("/[^a-zA-Z0-9]+/", "_", $orig_name);
                $imageName = time().'-'.$orig_name.'.'.$ext;
                $destinationPath = public_path('images/companies/'.$cfolder.'/profiles/');
                
                if ($image->save($destinationPath.$imageName)) {
                    User::find(Auth::user()->id)->update(['profile'=>$imageName]);
                    return response()->json(['status'=>'success']);
                } else {
                    return response()->json(['status'=>'fail to upload']);
                }
      
            } else {
                return response()->json(['status'=>'empty file']);
            }
        }

        if ($request->status == "change company profile") {
            // $this->validate($request, [
            //     'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            // ]);

            if($request->hasFile('image')) {
                
                $f = $request->file('image');
                    
                if (HeicToJpg::isHeic($f)) { // heic format used by iphone users
                    $f = HeicToJpg::convert($f)->get();
                }

                $manager = new ImageManager(new Driver());
                $image = $manager->read($f);
                $image->scaleDown(width: 500);
                
                // check for directory availability
                $cfolder = Auth::user()->company->folder;
                if (! $cfolder) {
                    $fname = Auth::user()->company->name;
                    $fname = preg_replace("/\.[^.]+$/", "", $fname);
                    $fname = preg_replace("/[^a-zA-Z0-9]+/", "_", $fname);
                    $cfolder = Auth::user()->company->id.'_'.$fname;
                    Company::find(Auth::user()->company_id)->update(['folder'=>$cfolder]);
                }
                $main_path = public_path().'/images/companies/'.$cfolder;
                if (! File::exists($main_path)) {
                    File::makeDirectory($main_path, $mode = 0777, true, true);
                }                
                $profile_path = public_path().'/images/companies/'.$cfolder.'/company-profiles';
                if (! File::exists($profile_path)) {
                    File::makeDirectory($profile_path, $mode = 0777, true, true);
                }                

                // Main Image Upload on Folder Code
                $ext = $request->file('image')->getClientOriginalExtension();
                $orig_name = preg_replace("/\.[^.]+$/", "", $request->file('image')->getClientOriginalName());
                $orig_name = preg_replace("/[^a-zA-Z0-9]+/", "_", $orig_name);
                $imageName = 'logo-'.time().'.'.$ext; // nime replace origin_name with logo-
                $destinationPath = public_path('images/companies/'.$cfolder.'/company-profiles/');
                
                if ($image->save($destinationPath.$imageName)) {
                    \App\Company::find(Auth::user()->company_id)->update(['logo'=>$imageName]);
                    return response()->json(['status'=>'success']);
                } else {
                    return response()->json(['status'=>'fail to upload']);
                }
      
            } else {
                return response()->json(['status'=>'empty file']);
            }
        }

        if ($request->status == "expense-record") {
            $data = array();
            $curtime = date('H:i:s');
            $expdate =  str_replace("/", "-", $request->expense_date);
            $expdate = date("Y-m-d H:i:s", strtotime($expdate.$curtime));
            $expense = ShopExpense::create(['shop_id' => $request->shop_id, 'expense_id' => $request->expense_id, 'amount' => $request->amount, 'description' => $request->description, 'company_id'=>Auth::user()->company_id, 'user_id' => Auth::user()->id,'created_at'=>$expdate]);
            if ($expense) {
                
                $solddate = date("d-m-Y", strtotime($expense->created_at));
                $data['predate'] = "no";
                if ($solddate != date("d-m-Y")) { //check if deleting today sold item OR previous date
                    $data['predate'] = $solddate;
                }

                return response()->json(['status'=>'success','val'=>$request->shop_id,'data'=>$data]);
            } else {
                return response()->json(['status'=>'error']);
            }            
        }

        if($request->status == "edit-submitted-expense") {
            $data = array();
            $row = ShopExpense::where('id',$request->row_id)->where('company_id',Auth::user()->company_id)->first();
            if ($row) {
                $update = $row->update(['shop_id' => $request->shop_id, 'expense_id' => $request->expense_id, 'amount' => $request->eamount, 'description' => $request->edescription, 'user_id' => Auth::user()->id]);
                if($update) {
                    $solddate = date("d-m-Y", strtotime($row->created_at));
                    $data['predate'] = "no";
                    if ($solddate != date("d-m-Y")) { //check if deleting today sold item OR previous date
                        $data['predate'] = $solddate;
                    }
    
                    return response()->json(['status'=>'success','data'=>$data]);
                }
            }
        }
        
        if($request->status == "subscription payment") {
            if($request->sum) {
                $today = date('Y-m-d');
                $user = \App\User::find($request->user);
                $sum = 0;

                $pay = \App\Payment::create(['company_id'=>$user->company->id, 'status'=>'paid', 'paid_amount'=>$request->sum, 'updated_by'=>$request->user]);
                if($pay) {       
                    $company = \App\Company::find($user->company->id);
                    $company->update(['status'=>'active','reminder'=>null]);
                    if($request->countshops) { 
                        for ($i=1; $i <= $request->countshops; $i++) {    
                            if($request->input('sha'.$i)) { // check if amount filled in this shop 
                                $paid_amount = $request->input('sha'.$i);
                                $no_of_months = $request->input('shmonths'.$i);
                                $agent_p_status = $agent_p_desc = "";
                                $ac = DB::table('agent_companies')->where('company_id',$company->id)->first(); 
                                if($ac) { // check if company is belong to agent
                                    $paid_months = \App\PaymentsDesc::where('paid_for','shop')->where('paid_item',$request->input('shop'.$i))->sum('no_of_months');
                                    if($paid_months > 3) { //agent get 10%
                                        $agent_p_status = "above 3 months";
                                    } else {
                                        if($paid_months == 0) { // 3000 for 3 months then 10%
                                            $agent_p_status = "new shop";
                                        } elseif ($paid_months == 1) { // 3000 for 2 months then 10%
                                            $agent_p_status = "two months left";
                                        } elseif ($paid_months == 2) { // 3000 for 1 month then 10%
                                            $agent_p_status = "one month left";
                                        }
                                    }
                                }
                                // insert amount
                                $pay_desc = \App\PaymentsDesc::create(['company_id'=>$user->company->id, 'payment_id'=>$pay->id, 'paid_amount'=>$paid_amount, 'no_of_months'=>$no_of_months, 'paid_for'=>'shop', 'paid_item'=>$request->input('shop'.$i), 'paid_date'=>$request->input('shi'.$i), 'expire_date'=>$request->input('shd'.$i)]);
                                \App\Shop::where('id',$request->input('shop'.$i))->update(['status'=>'active','reminder'=>null]);
                                // calculate agent commision 
                                if($agent_p_status == "") { } else {
                                    if($agent_p_status == "above 3 months") {
                                        $agent_comm = ($paid_amount * 10 / 100);
                                        $agent_p_desc = "10% of ".$paid_amount." paid for ".$no_of_months;
                                    }
                                    if($agent_p_status == "new shop") {
                                        if($no_of_months == 1) {
                                            $agent_comm = 3000;
                                            $agent_p_desc = "First commission";
                                        } elseif($no_of_months == 2) {
                                            $agent_comm = 6000;
                                            $agent_p_desc = "Commission for first 2 months";
                                        } elseif($no_of_months == 3) {
                                            $agent_comm = 9000;                                            
                                            $agent_p_desc = "Commission for first 3 months";
                                        } elseif($no_of_months > 3) {
                                            $remaining_months = $no_of_months - 3;
                                            $monthly_payment = ($paid_amount / $no_of_months);
                                            $reminder_payment = ($paid_amount - ($monthly_payment*3)); // deduct payemnt of three months and remain with what has to be taken 10%
                                            $agent_comm = (9000 + ($reminder_payment * 10 / 100));
                                            $agent_p_desc = "9000 commission for first 3 months with 10% of remaining ".$remaining_months." months. Paid amount = ".number_format($paid_amount, 0);
                                        }
                                    }
                                    if($agent_p_status == "two months left") {
                                        if($no_of_months == 1) {
                                            $agent_comm = 3000;
                                            $agent_p_desc = "Sec commission";
                                        } elseif($no_of_months == 2) {
                                            $agent_comm = 6000;
                                            $agent_p_desc = "Sec & third commissions";
                                        } elseif($no_of_months > 2) {
                                            $remaining_months = $no_of_months - 2;
                                            $monthly_payment = ($paid_amount / $no_of_months);
                                            $reminder_payment = ($paid_amount - ($monthly_payment*2)); // deduct payemnt of two months and remain with what has to be taken 10%
                                            $agent_comm = (6000 + ($reminder_payment * 10 / 100));
                                            $agent_p_desc = "6000 commission for sec & third months with 10% of remaining ".$remaining_months." months. Paid amount = ".number_format($paid_amount, 0);
                                        }
                                    }
                                    if($agent_p_status == "one month left") {
                                        if($no_of_months == 1) {
                                            $agent_comm = 3000;
                                            $agent_p_desc = "Third commission";
                                        } elseif($no_of_months > 1) {
                                            $remaining_months = $no_of_months - 1;
                                            $monthly_payment = ($paid_amount / $no_of_months);
                                            $reminder_payment = ($paid_amount - $monthly_payment); // deduct payemnt of one month and remain with what has to be taken 10%
                                            $agent_comm = (3000 + ($reminder_payment * 10 / 100));
                                            $agent_p_desc = "3000 commission for a third month with 10% of remaining ".$remaining_months." months. Paid amount = ".number_format($paid_amount, 0);
                                        }
                                    }

                                    DB::table('agent_payments')->insert(['user_id' => $ac->user_id, 'payments_desc_id'=>$pay_desc->id,'amount'=>$agent_comm,'date'=>date('Y-m-d'),'status'=>'not paid','description'=>$agent_p_desc]);
                                }
                            }                    
                        }    
                    }    
                    if($request->countstores) { 
                        for ($i=1; $i <= $request->countstores; $i++) {    
                            if($request->input('sta'.$i)) { // check if amount filled in this store
                                $paid_amount = $request->input('sta'.$i);
                                $no_of_months = $request->input('stmonths'.$i);
                                $agent_p_status = $agent_p_desc = "";
                                $ac = DB::table('agent_companies')->where('company_id',$company->id)->first(); 
                                if($ac) { // check if company is belong to agent
                                    $paid_months = \App\PaymentsDesc::where('paid_for','store')->where('paid_item',$request->input('store'.$i))->sum('no_of_months');
                                    if($paid_months > 3) { //agent get 10%
                                        $agent_p_status = "above 3 months";
                                    } else {
                                        if($paid_months == 0) { // 3000 for 3 months then 10%
                                            $agent_p_status = "new store";
                                        } elseif ($paid_months == 1) { // 3000 for 2 months then 10%
                                            $agent_p_status = "two months left";
                                        } elseif ($paid_months == 2) { // 3000 for 1 month then 10%
                                            $agent_p_status = "one month left";
                                        }
                                    }
                                }
                                // insert amount
                                $pay_desc = \App\PaymentsDesc::create(['company_id'=>$user->company->id, 'payment_id'=>$pay->id, 'paid_amount'=>$paid_amount, 'no_of_months'=>$no_of_months, 'paid_for'=>'store', 'paid_item'=>$request->input('store'.$i), 'paid_date'=>$request->input('sti'.$i), 'expire_date'=>$request->input('std'.$i)]);
                                \App\Store::where('id',$request->input('store'.$i))->update(['status'=>'active','reminder'=>null]);
                                // calculate agent commision 
                                if($agent_p_status == "") { } else {
                                    if($agent_p_status == "above 3 months") {
                                        $agent_comm = ($paid_amount * 10 / 100);
                                        $agent_p_desc = "10% of ".$paid_amount." paid for ".$no_of_months;
                                    }
                                    if($agent_p_status == "new store") {
                                        if($no_of_months == 1) {
                                            $agent_comm = 1500;
                                            $agent_p_desc = "First commission";
                                        } elseif($no_of_months == 2) {
                                            $agent_comm = 3000;
                                            $agent_p_desc = "Commission for first 2 months";
                                        } elseif($no_of_months == 3) {
                                            $agent_comm = 4500;                                            
                                            $agent_p_desc = "Commission for first 3 months";
                                        } elseif($no_of_months > 3) {
                                            $remaining_months = $no_of_months - 3;
                                            $monthly_payment = ($paid_amount / $no_of_months);
                                            $reminder_payment = ($paid_amount - ($monthly_payment*3)); // deduct payemnt of three months and remain with what has to be taken 10%
                                            $agent_comm = (4500 + ($reminder_payment * 10 / 100));
                                            $agent_p_desc = "4500 commission for first 3 months with 10% of remaining ".$remaining_months." months. Paid amount = ".number_format($paid_amount, 0);
                                        }
                                    }
                                    if($agent_p_status == "two months left") {
                                        if($no_of_months == 1) {
                                            $agent_comm = 1500;
                                            $agent_p_desc = "Sec commission";
                                        } elseif($no_of_months == 2) {
                                            $agent_comm = 3000;
                                            $agent_p_desc = "Commission for sec & third months";
                                        } elseif($no_of_months > 2) {
                                            $remaining_months = $no_of_months - 2;
                                            $monthly_payment = ($paid_amount / $no_of_months);
                                            $reminder_payment = ($paid_amount - ($monthly_payment*2)); // deduct payemnt of two months and remain with what has to be taken 10%
                                            $agent_comm = (3000 + ($reminder_payment * 10 / 100));
                                            $agent_p_desc = "3000 commission for sec & third months with 10% of remaining ".$remaining_months." months. Paid amount = ".number_format($paid_amount, 0);
                                        }
                                    }
                                    if($agent_p_status == "one month left") {
                                        if($no_of_months == 1) {
                                            $agent_comm = 1500;
                                            $agent_p_desc = "Third commission";
                                        } elseif($no_of_months > 1) {
                                            $remaining_months = $no_of_months - 1;
                                            $monthly_payment = ($paid_amount / $no_of_months);
                                            $reminder_payment = ($paid_amount - $monthly_payment); // deduct payemnt of one month and remain with what has to be taken 10%
                                            $agent_comm = (1500 + ($reminder_payment * 10 / 100));
                                            $agent_p_desc = "1500 commission for a third month with 10% of remaining ".$remaining_months." months. Paid amount = ".number_format($paid_amount, 0);
                                        }
                                    }

                                    DB::table('agent_payments')->insert(['user_id' => $ac->user_id, 'payments_desc_id'=>$pay_desc->id,'amount'=>$agent_comm,'date'=>date('Y-m-d'),'status'=>'not paid','description'=>$agent_p_desc]);
                                }
                            }                    
                        }    
                    }    
                }                          
                
                return response()->json(['status'=>'submitted']);
            } else {
                return response()->json(['status'=>'empty']);
            }            
        }

        if ($request->status == "send sms report") {    
            $api_key='shariff';
            $secret_key = 'ShariffPOS@91';
    
            $date = date("Y-m-d", strtotime($request->smsdate));
            $output = array();

            $report = \App\DailySale::where('date',$date)->where('shop_id',$request->smsshop)->orderBy('id','desc')->first();
            if($report) {
                $shop = \App\Shop::find($request->smsshop);

                // get business owner
                $owner = \App\User::find($request->smswho);
                $recipients = array();
                $recipients[] = $owner->phonecode.''.preg_replace("/[^0-9]/", "", $owner->phone);

                // faida au hasara
                if ($report->profit < 0) {
                    $profitloss = "Hasara: ".number_format(abs($report->profit), 0);
                } else {
                    $profitloss = "Faida: ".number_format($report->profit, 0);
                }

                $quantity = $report->quantities + 0;

                $postData = array(
                    'from' => 'Levanda POS',
                    'to' => $recipients,
                    'text' => 'Ripoti ya tarehe '.date("d/m/Y", strtotime($request->smsdate)).', duka la '.$shop->name.'. Jumla mauzo: '.number_format($report->total_sales, 0).'. Idadi bidhaa zilizouzwa: '.$quantity.'. '.$profitloss.'. Matumizi: '.number_format($report->total_expenses, 0).'',
                    'reference' => 'xyz',
                );

                $Url = 'https://messaging-service.co.tz/api/sms/v1/text/single';

                $ch = curl_init($Url);
                error_reporting(E_ALL);
                ini_set('display_errors', 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt_array($ch, array(
                    CURLOPT_POST => TRUE,
                    CURLOPT_RETURNTRANSFER => TRUE,
                    CURLOPT_HTTPHEADER => array(
                        'Authorization:Basic ' . base64_encode("$api_key:$secret_key"),
                        'Content-Type: application/json',
                        'Accept: application/json'
                    ),
                    CURLOPT_POSTFIELDS => json_encode($postData)
                ));

                $response = curl_exec($ch);

                if($response === FALSE){
                    //     echo $response;

                    // die(curl_error($ch));
                }
                $output[] = $response;
                
            } else {
                // $output[] = 'no data';
                return response()->json(['status'=>'no sales']);
            }  
            return response()->json(['status'=>'success']);
        }

        if ($request->status == "broadcast sms") {   

            $details['message'] = $request->message;
            $details['br_group'] = $request->br_group;

            dispatch(new \App\Jobs\BroadcastSMS($details));

            return response()->json(['status'=>'success']);
        }

        if($request->status == "add shop quantity") {
            $shop = Shop::where('id',$request->sid)->where('company_id',Auth::user()->company_id)->first();
            if($shop) { // status = request, sent, updated
                if ($request->approval == "yes") {
                    $status = "sent";
                } else {
                    $status = "updated";
                }         
                $product = Product::find($request->pid);
                $tbuy = $request->quantity * $product->buying_price;
                $insert = NewStock::create([
                    'product_id'=>$request->pid,'shop_id'=>$request->sid,'store_id'=>null,
                    'added_quantity'=>$request->quantity,'buying_price'=>$product->buying_price,'total_buying'=>$tbuy,'company_id'=>Auth::user()->company_id,
                    'user_id'=>Auth::user()->id,'status'=>$status,'sent_at'=>date('Y-m-d H:i:s')
                    ]);
                if($insert) {
                    if($status == "updated") { // update quantity in shop, else - wait for approval
                        $pro = \DB::connection('tenant')->table('shop_products')->where('shop_id',$request->sid)->where('product_id',$request->pid)->where('active','yes'); 
                        if ($pro->first()) {
                            $av_qty = $pro->first()->quantity;
                            $new_qty = $av_qty + $request->quantity;
                            $update = $insert->update(['available_quantity'=>$av_qty,'new_quantity'=>$new_qty,'received_by'=>Auth::user()->id,'received_at'=>date('Y-m-d H:i:s')]);
                            if($update) {
                                $pro->update(['quantity'=>$new_qty]);

                                Log::channel('custom')->info('PID: '.$request->pid.', newQ = '.$new_qty.' .. addedQ = '.$request->quantity.' .. prevQ = '.$av_qty);
                            }
                        } else {
                            $add = DB::connection('tenant')->table('shop_products')->insert(['shop_id' => $request->sid, 'product_id'=>$request->pid, 'quantity'=>$request->quantity, 'active'=>'yes', 'created_at' =>  \Carbon\Carbon::now(), 'updated_at' =>  \Carbon\Carbon::now()]);
                            if ($add) {
                                $insert->update(['available_quantity'=>0,'new_quantity'=>$request->quantity,'received_by'=>Auth::user()->id,'received_at'=>date('Y-m-d H:i:s')]);

                                Log::channel('custom')->info('PID: '.$request->pid.', newQ = '.$request->quantity.' .. addedQ = '.$request->quantity.' .. prevQ = 0');
                            }
                        }
                    } 
                }
                return response()->json(['status'=>'success']);
            }     
        }
        
        if($request->status == "add store quantity") {
            $store = Store::where('id',$request->sid)->where('company_id',Auth::user()->company_id)->first();
            if($store) { // status = request, sent, updated
                if ($request->approval == "yes") {
                    $status = "sent";
                } else {
                    $status = "updated";
                }         
                $product = Product::find($request->pid);
                $tbuy = $request->quantity * $product->buying_price;
                $insert = NewStock::create([
                    'product_id'=>$request->pid,'shop_id'=>null,'store_id'=>$request->sid,
                    'added_quantity'=>$request->quantity,'buying_price'=>$product->buying_price,'total_buying'=>$tbuy,'company_id'=>Auth::user()->company_id,
                    'user_id'=>Auth::user()->id,'status'=>$status,'sent_at'=>date('Y-m-d H:i:s')
                    ]);
                if($insert) {
                    if($status == "updated") { // update quantity in shop, else - wait for approval
                        $pro = \DB::connection('tenant')->table('store_products')->where('store_id',$request->sid)->where('product_id',$request->pid)->where('active','yes'); 
                        if ($pro->first()) {
                            $av_qty = $pro->first()->quantity;
                            $new_qty = $av_qty + $request->quantity;
                            $update = $insert->update(['available_quantity'=>$av_qty,'new_quantity'=>$new_qty,'received_by'=>Auth::user()->id,'received_at'=>date('Y-m-d H:i:s')]);
                            if($update) {
                                $pro->update(['quantity'=>$new_qty]);
                            }
                        } else {
                            $add = DB::connection('tenant')->table('store_products')->insert(['store_id' => $request->sid, 'product_id'=>$request->pid, 'quantity'=>$request->quantity, 'active'=>'yes', 'created_at' =>  \Carbon\Carbon::now(), 'updated_at' =>  \Carbon\Carbon::now()]);
                            if ($add) {
                                $insert->update(['available_quantity'=>0,'new_quantity'=>$request->quantity,'received_by'=>Auth::user()->id,'received_at'=>date('Y-m-d H:i:s')]);
                            }
                        }
                    } 
                }
                return response()->json(['status'=>'success']);
            }     
        }

        if($request->status == "update shop quantity") { // this is no longer in use
            if($request->shid) {
                $company_id = Auth::user()->company_id;
                for ($j=0; $j < count($request->shid); $j++) { 
                    $shop_id = $request->shid[$j];
                    $quantity = $request->input('shQF'.$shop_id);
                    $row = \DB::connection('tenant')->table('shop_products')->where('shop_id',$shop_id)->where('product_id',$request->pid)->where('active','yes');
                    if ($row->first()) {
                        $currQ = $row->first()->quantity;
                        if($currQ == $quantity) { } else {
                            $diff_q = $quantity - $currQ;
                            $insert = StockAdjustment::create(['from'=>'shop','from_id'=>$shop_id,'product_id'=>$request->pid,'av_quantity'=>$currQ,'company_id'=>$company_id, 'new_quantity'=>$quantity,'status'=>'stock adjustment','user_id'=>Auth::user()->id]);                
                            if ($insert) {
                                $update = $row->update(['quantity'=>$quantity]);

                                Log::channel('custom')->info('PID: '.$request->pid.', newQ = '.$quantity.' .. adjustedQ = '.$diff_q.' .. prevQ = '.$currQ);
                            }
                        }
                    } else {
                        if($quantity == 0) { } else {
                            DB::connection('tenant')->table('shop_products')->insert(['shop_id' => $shop_id, 'product_id'=>$request->pid, 'quantity'=>$quantity, 'active'=>'yes', 'created_at' =>  \Carbon\Carbon::now(), 'updated_at' =>  \Carbon\Carbon::now()]);
                            StockAdjustment::create(['from'=>'shop','from_id'=>$shop_id,'product_id'=>$request->pid,'av_quantity'=>0,'company_id'=>$company_id, 'new_quantity'=>$quantity,'status'=>'stock adjustment','user_id'=>Auth::user()->id]);

                            Log::channel('custom')->info('PID: '.$request->pid.', newQ = '.$quantity.' .. adjustedQ = '.$quantity.' .. prevQ = 0');
                        }
                    }

                }
                return response()->json(['status'=>'updated']);
            }            
        }
        
        if($request->status == "update store quantity") {
            if($request->stid) {
                for ($j=0; $j < count($request->stid); $j++) { 
                    $store_id = $request->stid[$j];
                    $quantity = $request->input('stQF'.$store_id);
                    $row = \DB::connection('tenant')->table('store_products')->where('store_id',$store_id)->where('product_id',$request->pid)->where('active','yes');
                    if ($row->first()) {
                        if($row->first()->quantity == $quantity) { } else {
                            $insert = StockAdjustment::create(['from'=>'store','company_id'=>Auth::user()->company_id,'from_id'=>$row->first()->store_id,'product_id'=>$row->first()->product_id,'av_quantity'=>$row->first()->quantity,'new_quantity'=>$quantity,'status'=>'stock adjustment','user_id'=>Auth::user()->id]);                
                            if ($insert) {
                                $update = $row->update(['quantity'=>$quantity]);
                            }
                        }
                    } else {
                        if($quantity == 0) { } else {
                            DB::connection('tenant')->table('store_products')->insert(['store_id' => $store_id, 'product_id'=>$request->pid, 'quantity'=>$quantity, 'active'=>'yes', 'created_at' =>  \Carbon\Carbon::now(), 'updated_at' =>  \Carbon\Carbon::now()]);
                            StockAdjustment::create(['from'=>'store','company_id'=>Auth::user()->company_id,'from_id'=>$store_id,'product_id'=>$request->pid,'av_quantity'=>0,'new_quantity'=>$quantity,'status'=>'stock adjustment','user_id'=>Auth::user()->id]);
                        }
                    }

                    // $check = DB::table('store_products')->where('store_id',$store_id)->where('product_id',$request->pid)->where('active','yes');
                    // if ($check->first()) {
                    //     if ($check->first()->quantity == $quantity) { } else {
                    //         $check->update(['quantity'=>$quantity]);
                    //     }                    
                    // } else {
                    //     DB::table('store_products')->insert(['store_id' => $store_id, 'product_id'=>$request->pid, 'quantity'=>$quantity, 'active'=>'yes', 'created_at' =>  \Carbon\Carbon::now(), 'updated_at' =>  \Carbon\Carbon::now()]);
                    // }                
                }
                return response()->json(['status'=>'updated']);
            }            
        }
        
        if ($request->status == "add agent payment") {
            
            $pay = AgentMonthlyPayment::create(['user_id'=>$request->aid,'amount'=>$request->amount,'month'=>$request->month]);
            
            if($pay) {
                // update agent payments table                
                $monthyear = explode("-", $request->month);
                $month = $monthyear[0];
                $year = $monthyear[1];
                $update = DB::table('agent_payments')->where('user_id',$request->aid)->whereMonth('date',$month)->whereYear('date',$year)->update(['status'=>'paid']);

                // reference image
                if($request->hasFile('reference')) {
    
                    $image = Image::make($request->file('reference'));
                    
                    // check for directory availability
                    $main_path = public_path().'/images/payment_references';
                    if (! File::exists($main_path)) {
                        File::makeDirectory($main_path, $mode = 0777, true, true);
                    }                
    
                    // upload file
                    $ext = $request->file('reference')->getClientOriginalExtension();
                    $orig_name = preg_replace("/\.[^.]+$/", "", $request->file('reference')->getClientOriginalName());
                    $orig_name = preg_replace("/[^a-zA-Z0-9]+/", "_", $orig_name);
                    $imageName = $request->month.'-'.$pay->id.'-'.$orig_name.'.'.$ext;
                    $destinationPath = public_path('images/payment_references/');
                    
                    if ($image->save($destinationPath.$imageName)) {
                        $pay->update(['reference'=>$imageName]);
                    } 
                }
                return response()->json(['status'=>'success']);
            }
        }

        if($request->status == "search product") {
            if($request->from == "shop") {
                $data['from'] = "shop";
                $data['shop'] = Shop::find($request->sid);
                $data['products'] = $data['shop']->products()->where('products.name','LIKE',"%$request->name%")->orderBy('products.name')->get();
                $view = view('tables.products-in-shop-store',compact('data'))->render();
                return response()->json(['view'=>$view]);
            }
            if($request->from == "store") {
                $data['from'] = "store";
                $data['store'] = Store::find($request->sid);
                $data['products'] = $data['store']->products()->where('products.name','LIKE',"%$request->name%")->orderBy('products.name')->get();
                $view = view('tables.products-in-shop-store',compact('data'))->render();
                return response()->json(['view'=>$view]);
            }
        }

        if($request->status == "search product 2") {
            if($request->from == "shop") { 
                $data['from'] = "shop";
                $data['shops'] = Shop::where('company_id',Auth::user()->company_id)->get();
                $data['products'] = Product::where('company_id',Auth::user()->company_id)->where('products.name','LIKE',"%$request->name%")->where('status','published')->limit(15)->get();
                $view = view('tables.manage-products',compact('data'))->render();
                return response()->json(['view'=>$view]);
            } 
            if($request->from == "store") { 
                $data['from'] = "store";
                $data['stores'] = Store::where('company_id',Auth::user()->company_id)->get();
                $data['products'] = Product::where('company_id',Auth::user()->company_id)->where('products.name','LIKE',"%$request->name%")->where('status','published')->limit(15)->get();
                $view = view('tables.manage-products',compact('data'))->render();
                return response()->json(['view'=>$view]);
            }
        }

        if($request->status == "change added stock quantity") {
            if($request->quantity > 0) { 
                $row = NewStock::where('id',$request->id)->where('user_id',Auth::user()->id)->where('company_id',Auth::user()->company_id)->first();
                if ($row) {
                    $row->update(['added_quantity'=>$request->quantity]);
                    $total = $request->quantity * $row->buying_price;
                    $total_p = number_format($total);
                    return response()->json(['status'=>'success','id'=>$request->id,'quantity'=>$request->quantity,'totalp'=>$total_p]);
                } 
            }
        }
        
        if($request->status == "update expense name") {
            $update = Expense::where('company_id',Auth::user()->company_id)->where('id',$request->id)->update(['name'=>$request->name]);
            if($update) { 
                return response()->json(['status'=>'success','id'=>$request->id,'name'=>$request->name]);
            }
        }

        if($request->status == "add product quantity") {            
            $max = $request->check;
            // check for minimum stock level 
            if(Auth::user()->company->isCheckingStockLevel()){ $min_stock = "yes"; } else { $min_stock = "no"; }

            if($request->from == "shop") {
                $shop = Shop::where('id',$request->shopid)->where('company_id',Auth::user()->company_id)->first();
                if($shop) { // status = request, sent, updated
                    if ($request->approval == "yes") {
                        $status = "sent";
                    } else {
                        $status = "updated";
                    }         

                    for ($i=1; $i <= $max; $i++) {    
                        if($request->input('val-'.$i)) {
                            $pid = $request->input('val-'.$i);
                            $qty = $request->input('pq-'.$i.'-'.$pid);
                            $product = Product::find($pid);
                            $tbuy = $qty * $product->buying_price;
                                $insert = NewStock::create([
                                    'product_id'=>$pid,'shop_id'=>$request->shopid,'store_id'=>$request->storeid,
                                    'added_quantity'=>$qty,'buying_price'=>$product->buying_price,'total_buying'=>$tbuy,'company_id'=>Auth::user()->company_id,
                                    'user_id'=>Auth::user()->id,'status'=>$status,'sent_at'=>date('Y-m-d H:i:s')
                                    ]);
                                if($insert) {
                                    if($status == "updated") { // update quantity in shop, else - wait for approval
                                        $pro = \DB::connection('tenant')->table('shop_products')->where('shop_id',$request->shopid)->where('product_id',$pid)->where('active','yes'); 
                                        if ($pro->first()) {
                                            $av_qty = $pro->first()->quantity;
                                            $new_qty = $av_qty + $qty;
                                            $update = $insert->update(['available_quantity'=>$av_qty,'new_quantity'=>$new_qty,'received_by'=>Auth::user()->id,'received_at'=>date('Y-m-d H:i:s')]);
                                            if($update) {
                                                $pro->update(['quantity'=>$new_qty]);

                                                Log::channel('custom')->info('PID: '.$pid.', newQ = '.$new_qty.' .. addedQ = '.$qty.' .. prevQ = '.$av_qty);
                                            }
                                        } else {
                                            $new_qty = $qty;
                                            $add = DB::connection('tenant')->table('shop_products')->insert(['shop_id' => $request->shopid, 'product_id'=>$pid, 'quantity'=>$qty, 'active'=>'yes', 'created_at' =>  \Carbon\Carbon::now(), 'updated_at' =>  \Carbon\Carbon::now()]);
                                            if ($add) {
                                                $insert->update(['available_quantity'=>0,'new_quantity'=>$qty,'received_by'=>Auth::user()->id,'received_at'=>date('Y-m-d H:i:s')]);

                                                Log::channel('custom')->info('PID: '.$pid.', newQ = '.$qty.' .. addedQ = '.$qty.' .. prevQ = 0');
                                            }
                                        }
                                        
                                        if($min_stock == "yes") {          
                                            $prod = \App\Product::find($pid);                  
                                            if($prod->min_stock_level >= $new_qty) {
                                                ProductController::insertMSL($prod->id,'shop',$request->shopid,$prod->min_stock_level);
                                            } else {
                                                $check = \App\Notification::where('shop_id',$request->shopid)->where('product_id',$prod->id)->first();
                                                if($check) {
                                                    $check->update(['product_id'=>null]);
                                                }
                                            }
                                        }
                                    } 
                                }
                        }
                    }       
                    return response()->json(['status'=>'success','sid'=>$shop->id]); 
                }
            }
            if($request->from == "store") {
                $store = Store::where('id',$request->storeid)->where('company_id',Auth::user()->company_id)->first();
                if($store) { // status = request, sent, updated
                    if ($request->approval == "yes") {
                        $status = "sent";
                    } else {
                        $status = "updated";
                    }         

                    for ($i=1; $i <= $max; $i++) { 
                        if($request->input('val-'.$i)) {
                            $pid = $request->input('val-'.$i);
                            $qty = $request->input('pq-'.$i.'-'.$pid);
                            $product = Product::find($pid);
                            $tbuy = $qty * $product->buying_price;
                                $insert = NewStock::create([
                                    'product_id'=>$pid,'shop_id'=>$request->shopid,'store_id'=>$request->storeid,
                                    'added_quantity'=>$qty,'buying_price'=>$product->buying_price,'total_buying'=>$tbuy,'company_id'=>Auth::user()->company_id,
                                    'user_id'=>Auth::user()->id,'status'=>$status,'sent_at'=>date('Y-m-d H:i:s')
                                    ]);
                                if($insert) {
                                    if($status == "updated") { // update quantity in store, else - wait for approval
                                        $pro = \DB::connection('tenant')->table('store_products')->where('store_id',$request->storeid)->where('product_id',$pid)->where('active','yes'); 
                                        if ($pro->first()) {
                                            $av_qty = $pro->first()->quantity;
                                            $new_qty = $av_qty + $qty;
                                            $update = $insert->update(['available_quantity'=>$av_qty,'new_quantity'=>$new_qty,'received_by'=>Auth::user()->id,'received_at'=>date('Y-m-d H:i:s')]);
                                            if($update) {
                                                $pro->update(['quantity'=>$new_qty]);
                                            }
                                        } else {
                                            $new_qty = $qty;
                                            $add = DB::connection('tenant')->table('store_products')->insert(['store_id' => $request->storeid, 'product_id'=>$pid, 'quantity'=>$qty, 'active'=>'yes', 'created_at' =>  \Carbon\Carbon::now(), 'updated_at' =>  \Carbon\Carbon::now()]);
                                            if ($add) {
                                                $insert->update(['available_quantity'=>0,'new_quantity'=>$qty,'received_by'=>Auth::user()->id,'received_at'=>date('Y-m-d H:i:s')]);
                                            }
                                        }

                                        if($min_stock == "yes") {          
                                            $prod = \App\Product::find($pid);                  
                                            if($prod->min_stock_level >= $new_qty) {
                                                ProductController::insertMSL($prod->id,'store',$request->storeid,$prod->min_stock_level);
                                            } else {
                                                $check = \App\Notification::where('store_id',$request->storeid)->where('product_id',$prod->id)->first();
                                                if($check) {
                                                    $check->update(['product_id'=>null]);
                                                }
                                            }
                                        }
                                    } 
                                }
                        }
                    }       
                    return response()->json(['status'=>'success','sid'=>$store->id]); 
                }
            }
        }

        if($request->status == "update manage shop products") {
            $shops = Shop::where('company_id',Auth::user()->company_id)->get();
            $arr = explode(',',$request->shops);
            $checked_s = array_map('intval', $arr);
            foreach($shops as $s) {
                if (in_array($s->id,$checked_s)) { // shop is checked
                    $row = \DB::connection('tenant')->table('shop_products')->where('product_id',$request->pid)->where('shop_id',$s->id)->where('active','yes');
                    if($row->first()) {
                        // already attached before 
                    } else { // attach it now
                        \DB::connection('tenant')->table('shop_products')->insert(['product_id'=>$request->pid,'shop_id'=>$s->id,'active'=>'yes','quantity'=>0, 'created_at' =>  \Carbon\Carbon::now(), 'updated_at' =>  \Carbon\Carbon::now()]);

                        Log::channel('custom')->info('PID: '.$request->pid.', newQ = 0 .. linkShopPro = 0 .. prevQ = 0');
                    }
                } else { // shop is not checked
                    $row = \DB::connection('tenant')->table('shop_products')->where('product_id',$request->pid)->where('shop_id',$s->id)->where('active','yes');
                    if($row->first()) { // was attached before, unlink it now
                        $pid = $row->first()->product_id;
                        $qty = $row->first()->quantity;
                        StockAdjustment::create(['from'=>'shop','from_id'=>$row->first()->shop_id,'product_id'=>$pid,'av_quantity'=>$qty,'company_id'=>Auth::user()->company_id, 'new_quantity'=>0,'status'=>'stock adjustment','description'=>'Unlink product and shop', 'user_id'=>Auth::user()->id]);
                        $update = $row->update(['active'=>'no']);         

                        Log::channel('custom')->info('PID: '.$pid.', newQ = 0 .. unlinkShopPro = '.$qty.' .. prevQ = '.$qty);               
                    }
                }
            }
            return response()->json(['status'=>'success','shops'=>$checked_s]);
        }
        
        if($request->status == "update manage store products") {
            $stores = Store::where('company_id',Auth::user()->company_id)->get();
            $arr = explode(',',$request->stores);
            $checked_s = array_map('intval', $arr);
            foreach($stores as $s) {
                if (in_array($s->id,$checked_s)) { // store is checked
                    $row = \DB::connection('tenant')->table('store_products')->where('product_id',$request->pid)->where('store_id',$s->id)->where('active','yes');
                    if($row->first()) {
                        // already attached before 
                    } else { // attach it now
                        \DB::connection('tenant')->table('store_products')->insert(['product_id'=>$request->pid,'store_id'=>$s->id,'active'=>'yes','quantity'=>0, 'created_at' =>  \Carbon\Carbon::now(), 'updated_at' =>  \Carbon\Carbon::now()]);
                    }
                } else { // store is not checked
                    $row = \DB::connection('tenant')->table('store_products')->where('product_id',$request->pid)->where('store_id',$s->id)->where('active','yes');
                    if($row->first()) { // was attached before, unlink it now
                        StockAdjustment::create(['from'=>'store','from_id'=>$row->first()->store_id,'product_id'=>$row->first()->product_id,'av_quantity'=>$row->first()->quantity,'company_id'=>Auth::user()->company_id, 'new_quantity'=>0,'status'=>'stock adjustment','description'=>'Unlink product and store', 'user_id'=>Auth::user()->id]);
                        $update = $row->update(['active'=>'no']);                        
                    }
                }
            }
            return response()->json(['status'=>'success','stores'=>$checked_s]);
        }
    }
     
    public function delete(Request $request) {
        $data = array();
        if ($request->status == "customer") {
            $find = Customer::where('id',$request->cid)->where('company_id',Auth::user()->company_id)->first();
            if ($find) {
                $find->update(['status'=>'deleted','user_id'=>Auth::user()->id]);
                return response()->json(['success'=>'deleted','cid'=>$request->cid,'cname'=>$request->cname]);
            } else {
                return response()->json(['status'=>'error']);
            }
        }
        
        if ($request->status == "added stock quantity") {
            $delete = NewStock::where('id',$request->id)->where('user_id',Auth::user()->id)->where('company_id',Auth::user()->company_id)->update(['status'=>'deleted']);
            if ($delete) {
                return response()->json(['status'=>'success','id'=>$request->id]);
            } 
        }
        
        if ($request->status == "customer deposited amount") {
            $row = \App\CustomerDebt::where('company_id',Auth::user()->company_id)->where('id',$request->eid)->where('status','weka pesa')->first();
            if ($row) {
                $row->status2 = $row->status;
                $row->status = "deleted";
                $row->timestamps = false; // update without changing updated_at
                $row->save();
                return response()->json(['status'=>'success','id'=>$row->id]);
            } 
        }
        if ($request->status == "customer debt paid") {
            $row = \App\CustomerDebt::where('company_id',Auth::user()->company_id)->where('id',$request->eid)->where('status','pay debt')->first();
            if ($row) {
                $row->status2 = $row->status;
                $row->status = "deleted";
                $row->timestamps = false; // update without changing updated_at
                $row->save();
                return response()->json(['status'=>'success','id'=>$row->id]);
            } 
        }
        if ($request->status == "customer refund") {
            $row = \App\CustomerDebt::where('company_id',Auth::user()->company_id)->where('id',$request->eid)->where('status','refund')->first();
            if ($row) {
                $row->status2 = $row->status;
                $row->status = "deleted";
                $row->timestamps = false; // update without changing updated_at
                $row->save();
                return response()->json(['status'=>'success','id'=>$row->id]);
            } 
        }

        if ($request->status == "sale row") {
            $row = Sale::where('id',$request->id)->where('company_id',Auth::user()->company_id)->first();
            if ($row) {
                $edited_at = date('Y-m-d H:i:s');   
                $solddate = date("d-m-Y", strtotime($row->updated_at));
                $q = DB::connection('tenant')->table('shop_products')->where('shop_id',$row->shop_id)->where('product_id',$row->product_id)->where('active','yes');
                if ($q->first()) {
                    $update = $row->update(['status'=>'deleted','edited_at'=>$edited_at,'edited_by'=>Auth::user()->id]);
                    if ($update) {
                        $currQ = $q->first()->quantity;
                        $quantity = ($currQ + $row->quantity);
                        $q->update(['quantity'=>$quantity]);

                        Log::channel('custom')->info('PID: '.$row->product_id.', newQ = '.$quantity.' .. deletedSaleQ = '.$row->quantity.' .. prevQ = '.$currQ);

                        $deni = CustomerDebt::where('reference',$row->sale_no)->where('company_id',Auth::user()->company_id)->first();
                        if ($deni) {
                            $stock_val = Sale::where('sale_no',$row->sale_no)->where('status','sold')->where('company_id',Auth::user()->company_id)->sum('sub_total');
                            if ($stock_val) {
                                $amount_paid = $deni->amount_paid;
                                $newdeni = $stock_val - $amount_paid;
                                $deni->update(['debt_amount'=>$newdeni,'stock_value'=>$stock_val]);
                            } else {
                                $deni->delete();
                            }
                        }

                        $data['predate'] = "no";
                        if ($solddate != date("d-m-Y")) { //check if deleting today sold item OR previous date
                            $data['predate'] = $solddate;
                        }

                        return response()->json(['success'=>'deleted','data'=>$data]);
                    }
                } else {
                    $update = $row->update(['status'=>'deleted','edited_at'=>$edited_at,'edited_by'=>Auth::user()->id]);
                    if($update) {
                        $deni = CustomerDebt::where('reference',$row->sale_no)->where('company_id',Auth::user()->company_id)->first();
                        if ($deni) {
                            $stock_val = Sale::where('sale_no',$row->sale_no)->where('status','sold')->where('company_id',Auth::user()->company_id)->sum('sub_total');
                            if ($stock_val) {
                                $amount_paid = $deni->amount_paid;
                                $newdeni = $stock_val - $amount_paid;
                                $deni->update(['debt_amount'=>$newdeni,'stock_value'=>$stock_val]);
                            } else {
                                $deni->delete();
                            }
                        }

                        $data['predate'] = "no";
                        if ($solddate != date("d-m-Y")) { //check if deleting today sold item OR previous date
                            $data['predate'] = $solddate;
                        }

                        return response()->json(['success'=>'deleted','data'=>$data]);
                    }
                } 
            } else {
                return response()->json(['error'=>'error']);
            }
        }

        if ($request->status == "delete shop") {
            // tables to clear: user_shops, user_roles, transfers, stock_adjustments, shop_products, shop_expenses, return_sold_items, new_stock, customer_debts, closure_sales, sales, shops
            if (Auth::user()->isCEOorAdminorBusinessOwner()) {
                $shop = Shop::where('id',$request->shop_id)->where('company_id',Auth::user()->company_id)->first();
                Delete::create(['type'=>'shop','name'=>$shop->name,'who_deleted'=>Auth::user()->id]);
                // user_shops
                $cashiers = DB::connection('tenant')->table('user_shops')->where('shop_id',$shop->id)->where('who','cashier')->get();
                if ($cashiers->isNotEmpty()) {
                    foreach($cashiers as $cashier) { // delete/untouch cashiers
                        $delete = DB::connection('tenant')->table('user_shops')->where('user_id',$cashier->user_id)->where('shop_id',$shop->id)->where('who','cashier')->delete();
                        if ($delete) {
                            $check = DB::connection('tenant')->table('user_shops')->where('user_id',$cashier->user_id)->where('who','cashier')->get();
                            if ($check->isEmpty()) {
                                DB::table('user_roles')->where('user_id',$cashier->user_id)->where('role_id',6)->delete();
                            }
                        }
                    }
                }
                $salepersons = DB::connection('tenant')->table('user_shops')->where('shop_id',$shop->id)->where('who','sale person')->get();
                if ($salepersons->isNotEmpty()) {
                    foreach($salepersons as $saleperson) { // delete/untouch saleperson
                        $delete = DB::connection('tenant')->table('user_shops')->where('user_id',$saleperson->user_id)->where('shop_id',$shop->id)->where('who','sale person')->delete();
                        if ($delete) {
                            $check = DB::connection('tenant')->table('user_shops')->where('user_id',$saleperson->user_id)->where('who','sale person')->get();
                            if ($check->isEmpty()) {
                                DB::table('user_roles')->where('user_id',$saleperson->user_id)->where('role_id',7)->delete();
                            }
                        }
                    }
                }
                // sent transfers
                Transfer::where('from','shop')->where('from_id',$shop->id)->where('company_id',Auth::user()->company_id)->delete();
                // received transfers
                Transfer::where('destination','shop')->where('destination_id',$shop->id)->where('company_id',Auth::user()->company_id)->delete();
                // stock adjustment
                StockAdjustment::where('from','shop')->where('from_id',$shop->id)->where('company_id',Auth::user()->company_id)->where('status','stock adjustment')->delete();
                // stock taking
                StockAdjustment::where('from','shop')->where('from_id',$shop->id)->where('company_id',Auth::user()->company_id)->where('status','stock taking')->delete();
                // shop products
                DB::connection('tenant')->table('shop_products')->where('shop_id',$shop->id)->delete();
                // shop expenses
                ShopExpense::where('shop_id',$shop->id)->where('company_id',Auth::user()->company_id)->delete();
                // return sold items
                ReturnSoldItem::where('company_id',Auth::user()->company_id)->where('shop_id',$shop->id)->delete();
                // new stock
                NewStock::where('company_id',Auth::user()->company_id)->where('shop_id',$shop->id)->delete();
                // customer debts
                CustomerDebt::where('shop_id',$shop->id)->where('company_id',Auth::user()->company_id)->delete();
                // closure sales
                ClosureSale::where('company_id',Auth::user()->company_id)->where('shop_id',$shop->id)->delete();
                // sales
                Sale::where('company_id',Auth::user()->company_id)->where('shop_id',$shop->id)->delete();
                // shop
                $shop->delete();

                return response()->json(['status'=>'success']);
            } else {
                return response()->json(['status'=>'error']);
            }            
        }

        if ($request->status == "delete store") {
            // table to clear: user_store, user_roles, transfers, store_products, stock_adjustment, new_stock, stores
            if (Auth::user()->isCEOorAdminorBusinessOwner()) {
                $store = Store::where('id',$request->store_id)->where('company_id',Auth::user()->company_id)->first();
                Delete::create(['type'=>'store','name'=>$store->name,'who_deleted'=>Auth::user()->id]);
                // user_stores
                $smasters = DB::connection('tenant')->table('user_stores')->where('store_id',$store->id)->where('who','store master')->get();
                if ($smasters->isNotEmpty()) {
                    foreach($smasters as $smaster) { // delete/untouch smasters
                        $delete = DB::connection('tenant')->table('user_stores')->where('user_id',$smaster->user_id)->where('store_id',$store->id)->where('who','store master')->delete();
                        if ($delete) {
                            $check = DB::connection('tenant')->table('user_stores')->where('user_id',$smaster->user_id)->where('who','store master')->get();
                            if ($check->isEmpty()) {
                                DB::table('user_roles')->where('user_id',$smaster->user_id)->where('role_id',8)->delete();
                            }
                        }
                    }
                }
                // sent transfers
                Transfer::where('from','store')->where('from_id',$store->id)->where('company_id',Auth::user()->company_id)->delete();
                // received transfers
                Transfer::where('destination','store')->where('destination_id',$store->id)->where('company_id',Auth::user()->company_id)->delete();
                // stock adjustment
                StockAdjustment::where('from','store')->where('from_id',$store->id)->where('company_id',Auth::user()->company_id)->where('status','stock adjustment')->delete();
                // stock taking
                StockAdjustment::where('from','store')->where('from_id',$store->id)->where('company_id',Auth::user()->company_id)->where('status','stock taking')->delete();
                // shop products
                DB::connection('tenant')->table('store_products')->where('store_id',$store->id)->delete();
                // new stock
                NewStock::where('company_id',Auth::user()->company_id)->where('store_id',$store->id)->delete();
                // store
                $store->delete();

                return response()->json(['status'=>'success']);
            } else {
                return response()->json(['status'=>'error']);
            }
        }

        if ($request->status == "sub category") {
            $delete = ProductCategory::where('id',$request->id)->where('company_id',Auth::user()->company_id)->update(['status'=>'deleted','user_id'=>Auth::user()->id]);
            if ($delete) {
                $products = Product::where('product_category_id',$request->id)->where('company_id',Auth::user()->company_id)->get();
                if ($products) {
                    foreach($products as $value) {
                        $delete2 = $value->update(['status'=>'deleted','user_id'=>Auth::user()->id]);
                        if ($delete2) {
                            DB::connection('tenant')->table("shop_products")->where("product_id",$value->id)->where('active','yes')->update(['active'=>'no']);
                            DB::table("store_products")->where("product_id",$value->id)->where('active','yes')->update(['active'=>'no']);
                            // $rows = DB::table("shop_products")->where("product_id",$value->id)->where('active','yes')->get();
                            // foreach($rows as $value2) {
                            //     if ($value2->quantity == 0) {
                            //         DB::table("shop_products")->where("id",$value2->id)->update(['active'=>'no']);
                            //     }
                            // }
                            // $rows2 = DB::table("store_products")->where("product_id",$value->id)->where('active','yes')->get();
                            // foreach($rows2 as $value3) {
                            //     if ($value3->quantity == 0) {
                            //         DB::table("store_products")->where("id",$value3->id)->update(['active'=>'no']);
                            //     }
                            // }
                        }
                    }
                }
                return response()->json(['status'=>'success']);
            } else {
                return response()->json(['status'=>'error']);
            }
        }

        if($request->status == "expense name") {
            $e = Expense::where('company_id',Auth::user()->company_id)->where('id',$request->id)->first();
            if($e) { 
                $e->update(['status'=>'deleted']);
                return response()->json(['status'=>'success','id'=>$request->id,'name'=>$request->name]);
            }
        }
        
        if($request->status == "delete supplier") {
            $e = \App\Supplier::where('company_id',Auth::user()->company_id)->where('id',$request->id)->first();
            if($e) { 
                $e->update(['status'=>'deleted']);
                return response()->json(['status'=>'success']);
            }
        }
    }

    public function update_data($check, $check2) {
        if($check == 'close-muongozo') {
            $cid = $check2;
            Company::find($cid)->update(['status2'=>null]);
            return response()->json(['status'=>'success']);
        }

        if($check == "remove-product-from-shop") {         
            $shopro = explode("~", $check2); // shop id and product id
            $sid = $shopro[0];
            $pid = $shopro[1];

            $shop = Shop::where('id',$sid)->where('company_id',Auth::user()->company_id)->first();
            if($shop) { //check if user is authorised 
                $remove = \DB::connection('tenant')->table('shop_products')->where('shop_id',$sid)->where('product_id',$pid)->where('active','yes')->update(['active'=>'no']);
                if($remove) {
                    return response()->json(['status'=>'success']);
                }
            }
        }

        if($check == "remove-product-from-store") {         
            $shopro = explode("~", $check2); // shop id and product id
            $sid = $shopro[0];
            $pid = $shopro[1];

            $store = Store::where('id',$sid)->where('company_id',Auth::user()->company_id)->first();
            if($store) { //check if user is authorised
                $remove = \DB::connection('tenant')->table('store_products')->where('store_id',$sid)->where('product_id',$pid)->where('active','yes')->update(['active'=>'no']);
                if($remove) {
                    return response()->json(['status'=>'success']);
                }
            }
        }

        if ($check == "daily-sales") {   
            $shopro = explode("~", $check2); // shop id and date
            $shop_id = $shopro[0];
            $date = $shopro[1];
            $date = date("Y-m-d", strtotime($date));
            $sales = \App\Sale::where('shop_id',$shop_id)->where('status','sold')->whereDate('updated_at', $date)->get();
            $expenses = \App\ShopExpense::where('shop_id',$shop_id)->whereDate('created_at', $date)->get();
            if ($sales->isNotEmpty() || $expenses->isNotEmpty()) {
                $t_sales = $sales->sum('sub_total');
                $quantities = $sales->sum('quantity');
                $t_expenses = $expenses->sum('amount');
                $profit = $sales->sum('sub_total') - $sales->sum('total_buying');
    
                $dsale = \App\DailySale::where('date',$date)->where('shop_id',$shop_id)->first();
                if($dsale) {
                    $dsale->update(['total_sales'=>$t_sales,'quantities'=>$quantities,'total_expenses'=>$t_expenses,'profit'=>$profit]);
                } else {
                    \App\DailySale::create(['date'=>$date, 'shop_id'=>$shop_id,'company_id'=>Auth::user()->company_id,'total_sales'=>$t_sales,'quantities'=>$quantities,'total_expenses'=>$t_expenses,'profit'=>$profit]);
                }
            }              
            return response()->json(['status'=>'success']);
        }
    }

    public function pdf($check,$condition) {
        if($check == "preview-invoice") {
            $ono = $condition;
            $data['company'] = \App\Company::find(Auth::user()->company_id);
            $data['sales'] = \App\Sale::where('sale_no',$ono)->where('company_id',$data['company']->id)->get();
            $data['sump'] = \App\Sale::where('sale_no',$ono)->where('company_id',$data['company']->id)->sum('sub_total');
            $data['sale'] = \App\Sale::where('sale_no',$ono)->where('company_id',$data['company']->id)->first();
            $pdf = PDF::loadView('pdfs.invoice', compact('data'))
            ->setPaper('a4', 'portrait');
    
            return $pdf->stream();
        }
        
        if($check == "sales-report") {
            $shopmonthyear = $condition;     
            $shopro = explode("-", $shopmonthyear); // shop id and product id
            $shop_id = $shopro[0];
            $m = $shopro[1];
            $y = $shopro[2];

            $sh = Shop::find($shop_id);
            if($sh) {
                $data['shopname'] = $sh->name;
            }

            $data['thismonth'] = $m." ".$y;
            $date = date_parse($m);
            $data['monthyear'] = $thism = $date['month'];
            
            $start_date = date($y.'-'.$thism.'-01'); 
            $end_date = date("Y-m-t 00:01", strtotime($start_date));            
            
            // var_dump($end_date);
            // exit;
            
            // $start_date = date($thism.'-01-'.$y); 
            // $end_date  = date($thism.'-t-'.$y);
            
            // $start_date = "01-03-2024"; 
            // $end_date  = "31-03-2024"; 
                                 
            $start_date = date_create($start_date);
            $end_date = date_create($end_date);
            $interval = new DateInterval('P1D');
            $date_range = new DatePeriod($start_date, $interval, $end_date);
           
            // $date_range = array_reverse(iterator_to_array($date_range));
            $sales = array();
            $ttsale = $tquantity = $tprofit = $texpenses = 0;
            foreach ($date_range as $date2) {
                // var_dump($date2->format('Y-m-d'));
                // exit;
                $tsale = $quantity = $profit = $expenses = 0;
                $s = \App\DailySale::where('company_id',Auth::user()->company_id)->where('date', $date2->format('Y-m-d'))->where('shop_id',$shop_id)->first();
                if($s) {
                    $quantity = $s->quantities + 0;
                    $tsale = number_format($s->total_sales, 0);
                    $profit = number_format($s->profit, 0);
                    $expenses = number_format($s->total_expenses, 0);
                    
                    $ttsale = $ttsale + $s->total_sales;
                    $tquantity = $tquantity + $s->quantities;
                    $tprofit = $tprofit + $s->profit;
                    $texpenses = $texpenses + $s->total_expenses;
                }

                $sales[] = "<td>".$date2->format('d-m-Y')."</td><td>".$quantity."</td><td>".$tsale."</td><td>".$profit."</td><td>".$expenses."</td>";
            }

            $sales[] = "<td>Total</td><td>".$tquantity."</td><td>".number_format($ttsale, 0)."</td><td>".number_format($tprofit, 0)."</td><td>".number_format($texpenses, 0)."</td>";

            $pdf = PDF::loadView('pdfs.sales-report', compact(['data','sales']))
            ->setPaper('a4', 'portrait');
    
            return $pdf->stream();
        }
        
        if ($check == 'available-products') {
            $sid = $condition;
            $company_id = Auth::user()->company_id;
            $shopname = Shop::find($sid)->name;
            $products = Product::query()->select([
                DB::raw('products.name as name,products.buying_price as buying_price, products.retail_price as selling_price, shop_products.quantity as quantity')
            ])
            ->join('shop_products','shop_products.product_id','products.id')
            ->where('shop_products.shop_id',$sid)->where('products.company_id',$company_id)->where('products.status','published')->where('shop_products.active','yes')
            ->orderBy('products.name')->limit(600)->get();
            
            $pdf = PDF::loadView('pdfs.available-products', compact(['products','shopname']))
            ->setPaper('a4', 'portrait');
    
            return $pdf->stream();
        }

        if ($check == 'available-products-store') {
            $sid = $condition;
            $company_id = Auth::user()->company_id;
            $storename = Store::find($sid)->name;
            $products = Product::query()->select([
                DB::raw('products.name as name,products.buying_price as buying_price, products.retail_price as selling_price, store_products.quantity as quantity')
            ])
            ->join('store_products','store_products.product_id','products.id')
            ->where('store_products.store_id',$sid)->where('products.company_id',$company_id)->where('products.status','published')->where('store_products.active','yes')
            ->orderBy('products.name')->limit(600)->get();
            
            $pdf = PDF::loadView('pdfs.available-products-store', compact(['products','storename']))
            ->setPaper('a4', 'portrait');
    
            return $pdf->stream();
        }
    }

}

 
