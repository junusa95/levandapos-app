<?php

namespace App\Http\Controllers\Apps;

use App\ClosureSale;
use App\Company;
use App\Country;
use App\Currency;
use App\CustomerDebt;
use App\Delete;
use App\District;
use App\Http\Controllers\Controller;
use App\Measurement;
use App\NewStock;
use App\ProductCategory;
use App\ProductCategoryGroup;
use App\Region;
use App\ReturnSoldItem;
use App\Sale;
use App\Shop;
use App\ShopExpense;
use App\StockAdjustment;
use App\Transfer;
use App\User;
use App\Ward;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\Return_;
use App\Services\TenantDatabaseCreator;

class ShopController extends Controller
{
    /**
     * @SWG\Get(
     *     path="/users",
     *     summary="Get a list of users",
     *     tags={"Users"},
     *     @SWG\Response(response=200, description="Successful operation"),
     *     @SWG\Response(response=400, description="Invalid request")
     * )
     */
    public function shops($user_id)
    {
        $user = User::find($user_id);
        if ($user) {
            // $data['shops'] =  Shop::with(['country:id,name','region:id,name','district:id,name','ward:id,name'])
            //                         ->where('user_id', $user->id)
            //                         ->where('company_id', $user->company_id)
            //                         ->orderBy('created_at', 'desc')
            //                         ->get(); 
            $mainDb = config('database.connections.mysql.database');
            if (Auth::user()->isCEOorAdminorBusinessOwner()){
                $data['shops'] =  Shop::with(['country:id,name','region:id,name','district:id,name','ward:id,name'])
                                    ->where('company_id', $user->company_id)
                                    ->orderBy('created_at', 'desc')
                                    ->get();
            } else {
                $data['shops'] =  Shop::with(['country:id,name','region:id,name','district:id,name','ward:id,name'])
                        ->select('shops.*')
                        ->join('user_shops','user_shops.shop_id','shops.id')
                                    ->where('user_shops.user_id',$user->id)
                                    ->where('shops.company_id', $user->company_id)
                                    ->orderBy('shops.created_at', 'desc')
                                    ->get(); 
            }

            if ($data['shops']->isNotEmpty()) {
                $message = "All shops found for user"." ".$user->name;
            }else {
                $message = "No shop found for user"." ".$user->name;
            }

            return response()->json([
                'status' =>  1,
                'message' => $message,
                'data' => $data,
            ]);
        } else {
            return response()->json([
                'status' =>  0,
                'message' => 'shops not found'
            ]);
        }
    }

    public function shop_details($shop_id)
    {
        $user = Auth::user();
        if ($user) {
            $data['shop'] =  Shop::with(['country:id,name','region:id,name','district:id,name','ward:id,name'])
                                    ->where('id', $shop_id)
                                    ->where('user_id', $user->id)
                                    ->where('company_id', $user->company_id)
                                    ->first();

            if ($data['shop']->isNotEmpty()) {
                $message = "shop details found for user"." ".$user->name;
            }else {
                $message = "No shop detail found for user"." ".$user->name;
            }

            return response()->json([
                'status' =>  1,
                'message' => $message,
                'data' => $data,
            ]);
        } else {
            return response()->json([
                'status' =>  0,
                'message' => 'user not found'
            ]);
        }
    }

