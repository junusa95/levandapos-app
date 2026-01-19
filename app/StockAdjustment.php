<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockAdjustment extends Model
{
    protected $guarded = ['id'];
    protected $connection = 'tenant';

    public function product() {
        return $this->belongsTo('App\Product','product_id');
    }

    public function user() {
        return $this->belongsTo('App\User','user_id');
    }

    public function shop() {
        return $this->belongsTo('App\Shop','from_id');
    }

    public function store() {
        return $this->belongsTo('App\Store','from_id');
    }
}
