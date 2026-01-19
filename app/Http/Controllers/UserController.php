<?php

namespace App\Http\Controllers;

use DB;
use Cookie;
use Session;
use App\User;
use App\Role;
use App\Store;
use App\Shop;
use App\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function changeLanguage($lang) {
        // create cookie for 30 days
        $days = (30 * 24 * 60);
        if ($lang == 'sw') {
            Cookie::queue('language','sw',$days);
        } else {
            Cookie::queue('language','en',$days);
        }
        
        return response()->json(['lang'=>$lang]);
    }

    public function create(Request $request) {
        $user = User::create(['name' => trim($request->name), 'username'=>trim($request->username), 'phonecode'=>$request->phonecode, 'phone' => trim($request->phone), 'gender' => $request->gender, 'company_id'=>Auth::user()->company_id, 'email' => trim($request->email), 'status'=>$request->status, 'created_by'=>Auth::user()->id, 'password' => Hash::make(trim($request->password))]);
        if ($user) {
            if ($request->input('roles')) {
                foreach($request->input('roles') as $role){
                    DB::table('user_roles')->insert(['user_id' => $user->id, 'role_id'=>$role]);
                }
                // logics for cashier and sale person 
                if ($request->cashcheck == 1 && $request->spcheck == 1) {
                    if ($request->cashier == $request->sperson) {
                        DB::connection('tenant')->table('user_shops')->insert(['user_id' => $user->id, 'shop_id'=>$request->cashier, 'who'=>'cashier']);
                    } else {
                        DB::connection('tenant')->table('user_shops')->insert(['user_id' => $user->id, 'shop_id'=>$request->cashier, 'who'=>'cashier']);
                        DB::connection('tenant')->table('user_shops')->insert(['user_id' => $user->id, 'shop_id'=>$request->sperson, 'who'=>'sale person']);
                    }
                } else {
                    if ($request->cashcheck == 1) {
                        DB::connection('tenant')->table('user_shops')->insert(['user_id' => $user->id, 'shop_id'=>$request->cashier, 'who'=>'cashier']);
                    }
                    if ($request->spcheck == 1) {
                        DB::connection('tenant')->table('user_shops')->insert(['user_id' => $user->id, 'shop_id'=>$request->sperson, 'who'=>'sale person']);
                    } 
                }
                if ($request->smcheck == 1) {
                // check for store master 
                    DB::connection('tenant')->table('user_stores')->insert(['user_id' => $user->id, 'store_id'=>$request->smaster, 'who'=>'store master']);
                }
            }
        } else {
            return response()->json(['error'=>'Error! user not created.']);
        }
        return response()->json(['success'=>'Success! User created successfully.']);
    }

    public function user($check,$user) {
        if ($check == "user-roles") {
            $roles = array();
            $assshops = array();
            $view = "";
            $user = User::where('id',$user)->where('company_id',Auth::user()->company_id)->where('status','!=','deleted')->first();
            if ($user) {
                $view = view('partials.user-profile-roles',compact('user'))->render();
            }
            return response()->json(['view'=>$view]);
        }

        if ($check == 'admin') {
            Session::put('role','Admin');
        } elseif ($check == 'ceo') {
            Session::put('role','CEO');
        } elseif ($check == 'business-owner') {
            Session::put('role','Business Owner');
        } else {
            return redirect()->back();
        }
        $data['roles'] = Role::where('name','!=','Admin')->get();
        $data['countries'] = Country::all();
        $data['shops'] = Shop::where('company_id',Auth::user()->company_id)->get();
        $data['stores'] = Store::where('company_id',Auth::user()->company_id)->get();
        if ($user == "create") { // link to create user
            return view('create-user',compact('data'));
        } else {
            $data['user'] = User::where('id',$user)->where('status','!=','deleted')->where('company_id',Auth::user()->company_id)->first();
            if ($data['user']) { // link to edit user
                return view('edit-user',compact('data'));
            } else {
                return redirect()->back()->with('error','Sorry! It seems like you dont have permission to edit this user.');
            }
        }
    }
    public function user2($user) {
        if (Auth::user()->isCEOorAdminorBusinessOwner()) {
            $data['roles'] = Role::where('name','!=','Admin')->get();
            $data['countries'] = Country::all();
            $data['shops'] = Shop::where('company_id',Auth::user()->company_id)->get();
            $data['stores'] = Store::where('company_id',Auth::user()->company_id)->get();
            if ($user == "create") { // link to create user
                return view('create-user',compact('data'));
            } else {
                $data['user'] = User::where('id',$user)->where('status','!=','deleted')->where('company_id',Auth::user()->company_id)->first();
                if ($data['user']) { // link to edit user
                    return view('edit-user',compact('data'));
                } else {
                    return redirect()->back()->with('error','Sorry! It seems like you dont have permission to view/edit this user.');
                }
            }
        } else {
            return redirect()->back();
        }
    }

    public function user_profile() {
        $data['countries'] = Country::all();
        return view('user-profile', compact('data'));
    }

    public function update(Request $request) {
        if ($request->check == "update user details") {
            $user = User::where('id',$request->user)->where('company_id',Auth::user()->company_id)->first();
            if ($user) {
                // check for username 
                if ($user->username == trim($request->username)) {
                    // no changes for username
                } else {
                    $checkuser = User::where('username',trim($request->username))->first();
                    if ($checkuser) {
                        return response()->json(['status'=>'username occupied']);
                    } else {
                        $user->update(['username'=>$request->username]);
                    }           
                }
                $user->update(['name' => trim($request->name), 'phonecode'=>$request->phonecode, 'phone' => trim($request->phone), 'gender' => $request->gender, 'email' => trim($request->email), 'address' => $request->address, 'status' => $request->status]);
                
                return response()->json(['status'=>'success']);
            } else {
                return response()->json(['status'=>'error']);
            }        
        }
        if ($request->check == "update user roles") {
            $user = User::where('id',$request->user)->where('company_id',Auth::user()->company_id)->first();
            if ($user) {
                DB::table('user_roles')->where('user_id',$user->id)->whereIn('role_id',[1,2,3,4,5,9,10])->delete();
                if ($request->input('roles')) {                        
                    foreach($request->input('roles') as $role){
                        if ($role == 1 || $role == 2 || $role == 3 || $role == 4 || $role == 5 || $role == 9 || $role == 10) {
                            DB::table('user_roles')->insert(['user_id' => $user->id, 'role_id'=>$role]);
                        }                    
                    }
                } 
                return response()->json(['status'=>'success']);
            }
        }
        if ($request->check == "update user status") {
            $user = User::where('id',$request->uid)->where('company_id',Auth::user()->company_id)->first();
            if ($user) {
                if ($request->action == "Activate") { $status = "active"; }
                if ($request->action == "Block") { $status = "blocked"; }
                if ($request->action == "Delete") { $status = "deleted"; }
                $update = $user->update(['status'=>$status]);
                if ($update) {
                    if ($request->action == "Block" || $request->action == "Delete") {
                        
                    }
                }
                return response()->json(['status'=>'success','uname'=>$user->username]);
            } else {
                return response()->json(['status'=>'error']);
            }
        }
        if ($request->check == "update user password") {
            if (Auth::user()->username == "admin") {
                $user = User::where('id',$request->user)->first();
            } else {
                $user = User::where('id',$request->user)->where('company_id',Auth::user()->company_id)->first();
            }            
            if ($user) {
                $user->update(['password' => Hash::make($request->password)]);
            } else {
                return response()->json(['status'=>'error']);
            }
            return response()->json(['status'=>'success']);
        }

        if ($request->check == "assign-bo-role") {
            $bo = DB::table('user_roles')->where('user_id',$request->user)->where('role_id',2)->first();
            if($bo) {
                return response()->json(['status'=>'success']);
            } else {
                DB::table('user_roles')->insert(['user_id'=>$request->user,'role_id'=>2]);
                return response()->json(['status'=>'success']);
            }
        }
    }

    public function add_cashier(Request $request) {
        $user = User::where('id',$request->user_id)->where('company_id',Auth::user()->company_id)->first();
        $shop = Shop::where('id',$request->shop_id)->where('company_id',Auth::user()->company_id)->first();
        
        if ($this->untouchSalePerson($request->user_id,$request->shop_id)) { // untouch sale person 
            if ($user->hasCashierRole()) { // then, attach user to shop
                $check = DB::connection('tenant')->table('user_shops')->where('user_id',$request->user_id)->where('shop_id',$request->shop_id);
                if ($check->first()) {
                    $check->update(['who'=>'cashier']);
                } else {
                    DB::connection('tenant')->table('user_shops')->insert(['user_id' => $request->user_id, 'shop_id'=>$request->shop_id, 'who'=>'cashier']);
                }
            } else {
                $cashierRole = DB::table('user_roles')->insert(['user_id' => $user->id, 'role_id'=>6]);
                if ($cashierRole) { // then, attach user to shop
                    $check = DB::connection('tenant')->table('user_shops')->where('user_id',$request->user_id)->where('shop_id',$request->shop_id);
                    if ($check->first()) {
                        $check->update(['who'=>'cashier']);
                    } else {
                        DB::connection('tenant')->table('user_shops')->insert(['user_id' => $request->user_id, 'shop_id'=>$request->shop_id, 'who'=>'cashier']);
                    }
                }
            }
            return response()->json(['success'=>'Success! Access granted successfully.','user'=>$request->user_id,'shop'=>$request->shop_id,'shopname'=>$shop->name]);
        }
    }
    public function untouchSalePerson($uid,$sid) {
        $sperson = DB::connection('tenant')->table('user_shops')->where('user_id',$uid)->where('shop_id',$sid)->where('who','sale person');
        if ($sperson->first()) {
            $delete = $sperson->delete();
            if($delete) {
                $check = DB::connection('tenant')->table('user_shops')->where('user_id',$uid)->where('who','sale person')->get();
                if ($check->isEmpty()) {
                    DB::table('user_roles')->where('user_id',$uid)->where('role_id',7)->delete();
                }
            }
        }
        return true;
    }

    public function add_sperson(Request $request) {
        $user = User::where('id',$request->user_id)->where('company_id',Auth::user()->company_id)->first();
        $shop = Shop::where('id',$request->shop_id)->where('company_id',Auth::user()->company_id)->first();

        if ($this->untouchCashier($request->user_id,$request->shop_id)) {
            if ($user->hasSalePersonRole()) { // then, attach sale person to shop
                $check = DB::connection('tenant')->table('user_shops')->where('user_id',$request->user_id)->where('shop_id',$request->shop_id);
                if ($check->first()) {
                    $check->update(['who'=>'sale person']);
                } else {
                    DB::connection('tenant')->table('user_shops')->insert(['user_id' => $request->user_id, 'shop_id'=>$request->shop_id, 'who'=>'sale person']);
                }
            } else {
                $spersonRole = DB::table('user_roles')->insert(['user_id' => $user->id, 'role_id'=>7]);
                if ($spersonRole) {
                    $check = DB::connection('tenant')->table('user_shops')->where('user_id',$request->user_id)->where('shop_id',$request->shop_id);
                    if ($check->first()) {
                        $check->update(['who'=>'sale person']);
                    } else {
                        DB::connection('tenant')->table('user_shops')->insert(['user_id' => $request->user_id, 'shop_id'=>$request->shop_id, 'who'=>'sale person']);
                    }
                }
            }
            return response()->json(['success'=>'Success! Access granted successfully.','user'=>$request->user_id,'shop'=>$request->shop_id,'shopname'=>$shop->name]);
        }
    }
    public function untouchCashier($uid,$sid) {
        $cashier = DB::connection('tenant')->table('user_shops')->where('user_id',$uid)->where('shop_id',$sid)->where('who','cashier');
        if ($cashier->first()) {
            $delete = $cashier->delete();
            if($delete) {
                $check = DB::connection('tenant')->table('user_shops')->where('user_id',$uid)->where('who','cashier')->get();
                if ($check->isEmpty()) {
                    DB::table('user_roles')->where('user_id',$uid)->where('role_id',6)->delete();
                }
            }
        }
        return true;
    }

    public function add_smaster(Request $request) {
        $user = User::where('id',$request->user_id)->where('company_id',Auth::user()->company_id)->first();
        $store = Store::where('id',$request->store_id)->where('company_id',Auth::user()->company_id)->first();
        if ($user->isStoreMaster()) {
            $check2 = DB::table('user_roles')->where('user_id',$request->user_id)->where('role_id',8)->first();
            if (!$check2) {
                DB::table('user_roles')->insert(['user_id' => $user->id, 'role_id'=>8]);
            }
            $check = DB::connection('tenant')->table('user_stores')->where('user_id',$request->user_id)->where('store_id',$request->store_id)->first();
            if ($check) {
                return response()->json(['error'=>'Sorry! This user is already store master in this store.']);
            } else {
                DB::connection('tenant')->table('user_stores')->insert(['user_id' => $request->user_id, 'store_id'=>$request->store_id, 'who'=>'store master']);
            }
        } else {
            DB::table('user_roles')->insert(['user_id' => $user->id, 'role_id'=>8]);
            DB::connection('tenant')->table('user_stores')->insert(['user_id' => $request->user_id, 'store_id'=>$request->store_id, 'who'=>'store master']);
        }
        return response()->json(['success'=>'Success! Access granted successfully.','user'=>$request->user_id,'store'=>$request->store_id,'storename'=>$store->name]);
    }

    // public function update_pwd(Request $request) {
    //     $user = User::where('id',$request->user)->where('company_id',Auth::user()->company_id)->first();
    //     if ($user) {
    //         $user->update(['password' => Hash::make($request->password)]);
    //     } else {
    //         return response()->json(['error'=>'Error! Something went wrong. Please try again.']);
    //     }
    //     return response()->json(['success'=>'Success! Password updated successfully.']);
    // }
 
    public function users($check) {
        if ($check == 'admin') {
            Session::put('role','Admin');
        } elseif ($check == 'ceo') {
            Session::put('role','CEO');
        } elseif ($check == 'business-owner') {
            Session::put('role','Business Owner');
        }
        $data['roles'] = Role::where('name','!=','Admin')->get();
        $data['users'] = User::where('id','!=',1)->where('company_id',Auth::user()->company_id)->where('status','!=','deleted')->get();
        return view('users',compact('data'));
    }
    public function users2() {
        if (Auth::user()->isCEOorAdminorBusinessOwner()) {
            $data['roles'] = Role::where('name','!=','Admin')->get();
            $data['users'] = User::where('id','!=',1)->where('company_id',Auth::user()->company_id)->where('status','!=','deleted')->get();
            return view('users',compact('data'));
        } else {
            return redirect()->back()->with('error','Sorry! It seems like you dont have permission to view users of this account.');
        }
    }

}
