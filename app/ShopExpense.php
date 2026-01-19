<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShopExpense extends Model
{
    protected $guarded = ['id'];
    protected $connection = 'tenant';

    public function shop() {
        return $this->belongsTo('App\Shop','shop_id');
    }

    public function expense() {
        return $this->belongsTo('App\Expense','expense_id');
    }
}
