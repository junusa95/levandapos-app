<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DailySale extends Model
{
    protected $guarded = ['id'];
    protected $connection = 'tenant';

}
