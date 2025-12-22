<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDepot extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'depot_id',
    ];

    // Relasi ke tabel User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke tabel UserAddress (Depot)
    public function depot()
    {
        return $this->belongsTo(UserAddress::class, 'depot_id');
    }
}
