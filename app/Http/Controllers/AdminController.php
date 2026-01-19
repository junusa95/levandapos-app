<?php

namespace App\Http\Controllers;

use App\User;
use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function get_data($check) {
        $data = array();
        if(Auth::user()->isAdmin()) {
            if($check == "accounts") {
                
                return view('admin.accounts', compact('data'));
            }
            if($check == "agents") {
                
                return view('admin.agents', compact('data'));
            }
        } else {
            return redirect()->back()->with('error','Sorry! It seems like you dont have permission in this page.');
        }       

    }

    public function get_data2($check,$check2) {
        if ($check == "accounts") {
            $data['account'] = Company::find($check2);
            if ($data['account']) {
                return view('admin.account', compact('data'));
            }
        }
        if ($check == "agents") {
            $data['agent'] = User::find($check2);
            if ($data['agent']) {
                return view('admin.agent', compact('data'));
            }
        }
    }
}
