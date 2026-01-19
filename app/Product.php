<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = ['id'];
    protected $connection = 'tenant';

    public function productcategory_all() {
        return $this->belongsTo('App\ProductCategory','product_category_id');
    }

    public function productcategory() {
        return $this->productcategory_all()->where('status',null);
    }
    
    public function stores() {
        return $this->belongsToMany('App\Store','store_products','store_id','product_id')->where('store_products.active','yes');
    }

    public function storeProductRelation($sid) {
        return \DB::connection('tenant')->table('store_products')->where('store_id',$sid)->where('product_id',$this->id)->where('store_products.active','yes')->first();
    }

    public function shopProductRelation($sid) {
        return \DB::connection('tenant')->table('shop_products')->where('shop_id',$sid)->where('product_id',$this->id)->where('shop_products.active','yes')->first();
    }
}
