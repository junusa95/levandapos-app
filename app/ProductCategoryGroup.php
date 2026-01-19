<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCategoryGroup extends Model
{
    protected $guarded = ['id'];    
    protected $connection = 'tenant';

     public function productcategories_all() {
        return $this->hasMany('\App\ProductCategory');
    }

     public function productcategories() {
        return $this->productcategories_all()->where('status',null);
    }
}
