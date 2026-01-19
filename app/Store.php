<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $guarded = ['id'];
    protected $connection = 'tenant';

    public function users() {
        return $this->belongsToMany('App\User','user_stores','store_id','user_id');
    }

    public function smasters() {
        return $this->users()->where('who','store master')->get();
    }

    public function is_storemaster($uid) {
        return $this->users()->where('who','store master')->where('user_id',$uid)->first();
    }

    public function products() {
        return $this->belongsToMany('App\Product','store_products','store_id','product_id')->where('products.status','published')->where('products.company_id',Auth::user()->company_id)->where('store_products.active','yes');
    }

    public function productsOfStore() {
        return $this->products()->get();
    }
    
    public function company() {
        return $this->belongsTo('App\Company','company_id');
    }
    
    public function payments() {
        return \App\PaymentsDesc::where('paid_for','store')->where('paid_item',$this->id)->get();
    }
}
 