<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Measurement extends Model
{
    protected $guarded = ['id'];
    
    protected $connection = 'tenant';
}
