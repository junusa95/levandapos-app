<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $guarded = ['id'];
    protected $connection = 'mysql';

    public function user() {
        return $this->belongsTo('App\User','created_by');
    }

}
