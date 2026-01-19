<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Shop;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Services\TenantService;

class AuthenticationController extends Controller
{
    public function logIn(Request $request){
        $credentials = $request->only('username', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

            $user = Auth::user();

           if ( Auth::user()->isActive()) {

                $token = $user->createToken('auth_token')->plainTextToken;

                $company = \App\Company::find($user->company_id);

                TenantService::connect($company->dbname);

                $shops = Shop::select(['id', 'name', 'user_id', 'status'])->where('user_id', $user->id)->get();

                return response()->json([
                    'status' =>  1,
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'user' => $user,
                    'shops' => $shops
                ]);

            }else{
                  return response()->json([
                    'status' =>  0,
                    'message' => 'your account is not active, contact your administration for more help'
                ]);
            }

    }

    public function profile(){
        $user = Auth::user();
         return response()->json([
            'status' =>  1,
            'user' => $user
        ]);
    }

    public function logOut(Request $request){
        $this->guard()->logout();
        Auth::logout();

        return response()->json([
            'status' =>  1,
            'message' => 'loged out',
        ]);
    }
}
