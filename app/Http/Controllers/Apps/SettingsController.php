<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Shop;
use App\Company;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SettingsController extends Controller
{
    /**
     * Get all settings associated with the authenticated user's company
     * 
     * @param Illuminate\Http\Request $request
     * 
     * @return Illuminate\Contracts\Routing\ResponseFactory a response object containing all company settings in key to value pair
     */
    public function all_company_settings(Request $request)
    {
        $company = \App\Company::find(Auth::user()->company_id);

        $settings["cashier_stock_approval"] = $company->cashier_stock_approval;
        $settings["can_transfer_items"] = $company->can_transfer_items;
        $settings["has_product_categories"] = $company->has_product_categories;
        
        $other_activated_settings = $company->settings->pluck("id")->toArray();
        $settings["allow_expiry_dates"] = in_array(1, $other_activated_settings) ? "yes" : "no";
        $settings["allow_minimum_stock_level"] = in_array(2, $other_activated_settings) ? "yes" : "no";
        if(in_array(2, $other_activated_settings)){
            $company_settings = \App\CompanySetting::where('company_id',Auth::user()->company_id)->where('setting_id',2)->first();
            if($company_settings) $settings["default_minimum_stock_level"] = $company_settings->min_stock_level;
        } 
        $settings["allow_import_products"] = in_array(5, $other_activated_settings) ? "yes" : "no";

        return response()->json(['status'=>'success','settings'=>$settings]); 
    }

    /**
     * Update a particular company settings' option from general settings.
     * 
     * @param Illuminate\Http\Request $request
     * 
     * @return Illuminate\Contracts\Routing\ResponseFactory a response object containing the updated settings option and its value
     */
    public function update_general_settings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'option' => ['required','string', Rule::in([
                "change-customer-on-sales-status",
                "update-cashier-stock-approval",
                "update-transfer-products-status",
                "update-product-categories-status",
                "update-expire-date",
                "update-import-products",
                "update-minimum-stock-level",
                "change-minimum-stock-level"
            ])],
            'value' => ['required', Rule::when($request->option === 'change-minimum-stock-level', ['integer'], ['string'])],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }

        $option = $request->input('option');
        $value = $request->input('value');

        if($option == "change-customer-on-sales-status") {
            $data['company'] = Company::find(Auth::user()->company_id);
            if($data['company'] && in_array($value,["yes","no"])) {
                $data['company']->update(['customer_on_sales'=>$value]);
                return response()->json(['status'=>'success','value'=>$value]);
            }
        }

        if($option == "update-cashier-stock-approval") {
            $data['company'] = Company::find(Auth::user()->company_id);
            if($data['company'] && in_array($value,["yes","no"])) {
                $data['company']->update(['cashier_stock_approval'=>$value]);
                return response()->json(['status'=>'success','value'=>$value]);
            }
        }

        if($option == "update-transfer-products-status") {
            $data['company'] = Company::find(Auth::user()->company_id);
            if($data['company'] && in_array($value,["yes","no"])) {
                $data['company']->update(['can_transfer_items'=>$value]);
                return response()->json(['status'=>'success','value'=>$value]);
            }
        }

        if($option == "update-product-categories-status") {
            $data['company'] = Company::find(Auth::user()->company_id);
            if($data['company']&& in_array($value,["yes","no"])) {
                $data['company']->update(['has_product_categories'=>$value]);
                return response()->json(['status'=>'success','value'=>$value]);
            }
        }

        if($option == "update-expire-date") {
            if(in_array($value, ["yes","no"])) {
                $companySettings = \App\CompanySetting::where('company_id',Auth::user()->company_id)->where('setting_id',1)->first();
                if($companySettings) {
                    $companySettings->update(['status'=>$value,'updated_by'=>Auth::user()->id]);
                } else {
                    \App\CompanySetting::create(['company_id'=>Auth::user()->company_id,'setting_id'=>1,'status'=>$value,'updated_by'=>Auth::user()->id]);
                }
                return response()->json(['status'=>'success','value'=>$value]);
            }
        }
        
        if($option == "update-import-products") {
            if(in_array($value, ["yes","no"])) {
                $companySettings = \App\CompanySetting::where('company_id',Auth::user()->company_id)->where('setting_id',5)->first();
                if($companySettings) {
                    $companySettings->update(['status'=>$value,'updated_by'=>Auth::user()->id]);
                } else {
                    \App\CompanySetting::create(['company_id'=>Auth::user()->company_id,'setting_id'=>5,'status'=>$value,'updated_by'=>Auth::user()->id]);
                }
                return response()->json(['status'=>'success','value'=>$value]);
            }
        }

        if($option == "update-minimum-stock-level") {
            if(in_array($value, ["yes","no"])) {
                $companySettings = \App\CompanySetting::where('company_id',Auth::user()->company_id)->where('setting_id',2)->first();
                if($companySettings) {
                    $min_stock_level = $companySettings->min_stock_level;
                    if($companySettings->min_stock_level) { } else {
                        $min_stock_level = 0;
                    }
                    if($value == "yes") {
                        Session::put('min-stock-level','yes');
                        $companySettings->update(['status'=>$value,'min_stock_level'=>$min_stock_level,'updated_by'=>Auth::user()->id]);
                        \App\Product::where('company_id',Auth::user()->company_id)->where('min_stock_level',null)->update(['min_stock_level'=>$min_stock_level]);
                    } else {
                        Session::forget('min-stock-level');
                        $companySettings->update(['status'=>$value,'updated_by'=>Auth::user()->id]);
                    }
                } else {
                    $min_stock_level = 20;
                    \App\CompanySetting::create(['company_id'=>Auth::user()->company_id,'setting_id'=>2,'status'=>$value,'min_stock_level'=>20,'updated_by'=>Auth::user()->id]);
                    if($value == "yes") {
                        \App\Product::where('company_id',Auth::user()->company_id)->update(['min_stock_level'=>20]);
                    }                
                }
                return response()->json(['status'=>'success','value'=>$value,'min_stock_level'=>number_format($min_stock_level)]);
            }
        }

        if($option == "change-minimum-stock-level") {
            if($value < 0) { // ignore negative value
                return response()->json(['status'=>'negative not required']);
            }

            $companySettings = \App\CompanySetting::where('company_id',Auth::user()->company_id)->where('setting_id',2)->first();
            if($companySettings) {
                if($value == $companySettings->min_stock_level) {
                    
                } else {
                    \App\Product::where('company_id',Auth::user()->company_id)->where('min_stock_level',$companySettings->min_stock_level)->update(['min_stock_level'=>$value]);  
                    $companySettings->update(['min_stock_level'=>$value]);                  
                }
                return response()->json(['status'=>'success']);
            }
        }
    }

    /**
     * Get all shop settings associated with the authenticated user's company
     * 
     * @param Illuminate\Http\Request $request
     * @param integer $shop_id - A unique ID of a shop
     * 
     * @return Illuminate\Contracts\Routing\ResponseFactory a response object containing all company settings for a specific shop in key to value pair
     */
    public function all_shop_settings(Request $request, $shop_id)
    {
        $shop = Shop::find($shop_id);
        if($shop) {
            $settings["change_selling_price"] = $shop->change_s_price;
            $settings["receipt_and_order"] = $shop->sell_order;

            $shopSettings = \App\CompanySetting::where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->get();
            foreach($shopSettings as $shopSetting){
                if($shopSetting->setting_id == 4){
                    $settings["record_prev_day_sales"] = ($shopSetting->status) ? $shopSetting->status : "no";
                    if($shopSetting->sale_days_back) $settings["sale_days_back"] = $shopSetting->sale_days_back;
                }            
                if($shopSetting->setting_id == 3){
                    $settings["sale_empty_stock"] = ($shopSetting->status) ? $shopSetting->status : "no";
                }
            }

            return response()->json(['shop'=>$shop,'settings'=>$settings]);
        }else{
            return response()->json([
                'status' => 'error', 
                'message' => 'Sorry!. Cannot find shop details associated with the provided ID.'
            ]);
        }
    }

    /**
     * Update a particular company settings' option from shop specific settings
     * 
     * @param Illuminate\Http\Request $request
     * @param integer $shop_id - A unique ID of a shop
     * 
     * @return Illuminate\Contracts\Routing\ResponseFactory a response object containing the updated settings option and its value
     */
    public function update_shop_specific_settings(Request $request, $shop_id)
    {        
        $validator = Validator::make($request->all(), [
            'option' => ['required','string', Rule::in([
                "update-cashier-change-price",
                "update-sale-previous-date",
                "change-sale-back-days",
                "update-print-receipt-save-orders",
                "update-sale-empty-stock",
            ])],
            'value' => ['required', Rule::when($request->option === 'change-sale-back-days', ['integer'], ['string'])],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }

        $option = $request->input('option');
        $value = $request->input('value');

        $shop = Shop::find($shop_id);
        if($shop){
            if($option == "update-cashier-change-price") {
                if(in_array($value, ["yes","no"])) {
                    $shop->update(['change_s_price'=>$value]);
                    return response()->json(['status'=>'success','value'=>$value]);
                }
            }
            
            if($option == "update-sale-previous-date") {
                if(in_array($value, ["yes","no"])) {
                    $shopSettings = \App\CompanySetting::where('setting_id',4)->where('shop_id',$shop_id)->where('company_id',Auth::user()->company_id)->first();
                    if($shopSettings) {
                        $shopSettings->update(['status'=>$value,'updated_by'=>Auth::user()->id]);
                        $days = $shopSettings->sale_days_back;
                    } else {
                        $days = 30;
                        \App\CompanySetting::create(['company_id'=>Auth::user()->company_id,'shop_id'=>$shop_id,'setting_id'=>4,'status'=>$value,'sale_days_back'=>$days,'updated_by'=>Auth::user()->id]);
                    }
                    return response()->json(['status'=>'success','value'=>$value,'days'=>$days]);
                }
            }
            
            if($option == "change-sale-back-days") {
                $shopSettings = \App\CompanySetting::where('company_id',Auth::user()->company_id)->where('shop_id',$shop_id)->where('setting_id',4)->first();
                if($shopSettings) {
                    $shopSettings->update(['sale_days_back'=>$value,'updated_by'=>Auth::user()->id]);
                    return response()->json(['status'=>'success']);
                } 
                
            }

            if($option == "update-print-receipt-save-orders") {
                if(in_array($value, ["yes","no"])) {
                    $shop->update(['sell_order'=>$value]);
                    return response()->json(['status'=>'success','value'=>$value]);
                }
            }

            if($option == "update-sale-empty-stock") {
                $shopSettings = \App\CompanySetting::where('setting_id',3)->where('shop_id',$shop_id)->where('company_id',Auth::user()->company_id)->first();
                if($shopSettings) {
                    $shopSettings->update(['status'=>$value,'updated_by'=>Auth::user()->id]);
                } else {
                    \App\CompanySetting::create(['company_id'=>Auth::user()->company_id,'shop_id'=>$shop_id,'setting_id'=>3,'status'=>$value,'updated_by'=>Auth::user()->id]);
                }
                return response()->json(['status'=>'success','value'=>$value]);
            }
        }else{
            return response()->json([
                'status' => 'error', 
                'message' => 'Sorry!. Cannot find shop details associated with the provided ID.'
            ]);
        }
    }
}