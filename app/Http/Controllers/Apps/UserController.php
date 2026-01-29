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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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

        /**
         * Restricts the assignment of 'Business Owner' Role to 
         * a specific user, only when the logged in user has either 
         * a CEO or Business Owner Roles.
         */
        if(Auth::user() && !Auth::user()->isBusinessOwner()){
            $businessOwnerRoleDetails = Role::businessOwnerRoleDetails();
            if(in_array($businessOwnerRoleDetails->id, $request->input('roles'))){
                return response()->json([
                    'status' => 0,
                    'message' => "Sorry! You are not authorized to assign the 'Business Owner' Role to this user."
                ]);
            }
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

        /**
         * Restricts the assignment of 'Business Owner' Role to 
         * a specific user, only when the logged in user has either 
         * a CEO or Business Owner Roles.
         */
        if(Auth::user() && !Auth::user()->isBusinessOwner()){
            $businessOwnerRoleDetails = Role::businessOwnerRoleDetails();
            if(in_array($businessOwnerRoleDetails->id, $request->input('roles'))){
                return response()->json([
                    'status' => 0,
                    'message' => "Sorry! You are not authorized to assign the 'Business Owner' Role to this user."
                ]);
            }
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
                     return response()->json(['status'=>'error']);
                    return response()->json([
                        'status' => 1,
                        'message' => 'error',
                    ]);
                }
            }
        }

        if ($request->check == "change company picture") {
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                try {
                    $file = $request->file('image');

                    // HEIC → JPG (only if needed)
                    if (HeicToJpg::isHeic($file)) {
                        $file = HeicToJpg::convert($file)->get();
                    }
                    
                    $manager = new ImageManager(new Driver());
                    $binaryData = file_get_contents($file->getRealPath());
                    $image = $manager->read($binaryData)->scaleDown(width: 540)->toJpeg(85); // compress

                    // Company folder
                    $cfolder = Auth::user()->company->folder;
                    $company = Company::whereId(Auth::user()->company_id)->first();
                    if (!$cfolder) {
                        $fname = preg_replace('/[^a-zA-Z0-9]+/', '_', Auth::user()->company->name);
                        $cfolder = Auth::user()->company_id . '_' . $fname;
                        $company->update(['folder' => $cfolder]);
                    }

                    $profile_path = "companies/{$cfolder}/company-profiles";
                    $imageName = time() . '_' . Str::random(6) . '.jpg';

                    // ✅ Upload IMAGE BYTES
                    Storage::disk('s3')->put("{$profile_path}/{$imageName}", $image->toString(), 'public');
                    
                    // Delete the previous (existing) image
                    Storage::disk('s3')->delete("{$profile_path}/$company->logo");

                    // Save the name of the newly uploaded image
                    $company->update(['logo'=>$imageName]);

                    $picture = '';
                    if ($company->logo != null){
                        $base_url = rtrim(config('filesystems.disks.s3.endpoint'), '/') ."/". config('filesystems.disks.s3.public_id') .":". config('filesystems.disks.s3.bucket') ."/";
                        $picture = $base_url . 'companies/'. $company->folder .'/company-profiles/'. $company->logo;
                    }
                    
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Success! Image successfully uploaded.',
                        'company_logo' => $picture
                    ], 200);
                } catch (\Exception $e) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Error! Upload failed: ' . $e->getMessage()
                    ], 500);
                }
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error! Invalid or missing image file.',
                ], 400);
            }
        }
        if ($request->check == "change profile picture") {
            // $this->validate($request, [
            //     'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            // ]);

            if($request->hasFile('image')) {

                try{
                    $file = $request->file('image');

                    if (HeicToJpg::isHeic($file)) { // heic format used by iphone users
                        $file = HeicToJpg::convert($file)->get();
                    }

                    $manager = new ImageManager(new Driver());
                    $image = $manager->read($file)->scaleDown(width: 540)->toJpeg(85); // compress

                    // check for directory availability
                    $cfolder = Auth::user()->company->folder;
                    $user = User::whereId(Auth::user()->id)->first();
                    $company = Company::whereId(Auth::user()->company_id)->first();
                    if (!$cfolder) {
                        $fname = preg_replace('/[^a-zA-Z0-9]+/', '_', Auth::user()->company->name);
                        $cfolder = Auth::user()->company_id . '_' . $fname;
                        $company->update(['folder' => $cfolder]);
                    }

                    $profile_path = "companies/{$cfolder}/profiles";
                    $imageName = time() . '_' . Str::random(6) . '.jpg';

                    // ✅ Upload IMAGE BYTES
                    Storage::disk('s3')->put("{$profile_path}/{$imageName}", $image->toString(), 'public');

                    // Delete the previous (existing) image
                    Storage::disk('s3')->delete("{$profile_path}/". $user->profile);

                    // Save the name of the newly uploaded image
                    $user->update(['profile'=>$imageName]);

                    $picture = '';
                    if ($user->profile != null){
                        $base_url = rtrim(config('filesystems.disks.s3.endpoint'), '/') ."/". config('filesystems.disks.s3.public_id') .":". config('filesystems.disks.s3.bucket') ."/";
                        $picture = $base_url . 'companies/'. $company->folder .'/profiles/'. $user->profile;
                    }

                    return response()->json([
                        'status' => 'success',
                        'message' => 'Success! Image successfully uploaded.',
                        'data' => $picture
                    ], 200);
                } catch (\Exception $e) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Error! Upload failed: ' . $e->getMessage()
                    ], 500);
                }

            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error! Invalid or missing image file.',
                ], 400);
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
