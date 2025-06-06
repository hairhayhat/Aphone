<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

        protected $fillable = [
            'order_id',
            'product_id',
            'variant_id',
            'product_name',
            'color',
            'storage',
            'price',
            'quantity',
            'total',
        ];

    // Mối quan hệ với Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Mối quan hệ với Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Mối quan hệ với Variant
    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }
}
