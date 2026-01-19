<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $guarded = ['id'];
    protected $connection = 'tenant';
    
    public function debt() {
        return $this->hasMany('App\CustomerDebt','customer_id');
    }

    public function shop() {
        return $this->belongsTo('App\Shop','shop_id');
    }
}
