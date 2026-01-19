<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $guarded = ['id'];
    protected $connection = 'tenant';

    public function product() {
        return $this->belongsTo('App\Product','product_id');
    }

    public function fshop() {
        return $this->belongsTo('App\Shop','from_id');
    }

    public function dshop() {
        return $this->belongsTo('App\Shop','destination_id');
    }

    public function fstore() {
        return $this->belongsTo('App\Store','from_id');
    }

    public function dstore() {
        return $this->belongsTo('App\Store','destination_id');
    }

    public function sender() {
        return $this->belongsTo('App\User','sender_id');
    }

    public function shipper() {
        return $this->belongsTo('App\User','shipper_id');
    }

    public function receiver() {
        return $this->belongsTo('App\User','receiver_id');
    }
}
