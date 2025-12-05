<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_items';

    protected $fillable = [
        'order_id', 'product_id', 'product_name', 'qty', 'price', 'subtotal'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relasi ke Product (Many to One)
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
