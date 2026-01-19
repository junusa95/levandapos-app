<?php

namespace App\Http\Controllers;

use DB;
use Session;
use App\District;
use App\Region;
use App\Ward;
use App\Company;
use App\Country;
use App\Currency;
use App\Measurement;
use App\User;
use App\Shop;
use App\ProductCategory;
use App\ProductCategoryGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use App\Services\TenantDatabaseCreator;
use Illuminate\Contracts\Encryption\DecryptException;

class CompanyController extends Controller
{

    public function index() {
        if(Auth::check()) {
            return redirect('/home');
        }
        $data['accounts'] = Company::all()->count();
        $data['users'] = User::all()->count();
        $shops = \App\Shop::all()->count();
        $stores = \App\Store::all()->count();
        $data['stores'] = $shops+$stores;
        $data['customers'] = \App\Customer::all()->count();
        return view('website.index', compact('data'));
    }

    public function new_account() {
        $data['countries'] = Country::orderBy('name')->get();
        $data['currencies'] = Currency::orderBy('name')->get();
        return view('new-account', compact('data'));
    }

    public function agent_registration() {
        return view('auth.agent-registration');
    }
    
    public function levanda_pos_agent() {
        return view('agent.about-levanda-pos-agent');
    }

    public function count_installation() {
        \App\AppInstallation::create(['counts'=>1]);
    }

    public function store(Request $request) {
        $company_id = 0;
        try {

            $company = Company::create(['name'=>$request->name,'about'=>$request->about_comp,'currency_id'=>$request->change_currency,'status'=>'free trial','status2'=>'new','country_id'=>$request->country_id,'cashier_stock_approval'=>'no','can_transfer_items'=>'no','has_product_categories'=>'no']);

            if ($company) {

                $company_id = $company->id;

                // Generate database name & credentials
                $dbName = "lpos_".$company_id;
                $username = env('DB_USERNAME');
                $password = env('DB_PASSWORD');

                $company->update(['dbname'=>$dbName]);

                // name = username.. bcoz on account registeration we dont fill full name field
                $user = User::create(['name'=>$request->username,'username'=>$request->username,'password'=>Hash::make($request->password),'phonecode'=>$request->phonecode, 'phone'=>$request->phone,'status'=>'active','company_id'=>$company_id]);
    
                if ($user) {     
                    foreach($request->input('roles') as $role){
                        $user->roles()->attach($role);
                    }
                    
                    $fname = $company->name;
                    $fname = preg_replace("/\.[^.]+$/", "", $fname);
                    $fname = preg_replace("/[^a-zA-Z0-9]+/", "_", $fname);
                    $cfolder = $company->id.'_'.$fname;
                    $company->update(['folder'=>$cfolder,'contact_person'=>$user->id,'created_by'=>$user->id]);
                }

                // Create the tenant database + run migrations
                TenantDatabaseCreator::createTenantDatabase($dbName, $username, $password);

                $shop = Shop::create(['name'=>$request->shopname,'location'=>$request->shoplocation,'has_customers'=>'yes','company_id'=>$company->id,'user_id'=>$user->id,
                    'country_id'=>$request->country_id,
                    'region_id'=>$request->region_id,
                    'district_id'=>$request->district_id,
                    'ward_id'=>$request->ward_id]);
                if ($shop) {
                    DB::connection('tenant')->table('user_shops')->insert(['user_id'=>$user->id,'shop_id'=>$shop->id,'who'=>'cashier']);
                }

                // default unit of measurement   
                Measurement::create(['name' => 'Unit', 'symbol' => 'U', 'company_id'=>$company->id, 'user_id' => $user->id]);
                $pcg = ProductCategoryGroup::create(['name'=>'main','company_id'=>$company->id,'user_id'=>$user->id]);
                if($pcg) {
                    ProductCategory::create(['name'=>'un-categorized','product_category_group_id'=>$pcg->id,'company_id'=>$company->id, 'user_id' => $user->id]);
                }

                // check if is agent create this 
                if($request->is_agent) {
                    DB::table('agent_companies')->insert(['user_id'=>Auth::user()->id,'company_id'=>$company->id]);
                }

            }

        } catch (Exception $e) {
            return response()->json(['status'=>'error']);
        }
        
        return response()->json(['status'=>'success','cid'=>$company_id,'username'=>$request->username,'password'=>$request->password]);
    }

