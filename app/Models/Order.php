<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'order_id', 'gross_amount', 'payment_type', 'payment_code',
        'status','delivery_status', 'alamat', 'detail_alamat', 'latitude', 'longitude', 'waktu_pengantaran'
    ];

    protected $casts = [
    'waktu_pengantaran' => 'datetime',
];


    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Relasi ke user yang memesan
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke kurir (jika ada)
     */
    public function courier()
    {
        return $this->belongsTo(User::class, 'courier_id');
    }

    /**
     * Relasi ke alamat user
     */
    public function address()
    {
        return $this->belongsTo(UserAddress::class);
    }
}
