<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeeklySale extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $connection = 'tenant';
}