    public function store_bkp(Request $request) {
        $company = Company::where('id',$request->cid)->where('status','new')->where('contact_person',null)->first();
        if (!$company) {
            return response()->json(['status'=>'error']);
        } 

        // check company folder name 
        $cfolder = $company->folder;
        if (!$cfolder) {
            $fname = $company->name;
            $fname = preg_replace("/\.[^.]+$/", "", $fname);
            $fname = preg_replace("/[^a-zA-Z0-9]+/", "_", $fname);
            $cfolder = $company->id.'_'.$fname;
        }

        DB::beginTransaction();
        try {
            $user = User::create(['username'=>$request->username,'password'=>Hash::make($request->password),'phonecode'=>$request->phonecode, 'phone'=>$request->phone,'status'=>'active','company_id'=>$request->cid]);
            $company->update(['about'=>$request->about_comp,'currency_id'=>$request->change_currency,'status'=>'free trial','country_id'=>$request->country_id,'contact_person'=>$user->id,'folder'=>$cfolder,'updated_by'=>$user->id]);
            foreach($request->input('roles') as $role){
                $user->roles()->attach($role);
                // DB::table('user_roles')->insert(['user_id' => $user->id, 'role_id'=>$role]);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['status'=>'error']);
        }
        
        return response()->json(['status'=>'success']);
    }

    public function register_agent(Request $request) {
        DB::beginTransaction();
        try {
                $user = User::create(['name'=>$request->fname,'address'=>$request->region,'username'=>$request->username,'password'=>Hash::make($request->password),'phonecode'=>$request->phonecode, 'phone'=>$request->phone,'status'=>'active']);    
                if ($user) {     
                    foreach($request->input('roles') as $role){
                        $user->roles()->attach($role); // attach agent role
                    }                    
                }

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['status'=>'error']);
        }
        
        Session::put('new-agent','yes');
        return response()->json(['status'=>'success','username'=>$request->username,'password'=>$request->password]);
    }

    public function update(Request $request, Company $company)
    {
        //
    }

    public function check($check,$data2) {
        if ($check == "configuration") {
            try {
                $cid = Crypt::decrypt($data2);
            } catch (DecryptException $e) {
                dd("Sorry, the link you inserted is invalid. Please contact the admin for help.");
            }            
            $data['company'] = Company::where('id',$cid)->where('status','new')->where('contact_person',null)->first();
            if ($data['company']) {
                $data['countries'] = Country::orderBy('name')->get();
                $data['currencies'] = Currency::orderBy('name')->get();
                return view('configuration', compact('data'));
            } else {
                return redirect('/home');
            }
        }

        if ($check == "check-user-name") {
            $checkuser = User::where('username',trim($data2))->first();
            if ($checkuser) {
                return response()->json(['status'=>'error']);
            }            
            return response()->json(['status'=>'success']);
        }
    }

    public function company_profile() {
        $data['company'] = Company::where('id',Auth::user()->company_id)->first();
        $data['countries'] = Country::all();
        return view('company-profile', compact('data'));
    }

    public function billing_and_payments() { 
        $data['payments'] = \App\Payment::where('company_id',Auth::user()->company->id)->orderBy('id','desc')->get();
        return view('billing-and-payments', compact('data'));
    }

    public function settings() { 
        $data['company'] = 'test';
        return view('settings', compact('data'));
    }

    public function getRegionData() {

        $data['regions'] = Region::where('country_id', request()->country_id)->orderBy('name')->get();
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

    public function getDistrictData() {

        $data['districts'] = District::where('region_id', request()->region_id)->orderBy('name')->get();
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


    public function getWardData() {

        $data['wards'] = Ward::where('district_id', request()->district_id)->orderBy('name')->get();
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

}
