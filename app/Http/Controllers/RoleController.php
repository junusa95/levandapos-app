<?php

namespace App\Http\Controllers;

use DB;
use App\Role;
use App\User;
use App\Store;
use App\Shop;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function update(Request $request, Role $role)
    {
        //
    }


    public function admin(){ 
        if(Auth::user()->isAdmin()) {
            $data['otherroles'] = Auth::user()->roles()->where('name','!=','Admin')->get();
            $data['CEOs'] = $this->usersOfSpecificRole('CEO');
            Session::put('role','Admin');
            return view('admin.index',compact('data'));
        } else {
            return redirect()->back()->with('error','Sorry! It seems like you dont have permission in this page.');
        }
    }
    
    public function agent(){
        if(Auth::user()->isAgent()) {
            $data['otherroles'] = Auth::user()->roles()->where('name','!=','Agent')->get();
            Session::put('role','Agent');
            return view('agent.index',compact('data'));
        } else {
            return redirect()->back()->with('error','Sorry! It seems like you dont have permission in this page.');
        }
    }

    public function business_owner(){
        $data['otherroles'] = Auth::user()->roles()->where('roles.name','!=','Business Owner')->get();
        $data['shops'] = Shop::where('company_id',Auth::user()->company_id)->get(); 
        $data['stores'] = Store::where('company_id',Auth::user()->company_id)->get(); 
        $data['users'] = User::where('company_id',Auth::user()->company_id)->get(); 
        Session::put('role','Business Owner');
        return view('business-owner.index',compact('data'));
    }

    public function ceo(){
        $data['otherroles'] = Auth::user()->roles()->where('name','!=','CEO')->get();
        $data['shops'] = Shop::where('company_id',Auth::user()->company_id)->get(); 
        $data['stores'] = Store::where('company_id',Auth::user()->company_id)->get(); 
        $data['users'] = User::where('company_id',Auth::user()->company_id)->get(); 
        Session::put('role','CEO');
        return view('ceo.index',compact('data'));
    }

    public function store_master($sid){
        $store = DB::connection('tenant')->table('user_stores')->where('user_id',Auth::user()->id)->where('store_id',$sid)->first();
        if ($store) {
            $data['otherroles'] = Auth::user()->roles()->where('name','!=','Store Master')->get();
            $data['store'] = Store::where('id',$sid)->where('company_id',Auth::user()->company_id)->first(); 
            $data['otherstores'] = DB::connection('tenant')->table('stores')->join('user_stores','user_stores.store_id','stores.id')->where('stores.company_id',Auth::user()->company_id)->where('user_stores.user_id',Auth::user()->id)->where('user_stores.store_id','!=',$sid)->get();
            Session::put('role','Store Master');
            Session::put('sid',$sid);
            return view('store-master.index',compact('data'));
        } else {
            return redirect()->back()->with('error','Sorry! It seems like you dont have permission in this store.');
        }
    }

    public function cashier($sid){
        $shop = DB::connection('tenant')->table('user_shops')->where('user_id',Auth::user()->id)->where('shop_id',$sid)->where('who','cashier')->first();
        if ($shop) {
            $data['otherroles'] = Auth::user()->roles()->where('name','!=','Cashier')->get();
            $data['shop'] = Shop::where('id',$sid)->where('company_id',Auth::user()->company_id)->first(); 
            $data['othershops'] = DB::connection('tenant')->table('shops')->join('user_shops','user_shops.shop_id','shops.id')->where('user_shops.user_id',Auth::user()->id)->where('shops.company_id',Auth::user()->company_id)->where('user_shops.shop_id','!=',$sid)->where('who','cashier')->get();
            Session::put('role','Cashier');
            Session::put('shoid',$sid);
            return view('cashier.index',compact('data'));
        } else {
            return redirect()->back()->with('error','Sorry! It seems like you dont have permission in this shop.');
        }
    }

    public function sales_person($sid){
        $shop = DB::connection('tenant')->table('user_shops')->where('user_id',Auth::user()->id)->where('shop_id',$sid)->where('who','sale person')->first();
        if ($shop) {
            $data['otherroles'] = Auth::user()->roles()->where('name','!=','Sales Person')->get();
            $data['shop'] = Shop::where('id',$sid)->where('company_id',Auth::user()->company_id)->first(); 
            $data['othershops'] = DB::connection('tenant')->table('shops')->join('user_shops','user_shops.shop_id','shops.id')->where('shops.company_id',Auth::user()->company_id)->where('user_shops.user_id',Auth::user()->id)->where('user_shops.shop_id','!=',$sid)->where('who','sale person')->get();
            Session::put('role','Sales Person');
            Session::put('shoid',$sid);
            return view('sales-person.index',compact('data'));
        } else {
            return redirect()->back()->with('error','Sorry! It seems like you dont have permission in this shop.');
        }
    }

    public function usersOfSpecificRole($role_name){
        $role = \App\Role::where('name',$role_name)->first();
        if ($role) {
            $users = \DB::table('users')
                      ->join('user_roles', 'users.id', '=', 'user_roles.user_id')
                      ->where('user_roles.role_id', $role->id)
                      ->where('users.company_id',Auth::user()->company_id)
                      ->where('users.id','!=',1)->get();
            if (!$users->isEmpty()) {
                return $users;
            } else {
                return false; 
            }                    
        } 
        return false;
    }

}
