<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierDeposit extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $connection = 'tenant';
    
    public function user() {
        return $this->belongsTo('App\User','user_id');
    }
}
