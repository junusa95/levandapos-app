<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $guarded = ['id'];    
    protected $connection = 'tenant';

    public function products() {
        return $this->hasMany('App\Product');
    }

    public function categorygroup() {
        return $this->belongsTo('App\ProductCategoryGroup','product_category_group_id');
    }

    public function totalProductsCreated() {
        return \App\Product::where('product_category_id',$this->id)->where('status','!=','deleted')->count();
    }
}
