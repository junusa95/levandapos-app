<?php

namespace App\Http\Controllers;

use Session;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{

    public function check_get_data($check, $conditions) {
        if($check == "company-settings") {
            $cid = $conditions;
            $settings = \App\CompanySetting::where('company_id',$cid)->get();

            return response()->json(['status'=>'success','settings'=>$settings]); 
        }
        
        if($check == "update-expire-date") {
            $val = $conditions;
            $cs = \App\CompanySetting::where('company_id',Auth::user()->company_id)->where('setting_id',1)->first();
            if($cs) {
                $cs->update(['status'=>$val,'updated_by'=>Auth::user()->id]);
            } else {
                \App\CompanySetting::create(['company_id'=>Auth::user()->company_id,'setting_id'=>1,'status'=>$val,'updated_by'=>Auth::user()->id]);
            }
            return response()->json(['status'=>'success','val'=>$val]);
        }
        
        if($check == "update-import-products") {
            $val = $conditions;
            $cs = \App\CompanySetting::where('company_id',Auth::user()->company_id)->where('setting_id',5)->first();
            if($cs) {
                $cs->update(['status'=>$val,'updated_by'=>Auth::user()->id]);
            } else {
                \App\CompanySetting::create(['company_id'=>Auth::user()->company_id,'setting_id'=>5,'status'=>$val,'updated_by'=>Auth::user()->id]);
            }
            return response()->json(['status'=>'success','val'=>$val]);
        }
        
        if($check == "update-sale-empty-stock") {
            $sid_val = explode("~",$conditions);
            $sid = $sid_val[0];
            $val = $sid_val[1];
            $ssetting = \App\CompanySetting::where('setting_id',3)->where('shop_id',$sid)->where('company_id',Auth::user()->company_id)->first();
            if($ssetting) {
                $ssetting->update(['status'=>$val,'updated_by'=>Auth::user()->id]);
            } else {
                \App\CompanySetting::create(['company_id'=>Auth::user()->company_id,'shop_id'=>$sid,'setting_id'=>3,'status'=>$val,'updated_by'=>Auth::user()->id]);
            }
            return response()->json(['status'=>'success','val'=>$val]);
        }
        
        if($check == "change-sale-previous-date") {
            $sid_val = explode("~",$conditions);
            $sid = $sid_val[0];
            $val = $sid_val[1];
            $ssetting = \App\CompanySetting::where('setting_id',4)->where('shop_id',$sid)->where('company_id',Auth::user()->company_id)->first();
            if($ssetting) {
                $ssetting->update(['status'=>$val,'updated_by'=>Auth::user()->id]);
                $days = $ssetting->sale_days_back;
            } else {
                \App\CompanySetting::create(['company_id'=>Auth::user()->company_id,'shop_id'=>$sid,'setting_id'=>4,'status'=>$val,'sale_days_back'=>30,'updated_by'=>Auth::user()->id]);
                $days = 30;
            }
            return response()->json(['status'=>'success','val'=>$val,'days'=>$days]);
        }

        if($check == "update-minimum-stock-level") {
            $val = $conditions;
            $cs = \App\CompanySetting::where('company_id',Auth::user()->company_id)->where('setting_id',2)->first();
            if($cs) {
                $min_stock_level = $cs->min_stock_level;
                if($cs->min_stock_level) { } else {
                    $min_stock_level = 0;
                }
                if($val == "yes") {
                    Session::put('min-stock-level','yes');
                    $cs->update(['status'=>$val,'min_stock_level'=>$min_stock_level,'updated_by'=>Auth::user()->id]);
                    \App\Product::where('company_id',Auth::user()->company_id)->where('min_stock_level',null)->update(['min_stock_level'=>$min_stock_level]);
                } else {
                    Session::forget('min-stock-level');
                    $cs->update(['status'=>$val,'updated_by'=>Auth::user()->id]);
                }
            } else {
                $min_stock_level = 20;
                \App\CompanySetting::create(['company_id'=>Auth::user()->company_id,'setting_id'=>2,'status'=>$val,'min_stock_level'=>20,'updated_by'=>Auth::user()->id]);
                if($val == "yes") {
                    \App\Product::where('company_id',Auth::user()->company_id)->update(['min_stock_level'=>20]);
                }                
            }
            return response()->json(['status'=>'success','val'=>$val,'min_stock_level'=>number_format($min_stock_level)]);
        }
        
        if($check == "change-sale-back-days") {
            $sid_val = explode("~",$conditions);
            $sid = $sid_val[0];
            $val = $sid_val[1];
            $cs = \App\CompanySetting::where('company_id',Auth::user()->company_id)->where('shop_id',$sid)->where('setting_id',4)->first();
            if($cs) {
                $cs->update(['sale_days_back'=>$val,'updated_by'=>Auth::user()->id]);
                return response()->json(['status'=>'success']);
            } 
            
        }

        if($check == "change-minimum-stock-level") {
            $val = $conditions; // $val = min stock level
            if($val < 0) { // ignore negative value
                return response()->json(['status'=>'negative not required']);
            }

            $cs = \App\CompanySetting::where('company_id',Auth::user()->company_id)->where('setting_id',2)->first();
            if($cs) {
                if($val == $cs->min_stock_level) {
                    
                } else {
                    \App\Product::where('company_id',Auth::user()->company_id)->where('min_stock_level',$cs->min_stock_level)->update(['min_stock_level'=>$val]);  
                    $cs->update(['min_stock_level'=>$val]);                  
                }
                return response()->json(['status'=>'success']);
            }
        }
    }
}
