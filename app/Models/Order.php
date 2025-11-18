<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'courier_id',
        'address',
        'status',
        'order_time',
        'delivery_time',
        'notes',
    ];

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
