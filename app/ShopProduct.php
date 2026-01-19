<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopProduct extends Model
{
    use HasFactory;
    protected $connection = 'tenant';

     public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
     // Other shops where this product exists (active only)
    public function otherShops()
    {
        return $this->hasMany(ShopProduct::class, 'product_id', 'product_id')
            ->where('active', 'yes');
    }
} 
