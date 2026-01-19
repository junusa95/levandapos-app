<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delete extends Model
{
    protected $guarded = ['id'];
    protected $connection = 'tenant';
}
