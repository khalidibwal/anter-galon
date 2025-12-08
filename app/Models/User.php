<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'alamat',   // <-- tambahkan alamat
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // di App\Models\User.php

public function addresses()
{
    return $this->hasMany(UserAddress::class);
}

public function defaultAddress()
{
    return $this->hasOne(UserAddress::class)->latest();
}


public function orders()
{
    return $this->hasMany(Order::class);
}
public function alamatPengiriman()
    {
        // Jika user hanya punya 1 alamat, pakai hasOne
        return $this->hasOne(UserAddress::class)->latest();
    }

    // Jika user bisa punya banyak alamat:
    public function alamat()
    {
        return $this->hasMany(UserAddress::class);
    }


}
