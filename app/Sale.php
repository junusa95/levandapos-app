<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $guarded = ['id'];
    protected $connection = 'tenant';
    
    public function product() {
        return $this->belongsTo('App\Product','product_id');
    }

    public function shop() {
        return $this->belongsTo('App\Shop','shop_id');
    }

    public function customer() {
        return $this->belongsTo('App\Customer','customer_id');
    }

    public function orderedBy() {
        return $this->belongsTo('App\User','ordered_by');
    }

    public function soldBy() {
        return $this->belongsTo('App\User','user_id');
    }

    public function payments() {
        return $this->belongsTo('App\PaymentOption','payment_option_id');
    }
}
