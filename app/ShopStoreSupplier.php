<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopStoreSupplier extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $connection = 'tenant';
    
    public function product() {
        return $this->belongsTo('App\Product','product_id');
    }

    public function shop() {
        return $this->belongsTo('App\Shop','shop_id');
    }

    public function store() {
        return $this->belongsTo('App\Store','store_id');
    }

    public function user() {
        return $this->belongsTo('App\User','user_id');
    }
}
