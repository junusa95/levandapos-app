<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReturnSoldItem extends Model
{
    protected $guarded = ['id'];
    protected $connection = 'tenant';
    
    public function product() {
        return $this->belongsTo('App\Product','product_id');
    }
}
