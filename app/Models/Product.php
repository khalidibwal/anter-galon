<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Nama tabel (optional, Laravel otomatis tahu "products" dari "Product")
    protected $table = 'products';

    // Kolom yang boleh diisi (mass assignable)
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
    ];

    // (Opsional) Format harga otomatis saat ditampilkan
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }
}
