<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewStock extends Model
{
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

    public function sender() {
        return $this->belongsTo('App\User','user_id');
    }

    public function receiver() {
        return $this->belongsTo('App\User','received_by');
    }
}
