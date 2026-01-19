<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentsDesc extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $connection = 'mysql';
    
    public function payment () {
        return $this->belongsTo('Payment', 'payment_id');
    }
    
    public function shop() {
        return $this->belongsTo('App\Shop','paid_item');
    }
    
    public function store() {
        return $this->belongsTo('App\Store','paid_item');
    }
}
