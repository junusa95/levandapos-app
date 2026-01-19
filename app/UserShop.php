<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserShop extends Pivot
{
    protected $table = 'user_shops';
    protected $connection = 'tenant';
}
