<?php

namespace App\Http\Controllers;

use DB;
use File;
use Image;
use Session;
use App\Company;
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
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use Maestroerror\HeicToJpg;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function stock() {        
        if(Session::get('role') == 'Cashier' || Session::get('role') == 'Store Master') {
            if (Auth::user()->isCEOorAdmin()) {
                Session::put('role','CEO');
            }
            if (Auth::user()->isBusinessOwner()) {
                Session::put('role','Business Owner');
            }
        }
        $data['shops'] = Shop::where('company_id',Auth::user()->company_id)->get();
        $data['stores'] = Store::where('company_id',Auth::user()->company_id)->get();
        return view('stock',compact('data'));
    }

    public function new_product_form($check) {
        if ($check == 'admin') {
            Session::put('role','Admin');
        } elseif ($check == 'ceo') {
            Session::put('role','CEO');
        }
        $data['cgroups'] = ProductCategoryGroup::where('company_id',Auth::user()->company_id)->get();
        $data['measurements'] = Measurement::where('company_id',Auth::user()->company_id)->get();
        $data['shops'] = Shop::where('company_id',Auth::user()->company_id)->get();
        $data['stores'] = Store::where('company_id',Auth::user()->company_id)->get();
        return view('create-product',compact('data'));
    }

    public static function stockQuantity($check,$id) {
        if ($check == 'shop') {
            $quantity = NewStock::where('shop_id',$id)->where('company_id',Auth::user()->company_id)->where('status','sent')->get()->sum('added_quantity');
        } else {
            $quantity = NewStock::where('store_id',$id)->where('company_id',Auth::user()->company_id)->where('status','sent')->get()->sum('added_quantity');
        }
        return $quantity;
    }

    public function stock_check($check,$id) {
        if ($check == 'view') {
            $totalStQ = 0;
            $clear = "";
            $item = NewStock::where('id',$id)->where('company_id',Auth::user()->company_id)->first();
            if ($item) {
                $items = NewStock::where('shop_id',$item->shop_id)->where('company_id',Auth::user()->company_id)->where('store_id',$item->store_id)->where('status',$item->status)->get();
                if ($items->isNotEmpty()) {
                    foreach($items as $value) { 
                        $totalStQ = $totalStQ + $value->added_quantity;  
                        if ($value->shop_id) {
                            $whereto = $value->shop->name." (shop)";
                        }              
                        if ($value->store_id) {
                            $whereto = $value->store->name." (store)";
                        }              
                        if ($value->user_id == Auth::user()->id) {
                            $clear = '<td><span class="p-1 text-danger remove-str" val="'.$value->id.'" style="cursor: pointer;"><i class="fa fa-times"></i></span></td></tr>';
                        }
                        $output[] = '<tr class="str-'.$value->id.'"><td>'.$value->product->name.'</td>'
                            .'<td><input type="number" class="form-control form-control-sm st-quantity" placeholder="Q" name="quantity" value="'.sprintf('%g',$value->added_quantity).'" step="0.01" sid="'.$value->id.'" style="width:80px" disabled></td>'
                            .$clear;
                    }
                } else {
                    $output[] = '<tr class="empty-row"><td colspan="3" align="center"><i>-- No items --</i></td></tr>';
                }
                return response()->json(['items'=>$output,'totalStQ'=>$totalStQ,'whereto'=>$whereto,'id'=>$id]);
            }
        }

        if ($check == "delete") {
            $item = NewStock::where('id',$id)->where('company_id',Auth::user()->company_id)->first();
            if ($item) {
                NewStock::where('user_id',Auth::user()->id)->where('shop_id',$item->shop_id)->where('store_id',$item->store_id)->where('company_id',Auth::user()->company_id)->where('status',$item->status)->update(['status'=>'deleted']);
                return response()->json(['success'=>'done']);
            }
        }

        if ($check == "receive") {
            // check for minimum stock level 
            if(Auth::user()->company->isCheckingStockLevel()){ $min_stock = "yes"; } else { $min_stock = "no"; }

            $received_at = date('Y-m-d H:i:s');
            $stock = NewStock::where("id",$id)->where("status","sent")->where('company_id',Auth::user()->company_id)->first();
            if ($stock) {
                if ($stock->shop_id == null) {
                    $shopstore = "store";
                    $ssid = $stock->store_id;
                    $pro = \DB::connection('tenant')->table('store_products')->where('store_id',$stock->store_id)->where('product_id',$stock->product_id)->where('active','yes');
                } else {
                    $shopstore = "shop";
                    $ssid = $stock->shop_id;
                    $pro = \DB::connection('tenant')->table('shop_products')->where('shop_id',$stock->shop_id)->where('product_id',$stock->product_id)->where('active','yes');
                }

                if ($pro->first()) {
                    $av_qty = $pro->first()->quantity;
                    $new_qty = $av_qty + $stock->added_quantity;
                    $update = $stock->update(['available_quantity'=>$av_qty,'new_quantity'=>$new_qty,'status'=>"updated","received_by"=>Auth::user()->id,"received_at"=>$received_at]);
                    if($update) {
                        $pro->update(['quantity'=>$new_qty]);

                        Log::channel('custom')->info('PID: '.$stock->product_id.', newQ = '.$new_qty.' .. addedQ = '.$stock->added_quantity.' .. prevQ = '.$av_qty);
                        
                        if($min_stock == "yes") {          
                            $prod = \App\Product::find($stock->product_id);                  
                            if($prod->min_stock_level >= $new_qty) {
                                ProductController::insertMSL($prod->id,$shopstore,$ssid,$prod->min_stock_level);
                            } else {
                                if($shopstore == "shop") {
                                    $check = \App\Notification::where('shop_id',$ssid)->where('product_id',$prod->id)->first();
                                    if($check) {
                                        $check->update(['product_id'=>null]);
                                    }
                                } else {
                                    $check = \App\Notification::where('store_id',$ssid)->where('product_id',$prod->id)->first();
                                    if($check) {
                                        $check->update(['product_id'=>null]);
                                    }
                                }
                            }
                        }
                    }
                } else {
                    if ($stock->shop_id == null && $stock->store_id != null) {
                        $add = DB::connection('tenant')->table('store_products')->insert(['store_id' => $stock->store_id, 'product_id'=>$stock->product_id, 'quantity'=>$stock->added_quantity, 'active'=>'yes', 'created_at' =>  \Carbon\Carbon::now(), 'updated_at' =>  \Carbon\Carbon::now()]);
                        if ($add) {
                            $stock->update(['available_quantity'=>0,'new_quantity'=>$stock->added_quantity,'status'=>"updated","received_by"=>Auth::user()->id,"received_at"=>$received_at]);
                            
                            if($min_stock == "yes") {          
                                $prod = \App\Product::find($stock->product_id);                  
                                if($prod->min_stock_level >= $stock->added_quantity) {
                                    ProductController::insertMSL($prod->id,'store',$stock->store_id,$prod->min_stock_level);
                                } else {
                                    $check = \App\Notification::where('store_id',$stock->store_id)->where('product_id',$prod->id)->first();
                                    if($check) {
                                        $check->update(['product_id'=>null]);
                                    }
                                }
                            }
                        }
                    } 
                    if ($stock->store_id == null && $stock->shop_id != null) {
                        $add = DB::connection('tenant')->table('shop_products')->insert(['shop_id' => $stock->shop_id, 'product_id'=>$stock->product_id, 'quantity'=>$stock->added_quantity, 'active'=>'yes', 'created_at' =>  \Carbon\Carbon::now(), 'updated_at' =>  \Carbon\Carbon::now()]);
                        if ($add) {
                            $stock->update(['available_quantity'=>0,'new_quantity'=>$stock->added_quantity,'status'=>"updated","received_by"=>Auth::user()->id,"received_at"=>$received_at]);
                            
                            Log::channel('custom')->info('PID: '.$stock->product_id.', newQ = '.$stock->added_quantity.' .. addedQ = '.$stock->added_quantity.' .. prevQ = 0');

                            if($min_stock == "yes") {          
                                $prod = \App\Product::find($stock->product_id);                  
                                if($prod->min_stock_level >= $stock->added_quantity) {
                                    ProductController::insertMSL($prod->id,'shop',$stock->shop_id,$prod->min_stock_level);
                                } else {
                                    $check = \App\Notification::where('shop_id',$stock->shop_id)->where('product_id',$prod->id)->first();
                                    if($check) {
                                        $check->update(['product_id'=>null]);
                                    }
                                }
                            }
                        }
                    }
                }
            } else {
                return response()->json(['error'=>'Something went wrong!']);
            }
            return response()->json(['success'=>'done']);
        }
    }

    public function categories_by_id($group_id) {
        if($group_id == 'all') {
            $cats = ProductCategory::where('status','!=','deleted')->orWhereNull('status')->where('company_id',Auth::user()->company_id)->orderBy('name')->get();
        } else {
            $group = ProductCategoryGroup::where('id',$group_id)->where('company_id',Auth::user()->company_id)->first();;
            $cats = $group->productcategories()->get();
        }
        return response()->json(['cats'=>$cats]);
    }

    public static function insertMSL($pid,$shopstore,$sid,$mlevel) {
        $shop_id = $store_id = null;
        $p = \App\Product::find($pid);
        $sub_title = $p->name.' is below the required stock level';
        if($shopstore == "shop") {
            $s = \App\Shop::find($sid);
            $shop_id = $s->id;
            $check = \App\Notification::where('shop_id',$sid)->where('product_id',$pid)->first();
        }
        if($shopstore == "store") {
            $s = \App\Store::find($sid);
            $store_id = $s->id;
            $check = \App\Notification::where('store_id',$sid)->where('product_id',$pid)->first();
        }
        $desc = '<h5>Minimus Stock Level</h5><p>'.$p->name.' is below the required stock level in '.$s->name.'. <br> The minimum stock level is '.($mlevel + 0).'</p>';
        
        if($check) {} else {
            \App\Notification::create(['company_id'=>Auth::user()->company_id,'title'=>'Minimum Stock Level','sub_title'=>$sub_title,'description'=>$desc,'type'=>'minimum stock level','shop_id'=>$shop_id,'store_id'=>$store_id,'product_id'=>$p->id]);
        }
        return;
    }

    public function store(Request $request) { 
        $expire_date = null;
        if($request->expire_date) {
            $ex_date = str_replace('/', '-', $request->expire_date);
            $expire_date = date("Y-m-d", strtotime($ex_date));
        }
        $product = Product::create(['name'=>$request->name, 'buying_price'=>$request->buying_price, 'wholesale_price'=>$request->wholesale_price, 'retail_price'=>$request->retail_price,'company_id'=>Auth::user()->company_id, 'measurement_id'=>$request->measurement, 'product_category_id'=>$request->pcategory, 'status'=>$request->status, 'user_id' => Auth::user()->id,'expire_date'=>$expire_date,'min_stock_level'=>$request->min_stock_level]);
        if ($product) {
            if($request->from_shop == "yes") { //insert quantity
                $ssid = $shop_id = $request->shop_id;
                $shop = Shop::find($shop_id);
                $shopstore = "shop";
                $total_buying = $request->quantity * $product->buying_price;
                $insert = NewStock::create([
                    'product_id'=>$product->id,'shop_id'=>$shop->id,'store_id'=>null, 
                    'added_quantity'=>$request->quantity,'buying_price'=>$product->buying_price,'total_buying'=>$total_buying,'company_id'=>Auth::user()->company_id,
                    'user_id'=>Auth::user()->id,'status'=>'updated','sent_at'=>date('Y-m-d H:i:s')
                    ]);
                if($insert) {
                    $pro = \DB::connection('tenant')->table('shop_products')->where('shop_id',$shop->id)->where('product_id',$product->id)->where('active','yes'); 
                    if ($pro->first()) {
                        $av_qty = $pro->first()->quantity;
                        $new_qty = $av_qty + $request->quantity;
                        $update = $insert->update(['available_quantity'=>$av_qty,'new_quantity'=>$new_qty,'received_by'=>Auth::user()->id,'received_at'=>date('Y-m-d H:i:s')]);
                        if($update) {
                            $pro->update(['quantity'=>$new_qty]);

                            Log::channel('custom')->info('PID: '.$product->id.', newQ = '.$new_qty.' .. addedQ = '.$request->quantity.' .. prevQ = '.$av_qty);
                        }
                    } else {
                        $add = DB::connection('tenant')->table('shop_products')->insert(['shop_id' => $shop->id, 'product_id'=>$product->id, 'quantity'=>$request->quantity, 'active'=>'yes', 'created_at' =>  \Carbon\Carbon::now(), 'updated_at' =>  \Carbon\Carbon::now()]);
                        if ($add) {
                            $insert->update(['available_quantity'=>0,'new_quantity'=>$request->quantity,'received_by'=>Auth::user()->id,'received_at'=>date('Y-m-d H:i:s')]);

                            Log::channel('custom')->info('PID: '.$product->id.', newQ = '.$request->quantity.' .. addedQ = '.$request->quantity.' .. prevQ = 0');
                        }
                    }
                    // check for minimum stock level 
                }
            }
            if($request->from_store == "yes") {
                $ssid = $store_id = $request->store_id;
                $store = Store::find($store_id);
                $shopstore = "store";
                $insert = NewStock::create([
                    'product_id'=>$product->id,'shop_id'=>null,'store_id'=>$store->id,
                    'added_quantity'=>$request->quantity,'buying_price'=>$product->buying_price,'company_id'=>Auth::user()->company_id,
                    'user_id'=>Auth::user()->id,'status'=>'updated','sent_at'=>date('Y-m-d H:i:s')
                    ]);
                if($insert) {
                    $pro = \DB::connection('tenant')->table('store_products')->where('store_id',$store->id)->where('product_id',$product->id)->where('active','yes'); 
                    if ($pro->first()) {
                        $av_qty = $pro->first()->quantity;
                        $new_qty = $av_qty + $request->quantity;
                        $update = $insert->update(['available_quantity'=>$av_qty,'new_quantity'=>$new_qty,'received_by'=>Auth::user()->id,'received_at'=>date('Y-m-d H:i:s')]);
                        if($update) {
                            $pro->update(['quantity'=>$new_qty]);
                        }
                    } else {
                        $add = DB::connection('tenant')->table('store_products')->insert(['store_id' => $store->id, 'product_id'=>$product->id, 'quantity'=>$request->quantity, 'active'=>'yes', 'created_at' =>  \Carbon\Carbon::now(), 'updated_at' =>  \Carbon\Carbon::now()]);
                        if ($add) {
                            $insert->update(['available_quantity'=>0,'new_quantity'=>$request->quantity,'received_by'=>Auth::user()->id,'received_at'=>date('Y-m-d H:i:s')]);
                        }
                    }
                }
            }
            // checking for minimum stock level 
            if(Auth::user()->company->isCheckingStockLevel()){
                if($request->min_stock_level >= $request->quantity) {
                    $this->insertMSL($product->id,$shopstore,$ssid,$request->min_stock_level);
                }
            } 
            if ($request->store) { //this is not working
                for ($i=0; $i < count($request->store); $i++) { 
                    $store_id = $request->store[$i];
                    $quantity = $request->input('stquantity'.$store_id);
                    DB::connection('tenant')->table('store_products')->insert(['store_id' => $store_id, 'product_id'=>$product->id, 'quantity'=>$quantity, 'active'=>'yes', 'created_at' =>  \Carbon\Carbon::now(), 'updated_at' =>  \Carbon\Carbon::now()]);
                }
            }
            if ($request->shop) { //this is not working
                for ($j=0; $j < count($request->shop); $j++) { 
                    $shop_id = $request->shop[$j];
                    $quantity = $request->input('shquantity'.$shop_id);
                    DB::connection('tenant')->table('shop_products')->insert(['shop_id' => $shop_id, 'product_id'=>$product->id, 'quantity'=>$quantity, 'active'=>'yes', 'created_at' =>  \Carbon\Carbon::now(), 'updated_at' =>  \Carbon\Carbon::now()]);
                }
            }
            // product image
            if($request->hasFile('image')) {

                $f = $request->file('image');
                    
                if (HeicToJpg::isHeic($f)) { // heic format used by iphone users
                    
                    // $filename = uniqid() . time() . rand(10, 1000000) . '.jpg';
                    // HeicToJpg::convert($f)->saveAs(public_path().'/images/companies/'.$filename);

                    $f = HeicToJpg::convert($f)->get();
                }

                $manager = new ImageManager(new Driver());
                $image = $manager->read($f);
                $image->scaleDown(width: 540);
                
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
                $products_path = public_path().'/images/companies/'.$cfolder.'/products';
                if (! File::exists($products_path)) {
                    File::makeDirectory($products_path, $mode = 0777, true, true);
                }                

                // Main Image Upload on Folder Code
                $ext = $request->file('image')->getClientOriginalExtension();
                $orig_name = preg_replace("/\.[^.]+$/", "", $request->file('image')->getClientOriginalName());
                $orig_name = preg_replace("/[^a-zA-Z0-9]+/", "_", $orig_name);
                $imageName = time().'-'.$orig_name.'.jpg'; // convert all images to jpg
                $destinationPath = public_path('images/companies/'.$cfolder.'/products/');
                
                if ($image->save($destinationPath.$imageName)) {
                    $product->update(['image'=>$imageName]);
                } 
            }
            
            return response()->json(['success'=>'Success! '.$product->name.' created successfully.','pid'=>$product->id,'pname'=>$product->name]);
        } else {
            return response()->json(['error'=>'Error! Something went wrong, please try again.']);
        }
    }

    public function update(Request $request) {
        $expire_date = null;
        if($request->expire_date) {
            $ex_date = str_replace('/', '-', $request->expire_date);
            $expire_date = date("Y-m-d", strtotime($ex_date));
        }
        $product = Product::where('id',$request->pid)->where('company_id',Auth::user()->company_id)->first();
        if ($product) {
            $update = $product->update(['name'=>$request->name, 'buying_price'=>$request->buying_price, 'wholesale_price'=>$request->wholesale_price, 'retail_price'=>$request->retail_price, 'measurement_id'=>$request->measurement, 'product_category_id'=>$request->pcategory, 'status'=>$request->status, 'user_id' => Auth::user()->id,'expire_date'=>$expire_date,'min_stock_level'=>$request->min_stock_level]);
            if ($update) {
                // product image
                if($request->hasFile('image')) {
                    
                    $f = $request->file('image');
                    
                    if (HeicToJpg::isHeic($f)) { // heic format used by iphone users

                        $f = HeicToJpg::convert($f)->get();
                    }

                    $manager = new ImageManager(new Driver());
                    $image = $manager->read($f);
                    $image->scaleDown(width: 540);
                    
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
                    $products_path = public_path().'/images/companies/'.$cfolder.'/products';
                    if (! File::exists($products_path)) {
                        File::makeDirectory($products_path, $mode = 0777, true, true);
                    }                

                    // Main Image Upload to Folder Code
                    $ext = $request->file('image')->getClientOriginalExtension();
                    $orig_name = preg_replace("/\.[^.]+$/", "", $request->file('image')->getClientOriginalName());
                    $orig_name = preg_replace("/[^a-zA-Z0-9]+/", "_", $orig_name);
                    $imageName = time().'-'.$orig_name.'.jpg'; // convert all images to jpg
                    $destinationPath = public_path('images/companies/'.$cfolder.'/products/');
                    
                    if ($image->save($destinationPath.$imageName)) {
                        $product->update(['image'=>$imageName]);
                    } 
                }
                
                return response()->json(['status'=>'success','pname'=>$product->name,'pid'=>$product->id]);
            }
        }
        if(isset($request->s_status)) { //return error to shop
            return response()->json(['status'=>'error']);
        } else {
            return redirect()->back()->with('error', 'Error! Something went wrong, please try again.');
        }
    }

    public function update_quantity(Request $request) {
        if ($request->store) {
            $count = count($request->store);
            for ($i=0; $i < $count; $i++) { 
                $store_id = $request->store[$i];
                $quantity = $request->input('stquantity'.$store_id);
                $check = DB::connection('tenant')->table('store_products')->where('store_id',$store_id)->where('product_id',$request->pid)->where('active','yes');
                if ($check->first()) {
                    if ($check->first()->quantity == $quantity) { } else {
                        $check->update(['quantity'=>$quantity]);
                    }                    
                } else {
                    DB::connection('tenant')->table('store_products')->insert(['store_id' => $store_id, 'product_id'=>$request->pid, 'quantity'=>$quantity, 'active'=>'yes', 'created_at' =>  \Carbon\Carbon::now(), 'updated_at' =>  \Carbon\Carbon::now()]);
                }
            }
        }
        if ($request->shop) {
            for ($j=0; $j < count($request->shop); $j++) { 
                $shop_id = $request->shop[$j];
                $quantity = $request->input('shquantity'.$shop_id);
                $check = DB::connection('tenant')->table('shop_products')->where('shop_id',$shop_id)->where('product_id',$request->pid)->where('active','yes');
                if ($check->first()) {
                    $currQ = $check->first()->quantity;
                    $diff_q = $quantity - $currQ;
                    if ($currQ == $quantity) { } else {
                        $check->update(['quantity'=>$quantity]);

                        Log::channel('custom')->info('PID: '.$request->pid.', newQ = '.$quantity.' .. addedQ = '.$diff_q.' .. prevQ = '.$currQ);
                    }                    
                } else {
                    DB::connection('tenant')->table('shop_products')->insert(['shop_id' => $shop_id, 'product_id'=>$request->pid, 'quantity'=>$quantity, 'active'=>'yes', 'created_at' =>  \Carbon\Carbon::now(), 'updated_at' =>  \Carbon\Carbon::now()]);

                    Log::channel('custom')->info('PID: '.$request->pid.', newQ = '.$quantity.' .. addedQ = '.$quantity.' .. prevQ = 0');
                }                
            }
        }
        return redirect()->back()->with('success', 'Success! Quantity updated successfully.');
    }

    public function products() { 
        if(Session::get('role') == 'Cashier' || Session::get('role') == 'Store Master') {
            if (Auth::user()->isCEOorAdmin()) {
                Session::put('role','CEO');
            }
            if (Auth::user()->isBusinessOwner()) {
                Session::put('role','Business Owner');
            }
        }
        $data['groups'] = ProductCategoryGroup::where('company_id',Auth::user()->company_id)->get();
        $data['measurements'] = Measurement::where('company_id',Auth::user()->company_id)->get();
        $data['shops'] = Shop::where('company_id',Auth::user()->company_id)->get();
        $data['stores'] = Store::where('company_id',Auth::user()->company_id)->get();
        return view('products',compact('data'));
    }

    public static function totalQuantity($pid) {
        $quantity = DB::connection('tenant')->table('shop_products')->where('product_id',$pid)->where('active','yes')->sum('quantity');
        $quantity2 = DB::connection('tenant')->table('store_products')->where('product_id',$pid)->where('active','yes')->sum('quantity');
        return ($quantity+$quantity2);
    }

    public function edit_product($check,$pid) {
        if (Auth::user()->isCEOorAdmin()) {
            $data['product'] = Product::where('id',$pid)->where('company_id',Auth::user()->company_id)->first();
            $data['product-category'] = $data['product']->productcategory;
            $data['category-group'] = $data['product-category']->categorygroup;
            $data['categories'] = ProductCategory::where('status','!=','deleted')->orWhereNull('status')->where('company_id',Auth::user()->company_id)->orderBy('name')->get();
            $data['cgroups'] = ProductCategoryGroup::where('company_id',Auth::user()->company_id)->get();
            $data['shops'] = Shop::where('company_id',Auth::user()->company_id)->get();
            $data['stores'] = Store::where('company_id',Auth::user()->company_id)->get(); 
            $data['status'] = ['published','unpublished'];
            $data['stquantity'] = DB::connection('tenant')->table('store_products')->where('product_id',$pid)->where('active','yes')->get();
            $data['shquantity'] = DB::connection('tenant')->table('shop_products')->where('product_id',$pid)->where('active','yes')->get();
            return view('edit-product',compact('data'));
        } else {
            return redirect()->back()->with('error', 'Oops! It seems like you dont have permission to edit products.');
        }
    }

    public function shosto_quantity($from,$fromid,$pid) {
        $product = Product::where('id',$pid)->where('company_id',Auth::user()->company_id)->first();
        if ($from == 'shop') {
            $quantity = $product->shopProductRelation($fromid)->quantity;
        } 
        if ($from == 'store') {
            $quantity = $product->storeProductRelation($fromid)->quantity;
        }
        return response()->json(['quantity'=>$quantity]);
    }

    public function receive_items($tno) {   
        $check = Transfer::where('transfer_no',$tno)->where('company_id',Auth::user()->company_id)->first();
        if ($check->status == 'sent') {
            $rows = Transfer::where('transfer_no',$tno)->where('company_id',Auth::user()->company_id)->get();
            if ($rows->isNotEmpty()) {
                // check for minimum stock level 
                if(Auth::user()->company->isCheckingStockLevel()){ $min_stock = "yes"; } else { $min_stock = "no"; }  

                foreach($rows as $row) {
                    $received_at = date('Y-m-d H:i:s');
                    $update = $row->update(['receiver_id'=>Auth::user()->id, 'received_at'=>$received_at,'status'=>'received']);
                    if ($update) {
                        if ($row->destination == 'store') {
                            $q = DB::connection('tenant')->table('store_products')->where('store_id',$row->destination_id)->where('product_id',$row->product_id)->where('active','yes');
                            if ($q->first()) {
                                $quantity = ($q->first()->quantity + $row->quantity);
                                $q->update(['quantity'=>$quantity]);
                            } else {
                                $quantity = $row->quantity;
                                DB::connection('tenant')->table('store_products')->insert(['store_id' => $row->destination_id, 'product_id'=>$row->product_id, 'quantity'=>$row->quantity, 'active'=>'yes', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()]);
                            }          
                            
                            if($min_stock == "yes") {          
                                $pro = \App\Product::find($row->product_id);      
                                if($pro->min_stock_level >= $quantity) {
                                    ProductController::insertMSL($pro->id,'store',$row->destination_id,$pro->min_stock_level);
                                } else {
                                    $check = \App\Notification::where('store_id',$row->destination_id)->where('product_id',$row->product_id)->first();
                                    if($check) {
                                        $check->update(['product_id'=>null]);
                                    }
                                }
                            }                      
                        }
                        if ($row->destination == 'shop') {
                            $q = DB::connection('tenant')->table('shop_products')->where('shop_id',$row->destination_id)->where('product_id',$row->product_id)->where('active','yes');
                            if ($q->first()) {
                                $currQ = $q->first()->quantity;
                                $quantity = ($currQ + $row->quantity);
                                $q->update(['quantity'=>$quantity]);

                                Log::channel('custom')->info('PID: '.$row->product_id.', newQ = '.$quantity.' .. receivedQ = '.$row->quantity.' .. prevQ = '.$currQ);
                            } else {
                                $quantity = $row->quantity;
                                DB::connection('tenant')->table('shop_products')->insert(['shop_id' => $row->destination_id, 'product_id'=>$row->product_id, 'quantity'=>$row->quantity, 'active'=>'yes', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()]);

                                Log::channel('custom')->info('PID: '.$row->product_id.', newQ = '.$row->quantity.' .. receivedQ = '.$row->quantity.' .. prevQ = 0');
                            }     
                            
                            if($min_stock == "yes") {          
                                $pro = \App\Product::find($row->product_id);      
                                if($pro->min_stock_level >= $quantity) {
                                    ProductController::insertMSL($pro->id,'shop',$row->destination_id,$pro->min_stock_level);
                                } else {
                                    $check = \App\Notification::where('shop_id',$row->destination_id)->where('product_id',$row->product_id)->first();
                                    if($check) {
                                        $check->update(['product_id'=>null]);
                                    }
                                }
                            }                  
                        }
                    }
                }
                return response()->json(['success'=>'Success! Items are transfered from your store.']);
            }
        }
        
        return response()->json(['success'=>'success']);
    }

    public function search_product($stoshop,$check,$shostoid,$pname) {
        $output = array();
        if ($pname == 'sdfvaafv') {
            // above is keyword for empty search
            if ($stoshop == 'shop') {
                $products = DB::connection('tenant')->table('products')->join('shop_products','shop_products.product_id','products.id')->where('products.status','published')->where('products.company_id',Auth::user()->company_id)->where('shop_products.shop_id',$shostoid)->where('shop_products.active','yes')->select('*','products.id AS pid')->get();
            } 
            if ($stoshop == 'store') {
                $products = DB::connection('tenant')->table('products')->join('store_products','store_products.product_id','products.id')->where('products.status','published')->where('products.company_id',Auth::user()->company_id)->where('store_products.store_id',$shostoid)->where('store_products.active','yes')->select('*','products.id AS pid')->limit(10)->get();
            }       
            if ($stoshop == 'ceo') {
                $products = DB::connection('tenant')->table('products')->select('*','products.id AS pid')->where('company_id',Auth::user()->company_id)->where('status','published')->limit(10)->get();
            }           
        } else {
            if ($stoshop == 'shop') {
                $products = DB::connection('tenant')->table('products')->join('shop_products','shop_products.product_id','products.id')->where('products.status','published')->where('products.company_id',Auth::user()->company_id)->where('shop_products.shop_id',$shostoid)->where('shop_products.active','yes')->where('products.name','like','%'.$pname.'%')->select('*','products.id AS pid')->limit(20)->get();
            } 
            if ($stoshop == 'store') {
                $products = DB::connection('tenant')->table('products')->join('store_products','store_products.product_id','products.id')->where('products.status','published')->where('products.company_id',Auth::user()->company_id)->where('store_products.store_id',$shostoid)->where('store_products.active','yes')->where('products.name','like','%'.$pname.'%')->select('*','products.id AS pid')->limit(20)->get();
            }       
            if ($stoshop == 'ceo') {
                $products = DB::connection('tenant')->table('products')->where('products.name','like','%'.$pname.'%')->where('company_id',Auth::user()->company_id)->where('status','published')->select('*','products.id AS pid')->limit(20)->get();
            }            
        }        

        if ($products->isEmpty()) {
            $output = '<div class="center" style="color: red"> -- No result --</div>';
        } else {
            foreach ($products as $value) {
                if (!isset($value->quantity)) {
                    $value->quantity = 0;
                }
                $selling_price = rtrim(rtrim(number_format($value->retail_price,2),0),'.');
                $output[] = "<div class='searched-item px-2 py-2 border' check='".$check."' val='".$value->pid."' qty='".$value->quantity."' price='".round($value->retail_price, 0)."'>"
                                .$value->name.
                            "<span style='float:right'>".$selling_price."/=</span></div>";
            }
        }
        return response()->json(['products'=>$output]);
    }
    public function search_product_2($stoshop,$shostoid) {
        if ($stoshop == 'shop') {
            $products = Product::query()->select([
                DB::raw("products.id as pid, products.name as pname, shop_products.quantity as quantity, products.retail_price as rprice")
            ])
            ->join('shop_products','shop_products.product_id','products.id')
            ->where('products.status','published')->where('products.company_id',Auth::user()->company_id)
            ->where('shop_products.shop_id',$shostoid)->where('shop_products.active','yes')->get();
        } 
        if ($stoshop == 'store') {
            $products = DB::connection('tenant')->table('products')->join('store_products','store_products.product_id','products.id')->where('products.status','published')->where('products.company_id',Auth::user()->company_id)->where('store_products.store_id',$shostoid)->where('store_products.active','yes')->select('*','products.id AS pid')->limit(10)->get();
        }       
        if ($stoshop == 'ceo') {
            $products = DB::connection('tenant')->table('products')->select('*','products.id AS pid')->where('company_id',Auth::user()->company_id)->where('status','published')->limit(10)->get();
        }     
        
        return response()->json(['products'=>$products]);      
    }

    public function save_as_copy($id) {
        $product = Product::where('id',$id)->where('company_id',Auth::user()->company_id)->first();
        if ($product) {
            $data = $product->replicate();
            $data = $data->toArray();
            $create = Product::create($data);     
            $create->update(['name'=>$product->name.' copy']);       
        } else {
            return response()->json(['error'=>'Error! Something went wrong. Please try again']);
        }
        return response()->json(['success'=>'success', 'id'=>$create->id]);
    }

    public function delete_product($id) {
        $row = Product::where('id',$id)->where('company_id',Auth::user()->company_id)->first();
        if ($row) {
            $delete = $row->update(['status'=>'deleted','user_id'=>Auth::user()->id]);
            if ($delete) {
                $rows = DB::connection('tenant')->table("shop_products")->where("product_id",$row->id)->where('active','yes')->update(['active'=>'no']);

                $rows2 = DB::connection('tenant')->table("store_products")->where("product_id",$row->id)->where('active','yes')->update(['active'=>'no']);
                
                NewStock::where('product_id',$row->id)->where('company_id',Auth::user()->company_id)->where('status','sent')->update(['status'=>'deleted']);
                // delete from sales table with draft status 
                \App\Sale::where('company_id',Auth::user()->company_id)->where('product_id',$row->id)->where('status','draft')->update(['status'=>'deleted']);
            }
            return response()->json(['success'=>'success','id'=>$row->id,'name'=>$row->name]);
        }        
    }

}