    public function shop_register()
    {
        // return 123;
        $data['countries'] = Country::orderBy('name')->get();
        $data['currencies'] = Currency::orderBy('name')->get();

        return response()->json([
            'status' =>  1,
            'message' => 'shop registration',
            'data' => $data,
        ]);
    }

    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }
        // return 123;
        $company_id = 0;
        
        try {
            $company = Company::create([
                'name'=>$request->username.' '."POS",
                'about'=>$request->about_comp,
                'currency_id'=>$request->currency_id,
                'status'=>'free trial',
                'status2'=>'new',
                'country_id'=>$request->country_id,
                'cashier_stock_approval'=>'no',
                'can_transfer_items'=>'no','has_product_categories'=>'no'
            ]);

            if ($company) {
                $company_id = $company->id;

                // Generate database name & credentials
                $dbName = "lpos_".$company_id;
                $username = env('DB_USERNAME');
                $password = env('DB_PASSWORD');

                $company->update(['dbname'=>$dbName]);

                // name = username.. bcoz on account registeration we dont fill full name field
                $user = User::create([
                    'name'=>$request->username,
                    'username'=>$request->username,
                    'password'=>Hash::make($request->password),
                    'phonecode'=>$request->dial_code,
                    'phone'=>$request->phone_number,
                    'status'=>'active',
                    'company_id'=>$company->id
                ]);

                if ($user) {
                    $roles =['2','3','6'];
                    // foreach($roles as $role){
                        $user->roles()->attach($roles);
                        // DB::table('user_roles')->insert(['user_id' => $user->id, 'role_id'=>$role]);
                    // }

                    $fname = $company->name;
                    $fname = preg_replace("/\.[^.]+$/", "", $fname);
                    $fname = preg_replace("/[^a-zA-Z0-9]+/", "_", $fname);
                    $cfolder = $company->id.'_'.$fname;
                    $company->update(['folder'=>$cfolder,'contact_person'=>$user->id,'created_by'=>$user->id]);

                    // Create the tenant database + run migrations
                    TenantDatabaseCreator::createTenantDatabase($dbName, $username, $password);

                    $shop = Shop::create([
                        'name'=>$request->shop_name,
                        'location'=>$request->shop_location,
                        'has_customers'=>'yes',
                        'company_id'=>$company->id,
                        'user_id'=>$user->id,
                        'country_id'=>$request->country_id,
                        'region_id'=>$request->region_id,
                        'district_id'=>$request->district_id,
                        'ward_id'=>$request->ward_id
                    ]);

                    if ($shop) {
                        DB::connection('tenant')->table('user_shops')->insert(['user_id'=>$user->id,'shop_id'=>$shop->id,'who'=>'cashier']);
                    }

                    // default unit of measurement
                    Measurement::create([
                        'name' => 'Unit',
                        'symbol' => 'U',
                        'company_id'=>$company->id,
                        'user_id' => $user->id
                    ]);

                    $pcg = ProductCategoryGroup::create([
                        'name'=>'main',
                        'company_id'=>$company->id,
                        'user_id'=>$user->id
                    ]);

                    if($pcg) {
                        ProductCategory::create([
                            'name'=>'un-categorized',
                            'product_category_group_id'=>$pcg->id,
                            'company_id'=>$company->id,
                            'user_id' => $user->id
                        ]);
                    }

                    $d = [
                        ['name'=>'Umeme','status'=>'active','company_id'=>$company->id,'user_id'=>$user->id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')],
                        ['name'=>'Chakula','status'=>'active','company_id'=>$company->id,'user_id'=>$user->id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')],
                        ['name'=>'Posho','status'=>'active','company_id'=>$company->id,'user_id'=>$user->id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')],
                    ];
                    $i = \App\Expense::insert($d);

                    // check if is agent create this
                    // if($request->is_agent) {
                    //     DB::table('agent_companies')->insert(['user_id'=>Auth::user()->id,'company_id'=>$company->id]);
                    // }

                    // assign company in payments table with free trial
                    // $today = date('Y-m-d');
                    // $endFreeTrial = date("Y-m-d", strtotime("+29 days",strtotime($today)));
                    // \App\Payment::create(['company_id'=>$company->id,'status'=>'free trial','paid_amount'=>0,'paid_date'=>$today,'expire_date'=>$endFreeTrial,'updated_by'=>$user->id]);
                }
            }

            
        } catch (Exception $e) {
            
            return response()->json([
                'status'=> 0,
                'message' => 'shop registration failled',
                'data' => $e,
            ]);
        }

         $data['company_id'] = $company_id;
         $data['username'] = $request->username;
        return response()->json([
                'status' =>  1,
                'message' => 'shop registration successful',
                'data' => $data,
            ]);
    }

    public function getRegionData($country_id) {

        $data['regions'] = Region::where('country_id', $country_id)->orderBy('name')->get();
        // return $data;
        if ($data['regions']) {
            # code...
            $data['status'] = 'success';
        }else {
            # code...
            $data['status'] = 'failed';
        }
        return $data;
    }

    public function getDistrictData($region_id) {

        $data['districts'] = District::where('region_id', $region_id)->orderBy('name')->get();
        // return $data;
        if ($data['districts']) {
            # code...
            $data['status'] = 'success';
        }else {
            # code...
            $data['status'] = 'failed';
        }
        return $data;
    }

    public function getWardData($district_id) {

        $data['wards'] = Ward::where('district_id', $district_id)->orderBy('name')->get();
        // return $data;
        if ($data['wards']) {
            # code...
            $data['status'] = 'success';
        }else {
            # code...
            $data['status'] = 'failed';
        }
        return $data;
    }

    public function getAllCountries() {

        $data['countries'] = Country::all();
        // return $data;
        if ($data['countries']) {
            # code...
            $status = 1;
            $message = "countries found ";
        }else {
            # code...
            $status = 0;
            $message = "countries Not found ";
        }
        // return $data;
        return response()->json([
                'status' =>  $status,
                'message' => $message,
                'data' => $data,
            ]);
    }

    public function getAllRegions() {

        $data['regions'] = Region::all();
        // return $data;
        if ($data['regions']) {
            # code...
            $status = 1;
            $message = "Regions found ";
        }else {
            # code...
            $status = 0;
            $message = "Regions Not found ";
        }
        // return $data;
        return response()->json([
                'status' =>  $status,
                'message' => $message,
                'data' => $data,
            ]);
    }

    public function getAllDistricts() {

        $data['districts'] = District::all();
        // return $data;
        if ($data['districts']) {
            # code...
            $status = 1;
            $message = "districts found ";
        }else {
            # code...
            $status = 0;
            $message = "districts Not found ";
        }
        // return $data;
        return response()->json([
                'status' =>  $status,
                'message' => $message,
                'data' => $data,
            ]);
    }

    public function getAllWards() {

        $data['wards'] = Ward::all();
        // return $data;
        if ($data['wards']) {
            # code...
            $status = 1;
            $message = "wards found ";
        }else {
            # code...
            $status = 0;
            $message = "wards Not found ";
        }
        // return $data;
        return response()->json([
                'status' =>  $status,
                'message' => $message,
                'data' => $data,
            ]);
    }


    public function create_new_shop(Request $request) {
        // if (!Auth::check()) {
        //     return response()->json([
        //         'status' =>  0,
        //         'message' => 'Unauthenticated - Token missing or invalid.'
        //     ]);
        // }

        // return 123;
        DB::beginTransaction();
        try {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
        ]);

        if ($validator->fails()) {

            // return redirect()->back()->with('failed', $validator->errors());

            return response()->json([
                'status'=> 0,
                'message' => 'validation failled',
                'data' => $validator->errors(),
            ]);

        } else {
            // if ($request->status == "new shop") {
                $data['shop'] = Shop::create([
                    'name' => $request->name,
                    'location' => $request->location,
                    'has_customers'=>$request->has_customers, //default yes..... allowedvalueyes/no
                    'company_id'=>Auth::user()->company_id,
                    'user_id' => Auth::user()->id,
                    'country_id'=>$request->country_id,
                    'region_id'=>$request->region_id,
                    'district_id'=>$request->district_id,
                    'ward_id'=>$request->ward_id
                ]);

                // return Auth::user();

                if (!$data['shop']) {
                    return response()->json(['error'=>'Error! Shop not created.']);
                }

                // if ($request->cashier) {
                //     DB::table('user_shops')->insert([
                //         'user_id' => $request->cashier,
                //         'shop_id'=>$data['shop']->id,
                //         'who'=>'cashier'
                //     ]);

                //     $check = DB::table('user_roles')
                //                     ->where('user_id',$request->cashier)
                //                     ->where('role_id',6)
                //                     ->get();

                //     if ($check->isEmpty()) {
                //         DB::table('user_roles')->insert(['user_id' => $request->cashier, 'role_id'=>6]);
                //     }
                // }

                // return response()->json(['success'=>'Success! New shop created successfully.','data'=>$data]);
            // }
        }

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'status'=> 0,
                'message' => 'shop registration failled',
                'data' => $e,
            ]);
        }

        return response()->json([
                'status' =>  1,
                'message' => 'New shop created successfully',
                'data' => $data,
            ]);
    }

    public function add_cashier_to_shop(Request $request) {
        // if (!Auth::check()) {
        //     return response()->json([
        //         'status' =>  0,
        //         'message' => 'Unauthenticated - Token missing or invalid.'
        //     ]);
        // }

        // return 123;
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'shop_id' => ['required'],
                'cashier' => ['required'],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status'=> 0,
                    'message' => 'validation failled',
                    'data' => $validator->errors(),
                ]);

            } else {
                $user = Auth::user();
                if ($user) {
                    $data['shop'] =  Shop::with(['country:id,name','region:id,name','district:id,name','ward:id,name'])
                                            ->where('id', $request->shop_id)
                                            ->where('user_id', $user->id)
                                            ->where('company_id', $user->company_id)
                                            ->first();
                    // return Auth::user();

                    if (!$data['shop']) {
                        return response()->json(['error'=>'Error! Shop not created.']);
                    }

                    if ($request->cashier) {
                        DB::table('user_shops')->insert([
                            'user_id' => $request->cashier,
                            'shop_id'=>$data['shop']->id,
                            'who'=>'cashier'
                        ]);

                        $check = DB::connection('tenant')->table('user_roles')
                                        ->where('user_id',$request->cashier)
                                        ->where('role_id',6)
                                        ->get();

                        if ($check->isEmpty()) {
                            DB::connection('tenant')->table('user_roles')->insert(['user_id' => $request->cashier, 'role_id'=>6]);
                        }
                    }

                    // return response()->json(['success'=>'Success! New shop created successfully.','data'=>$data]);
                }
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'status'=> 0,
                'message' => 'shop user registration failled',
                'data' => $e,
            ]);
        }

        return response()->json([
                'status' =>  1,
                'message' => 'New user on shop created successfully',
                'data' => $data,
            ]);
    }

    public function update_shop(Request $request) {
        // if (!Auth::check()) {
        //     return response()->json([
        //         'status' =>  0,
        //         'message' => 'Unauthenticated - Token missing or invalid.'
        //     ]);
        // }

        $shop = Shop::where('id',$request->shop_id)
                    ->where('company_id',Auth::user()->company_id)
                    ->first();
        if ($shop) {
            $update = $shop->update([
                'name' => $request->name,
                'location' => $request->location,
                'has_customers'=>$request->crecords,
                'user_id' => Auth::user()->id,
                'country_id'=>$request->country_id,
                'region_id'=>$request->region_id,
                'district_id'=>$request->district_id,
                'ward_id'=>$request->ward_id
            ]);
            if ($update) {
                return response()->json([
                    'status' =>  1,
                    'message' => 'New shop updated successfully'
                ]);
            }
        }
        // return response()->json(['error'=>'Error! Something went wrong. Please try again.']);

                return response()->json([
                    'status' =>  0,
                    'message' => 'Something went wrong. Please try again.'
                ]);
    }

    public function delete_shop($shop_id) {
        // return 123;
        // if (!Auth::check()) {
        //     return response()->json([
        //         'status' =>  0,
        //         'message' => 'Unauthenticated - Token missing or invalid.'
        //     ]);
        // }

        if (Auth::user()->isCEOorAdminorBusinessOwner()) {
            $shop = Shop::where('id',$shop_id)->where('company_id',Auth::user()->company_id)->first();
            Delete::create(['type'=>'shop','name'=>$shop->name,'who_deleted'=>Auth::user()->id]);
            // user_shops
            $cashiers = DB::connection('tenant')->table('user_shops')->where('shop_id',$shop->id)->where('who','cashier')->get();
            if ($cashiers->isNotEmpty()) {
                foreach($cashiers as $cashier) { // delete/untouch cashiers
                    $delete = DB::connection('tenant')->table('user_shops')->where('user_id',$cashier->user_id)->where('shop_id',$shop->id)->where('who','cashier')->delete();
                    if ($delete) {
                        $check = DB::connection('tenant')->table('user_shops')->where('user_id',$cashier->user_id)->where('who','cashier')->get();
                        if ($check->isEmpty()) {
                            DB::connection('tenant')->table('user_roles')->where('user_id',$cashier->user_id)->where('role_id',6)->delete();
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
                            DB::connection('tenant')->table('user_roles')->where('user_id',$saleperson->user_id)->where('role_id',7)->delete();
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

            return response()->json([
                'status' =>  1,
                'message' => 'New shop deletion successfully'
            ]);
        } else {
            return response()->json([
                'status'=> 0,
                'message' => 'shop deletion failled'
            ]);
        }

    }

    public function dashboard_shop_details($shop_id) {
        // return 123;
        // return Auth::user();
        // if (!Auth::check()) {
        //     return response()->json([
        //         'status' =>  0,
        //         'message' => 'Unauthenticated - Token missing or invalid.'
        //     ]);
        // }

        // $data['monthlySales'] = DB::table('sales')
        // ->selectRaw('MONTH(submitted_at) as month_number, MONTHNAME(submitted_at) as month_name, SUM(sub_total) as total_sales')
        // ->where('shop_id', $shop_id)
        // ->where('status', 'sold')
        // ->whereYear('submitted_at', Carbon::now()->year)
        // ->groupBy(DB::raw('MONTH(submitted_at)'), DB::raw('MONTHNAME(submitted_at)'))
        // ->orderBy(DB::raw('MONTH(submitted_at)'))
        // ->get();

        // $data['yearlySales'] = DB::table('sales')
        // ->where('shop_id', $shop_id)
        // ->where('status', 'sold')
        // ->whereYear('submitted_at', Carbon::now()->year)
        // ->sum('sub_total');

        // $data['sales'] = DB::table('daily_sales')
        //         ->select('date', DB::raw('SUM(total_sales) as total'))
        //         ->where('shop_id', $shop_id)
        //         ->where('date', '>=', Carbon::now()->subDays(305)->toDateString())
        //         ->groupBy('date')
        //         ->orderBy('date', 'asc')
        //         ->get();


        $startDate = Carbon::now()->subDays(5)->startOfDay();
        $endDate = Carbon::yesterday()->startOfDay();

        $sales = DB::connection('tenant')->table('daily_sales')
            ->select('date', DB::raw('SUM(total_sales) as total'))
            ->where('shop_id', $shop_id)
            ->whereBetween('date', [$startDate->toDateString(), $endDate->toDateString()])
            ->groupBy('date')
            ->pluck('total', 'date');

        $data['sales'] = collect();
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $dateStr = $date->format('Y-d-M');
            $dateStr_total = $date->toDateString();
            $data['sales']->push([
                'date' => $dateStr,
                'total' => $sales[$dateStr_total] ?? 0
            ]);
        }

        $shop = Shop::withCount('productsOnShop')->find($shop_id);

        $data['shop_products'] = $shop?->products_on_shop_count ?? 0;

        $data['total_sales'] = DB::connection('tenant')->table('sales')
                ->where('shop_id', $shop_id)
                ->where('status', 'sold')
                ->whereMonth('updated_at', now()->month)
                ->whereYear('updated_at', now()->year)
                ->sum('sub_total');

        return response()->json([
                'status' =>  1,
                'message' => 'shop data successfully',
                'data' =>$data
            ]);

    }
}
