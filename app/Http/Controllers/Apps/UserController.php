<?php

namespace App\Http\Controllers\Apps;

use App\Company;
use App\Country;
use App\Http\Controllers\Controller;
use App\Role;
use App\Shop;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Maestroerror\HeicToJpg;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;

class UserController extends Controller
{
    public function users($search = null){ 
        if (Auth::user()->isCEOorAdminorBusinessOwner()){
            $data['roles'] = Role::where('name','!=','Admin')->whereIn('name',['business Owner','CEO','Cashier','Sales Person'])->get();
            $data['users'] = User::where('company_id',Auth::user()->company_id)->where('status','!=','deleted')
                                 ->with('roles')
                                 ->when($search, function($query, $search) {
                                    return $query->where('name', 'like', "%{$search}%")
                                    ->orWhere('phone', 'like', "%{$search}%")
                                    ->orWhere('location', 'like', "%{$search}%");
                                })->orderBY('created_at','desc')->get();

            $data['user'] = User::where('id',Auth::user()->id)->with('roles')->first();

            return response()->json([
                'status' => 1,
                'data' => $data
            ]);

        }else{
             return response()->json([
                'status' => 0,
                'message' => 'Sorry! It seems like you dont have permission to view users of this account.'
            ]);
        }
    } 

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'email' => 'nullable|email|unique:users',
            'phone' => 'required|numeric',
            'roles' => 'nullable|array',
            'username' => 'required|unique:users',
            'password' => 'required|min:4',
            'gender' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),400); 
        }

        $user = User::create([
                    'name' => $request->name,
                    'username'=>$request->username,
                    'phone' => $request->phone,
                    'gender' => $request->gender,
                    'company_id'=>Auth::user()->company_id,
                    'email' => $request->email,
                    'status'=> 'active',
                    'created_by'=>Auth::user()->id,
                    'password' => Hash::make($request->password)
                ]);

                if ($user) {
                    if ($request->input('roles')){

                        foreach($request->input('roles') as $role){
                            DB::connection('mysql')->table('user_roles')->insert(['user_id' => $user->id, 'role_id'=>$role]);
                        }

                    }
                }

        return response()->json([
            'success'=> 1,
            'message' =>'Success! User created successfully.',
            "data" => $user
        ]);
    }

    public function update(Request $request){
         $id= $request->get('user_id');
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'email' => ['nullable','email',Rule::unique('users', 'email')->ignore($id),],
            'phone' => 'required|numeric',
            'roles' => 'nullable|array',
            'username' => ['nullable','string',Rule::unique('users', 'username')->ignore($id),],
            'user_id' => 'required',
            'password' => 'nullable|min:4',
            'gender' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }

         $user = User::where('id',$request->user_id)->where('company_id',Auth::user()->company_id)->update([
            'name' => $request->name,
            'username'=>$request->username,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'company_id'=>Auth::user()->company_id,
            'email' => $request->email,
         ]);

         if ($request->input('password') && Auth::user()->username == "admin"){
             User::where('id',$request->user)->update(['password' => Hash::make($request->password)]);
         }

        $roles = $request->input('roles', []);

        DB::connection('mysql')->table('user_roles')->where('user_id', $request->user_id)->delete();

        foreach ($roles as $role) {
            DB::connection('mysql')->table('user_roles')->insert([
                'user_id' => $request->user_id,
                'role_id' => $role,
            ]);
        }


        return response()->json([
            'success'=> 1,
            'message' =>'Success! User updated successfully.',
            "data" => $user
        ]);
    }

    public function status(Request $request){

        $validator = Validator::make($request->all(), [
            'status' => 'required',
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }

        $user = User::where('id',$request->user)->where('company_id',Auth::user()->company_id)->update([
            'status' => $request->status,
        ]);

        return response()->json([
            'success'=> 1,
            'message' =>'Success! User status updated successfully.',
        ]);
    }

    public function delete(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }

        $user = User::where('id',$request->user_id)->where('company_id',Auth::user()->company_id)->update([
            'status' => 'deleted',
        ]);

        return response()->json([
            'success'=> 1,
            'message' =>'Success! User deleted successfully.',
        ]);

    }

    public function user($user_id){
        if (Auth::user()->isCEOorAdminorBusinessOwner()){

            $data['shops'] = Shop::where('company_id',Auth::user()->company_id)->get();
            $data['user'] = User::with('roles')->where('id',$user_id)->where('status','!=','deleted')->where('company_id',Auth::user()->company_id)->first();
            $shopsIds = DB::connection('tenant')->table('user_shops')->where('user_id',$user_id)->where('who','cashier')->pluck('shop_id')->toArray();
            $sales = DB::connection('tenant')->table('user_shops')->where('user_id',$user_id)->where('who','sale person')->pluck('shop_id')->toArray();
            $data['cashier'] = Shop::whereIn('id',$shopsIds)->get();
            $data['salesPerson'] = Shop::whereIn('id',$sales)->get();

            
            // $data['shops'] = Shop::where('company_id',Auth::user()->company_id)->get();
            // $data['user'] = User::with('roles')->where('id',$user_id)->where('status','!=','deleted')->where('company_id',Auth::user()->company_id)->first();
            // $shopsIds = DB::connection('tenant')->table('user_shops')->where('user_id',$user_id)->where('who','cashier')->pluck('shop_id')->toArray();
            // $data['assigned_shop'] = Shop::whereIn('id',$shopsIds)->get();

            return response()->json([
                'success'=> 1,
                'message' =>'user found',
                'data' => $data
            ]);

        } else {
             return response()->json([
                'success'=> 0,
                'message' =>'Only admin or bussines owner can view user.',
            ]);
        }
    }

    public function assignToShop(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'shop_ids' => 'required|array',
            'role_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }

        $role = Role::find($request->input('role_id'));
        if ($role) {

            if ($role->name == 'Cashier') {
                DB::connection('mysql')->table('user_roles')->insert(['user_id' => $request->input('user_id'), 'role_id' => 6]);

                foreach ($request->input('shop_ids') as $key => $value) {
                    DB::connection('tenant')->table('user_shops')->insert(['user_id' => $request->input('user_id'), 'shop_id'=>$value, 'who'=>'cashier']);
                }
            }

            if ($role->name == 'Sales Person') {
                DB::connection('mysql')->table('user_roles')->insert(['user_id' => $request->input('user_id'), 'role_id' => 7]);

                foreach ($request->input('shop_ids') as $key => $value) {
                    DB::connection('tenant')->table('user_shops')->insert(['user_id' => $request->input('user_id'), 'shop_id'=>$value, 'who'=>'sale person']);
                }
            }

            return response()->json([
                'success'=> 1,
                'message' =>'asignment completed',
            ]);


        }else{
              return response()->json([
                'success'=> 0,
                'message' =>'Role not found in our database',
            ]);
        }

    }

    public function updateAssignment(Request $request){
         $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'shop_ids' => 'required|array',
            'role_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }

        $role = Role::find($request->input('role_id'));

        if ($role) {

            if ($role->name == 'Cashier') {

                // delete first

                $cashier = DB::connection('tenant')->table('user_shops')->where('user_id',$request->input('user_id'))->where('who','cashier')->get();
                foreach($cashier as $cash){
                    $cash->delete();
                }

                foreach ($request->input('shop_ids') as $key => $value) {
                    DB::connection('tenant')->table('user_shops')->insert(['user_id' => $request->input('user_id'), 'shop_id'=>$value, 'who'=>'cashier']);
                }
            }

            if ($role->name == 'Sales Person') {


                $sales = DB::connection('tenant')->table('user_shops')->where('user_id',$request->input('user_id'))->where('who','sale person')->get();
                foreach($sales as $sale){
                    $sale->delete();
                }

                foreach ($request->input('shop_ids') as $key => $value) {
                    DB::connection('tenant')->table('user_shops')->insert(['user_id' => $request->input('user_id'), 'shop_id'=>$value, 'who'=>'sale person']);
                }
            }

            return response()->json([
                'success'=> 1,
                'message' =>'asignment completed',
            ]);


        }else{
              return response()->json([
                'success'=> 0,
                'message' =>'Role not found in our database',
            ]);
        }

    }

    public function company_profile() {
        $data['company'] = Company::query()
            ->withCount([
                'shops',
                'stores',
                'customers'
            ])
            ->find(Auth::user()->company_id);
        $data['companyOwners'] = $data['company']->companyOwners();
        $data['companyCEOs']   = $data['company']->companyCEOs();
        $path_part = Auth::user()->company->folder;

        $data['countries'] = Country::all();
        return response()->json([
            'status' => 1,
            'message' => 'success',
            'data' => [
                'data' => $data,
                'path_part' => $path_part
            ]
        ]);
    }

    public function user_profile() {
        $user = User::with('company','roles')->find(Auth::user()->id);
        $path_part = Auth::user()->company->folder;
         return response()->json([
            'status' => 1,
            'message' => 'success',
            'data' => [
                'user' => $user,
                'path_part' => $path_part
            ]
        ]);
    }
    public function update_user_profile(Request $request) {
        if (empty($request->check)) {
            # code...
            return response()->json([
                'status' => 1,
                'message' => 'no action specified',
            ]);
        }
        if ($request->check == "update user details") {
            //      $validator = Validator::make($request->all(), [
            //     'username' => ['nullable','string',Rule::unique('users', 'username')->ignore($id),],
            // ]);

            // if ($validator->fails()) {
            //     return response()->json($validator->errors(),400);
            // }
            $exists = User::where('username', $request->username)
                    ->where('id', '!=', $request->user_id)
                    ->exists();

                if ($exists) {
                    // username is not unique
                    // return back()->withErrors(['username' => 'Username already taken']);
                    return response()->json([
                            'status' => 0,
                            'message' => 'Username already taken'
                        ]);
                }
            $user = User::where('id',$request->user_id)->where('company_id',Auth::user()->company_id)->first();
            if ($user) {
                // check for username
                if ($user->username == trim($request->username)) {
                    // no changes for username
                } else {
                    $checkuser = User::where('username',trim($request->username))->first();
                    if ($checkuser) {
                        // return response()->json(['status'=>'username occupied']);
                        return response()->json([
                            'status' => 1,
                            'message' => 'username occupied',
                            'data' => [
                                'user' => $user
                            ]
                        ]);
                    } else {
                        $user->update(['username'=>$request->username]);
                    }
                }
                $user->update(['name' => trim($request->name), 'phonecode'=>$request->phonecode, 'phone' => trim($request->phone), 'gender' => $request->gender, 'email' => trim($request->email), 'address' => $request->address, 'status' => $request->status]);

                // return response()->json(['status'=>'success']);

                return response()->json([
                    'status' => 1,
                    'message' => 'success',
                    'data' => [
                        'user' => $user
                    ]
                ]);
            } else {
                // return response()->json(['status'=>'error']);
                return response()->json([
                    'status' => 1,
                    'message' => 'error',
                ]);
            }
        }
        if ($request->check == "update user password") {
            if (Auth::user()->username == "admin") {
                $user = User::where('id',$request->user_id)->first();
            } else {
                $user = User::where('id',$request->user_id)->where('company_id',Auth::user()->company_id)->first();
            }
            if ($user) {
                $user->update(['password' => Hash::make($request->password)]);
            } else {
                // return response()->json(['status'=>'error']);
                return response()->json([
                    'status' => 1,
                    'message' => 'error',
                ]);
            }
            // return response()->json(['status'=>'success']);
                return response()->json([
                    'status' => 1,
                    'message' => 'success',
                ]);
        }
        if ($request->check == "update company details") {
            $company = Company::find(Auth::user()->company_id);
            if ($company) {
                $update = $company->update(['name'=>$request->name,'about'=>$request->about,'updated_by'=>Auth::user()->id,'tin'=>$request->tin,'vrn'=>$request->vrn]);
                if ($update) {
                    // return response()->json(['status'=>'success']);
                    return response()->json([
                        'status' => 1,
                        'message' => 'success',
                    ]);
                } else {
                    // return response()->json(['status'=>'error']);
                    return response()->json([
                        'status' => 1,
                        'message' => 'error',
                    ]);
                }
            }
        }

        if ($request->check == "change company picture") {
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time().'_'.$file->getClientOriginalName();
                $file->move(public_path('uploads/companyLogo'), $filename);

                $company = Company::find(Auth::user()->company->id);
                $company->logo = $filename;
                $company->save();

                // return response()->json(['status'=>'success']);
                return response()->json([
                    'status' => 1,
                    'message' => 'success',
                ]);
            }else{
                // return response()->json(['status'=>'failed']);
                return response()->json([
                    'status' => 1,
                    'message' => 'error',
                ]);
            }
        }
        if ($request->check == "change profile picture") {
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
                    // return response()->json(['status'=>'success']);
                    return response()->json([
                        'status' => 1,
                        'message' => 'error',
                    ]);
                } else {
                    // return response()->json(['status'=>'fail to upload']);
                    return response()->json([
                        'status' => 1,
                        'message' => 'fail to upload',
                    ]);
                }

            } else {
                // return response()->json(['status'=>'empty file']);
                return response()->json([
                    'status' => 1,
                    'message' => 'empty file',
                ]);
            }
        }


        // if ($request->check == "update user roles") {
        //     $user = User::where('id',$request->user)->where('company_id',Auth::user()->company_id)->first();
        //     if ($user) {
        //         DB::table('user_roles')->where('user_id',$user->id)->whereIn('role_id',[1,2,3,4,5,9,10])->delete();
        //         if ($request->input('roles')) {
        //             foreach($request->input('roles') as $role){
        //                 if ($role == 1 || $role == 2 || $role == 3 || $role == 4 || $role == 5 || $role == 9 || $role == 10) {
        //                     DB::table('user_roles')->insert(['user_id' => $user->id, 'role_id'=>$role]);
        //                 }
        //             }
        //         }
        //         return response()->json(['status'=>'success']);
        //     }
        // }
        // if ($request->check == "update user status") {
        //     $user = User::where('id',$request->uid)->where('company_id',Auth::user()->company_id)->first();
        //     if ($user) {
        //         if ($request->action == "Activate") { $status = "active"; }
        //         if ($request->action == "Block") { $status = "blocked"; }
        //         if ($request->action == "Delete") { $status = "deleted"; }
        //         $update = $user->update(['status'=>$status]);
        //         if ($update) {
        //             if ($request->action == "Block" || $request->action == "Delete") {

        //             }
        //         }
        //         return response()->json(['status'=>'success','uname'=>$user->username]);
        //     } else {
        //         return response()->json(['status'=>'error']);
        //     }
        // }

        // if ($request->check == "assign-bo-role") {
        //     $bo = DB::table('user_roles')->where('user_id',$request->user)->where('role_id',2)->first();
        //     if($bo) {
        //         return response()->json(['status'=>'success']);
        //     } else {
        //         DB::table('user_roles')->insert(['user_id'=>$request->user,'role_id'=>2]);
        //         return response()->json(['status'=>'success']);
        //     }
        // }
    }
}
