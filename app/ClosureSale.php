<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClosureSale extends Model
{
    protected $guarded = ['id'];
    protected $connection = 'tenant';

    public function shop() {
        return $this->belongsTo('App\Shop','shop_id');
    }

    public function user() {
        return $this->belongsTo('App\User','closed_by');
    }
}
