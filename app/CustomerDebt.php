<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerDebt extends Model
{
    protected $guarded = ['id'];
    protected $connection = 'tenant';

    public function customer() {
        return $this->belongsTo('App\Customer','customer_id');
    }

    public function shop() {
        return $this->belongsTo('App\Shop','shop_id');
    }

    public function user() {
        return $this->belongsTo('App\User','user_id');
    }
}
