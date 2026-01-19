<?php

namespace App;

use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $guarded = ['id'];
    protected $connection = 'tenant';
    
    public function users() {
        return $this->belongsToMany('App\User','user_shops','shop_id','user_id');
    }
    
    public function suppliers() {
        return $this->hasMany('App\Supplier','shop_id');
    }

    public function cashiers() {
        return $this->users()->where('who','cashier')->get();
    }
    
    public function is_cashier($uid) {
        return DB::connection('tenant')
        ->table('user_shops')
        ->where('shop_id', $this->id)
        ->where('user_id', $uid)
        ->where('who', 'cashier')
        ->first();
    }
    public function is_saleperson($uid) {
        return DB::connection('tenant')
        ->table('user_shops')
        ->where('shop_id', $this->id)
        ->where('user_id', $uid)
        ->where('who', 'sale person')
        ->first();
    }

    public function products() { 
        return $this->belongsToMany('App\Product','shop_products','shop_id','product_id')->where('products.status','published')->where('products.company_id',Auth::user()->company_id)->where('shop_products.active','yes');
    }
    
    public function product_availability($pid) {
        return $this->products()->where('products.id',$pid)->first();
    }

    public function productsOfShop() {
        return $this->products()->get();
    }

    public function company() {
        return $this->belongsTo('App\Company','company_id');
    }
    
    public function payments() {
        return \App\PaymentsDesc::where('paid_for','shop')->where('paid_item',$this->id)->get();
    }
    
    public function checkSaleEmptyStock() { 
        return \DB::table('company_settings')->where('shop_id',$this->id)->where('status','yes')->where('setting_id',3)->first();
    }
    
    public function checkSaleBackDate() { 
        return \DB::table('company_settings')->where('shop_id',$this->id)->where('status','yes')->where('setting_id',4)->first();
    }

    public function country() {
        return $this->belongsTo('App\Country','country_id');
    }

    public function region() {
        return $this->belongsTo('App\Region','region_id');
    }

    public function district() {
        return $this->belongsTo('App\District','district_id');
    }

    public function ward() {
        return $this->belongsTo('App\Ward','ward_id');
    }
    
    public function productsOnShop()
{
        return $this->belongsToMany(\App\Product::class, 'shop_products', 'shop_id', 'product_id')
            ->where('products.status', 'published') // Only published products
            // ->where('products.company_id', Auth::user()->company_id) // Only current user's company
            ->wherePivot('active', 'yes'); // Only active links in pivot
            // ->withPivot('active'); // Optional: include pivot field in result
    }
}
 