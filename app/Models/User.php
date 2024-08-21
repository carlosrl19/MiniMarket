<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'customer',
        'address',
        'telephone',
        'image'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function cliente()
    {
        return $this->hasOne(Cliente::class);
    }

    public function compra()
    {
        return $this->hasMany('App\Models\Compra');
    }

    public function venta()
    {
        return $this->hasMany('App\Models\Venta');
    }

    public function reparacion()
    {
        return $this->hasMany('App\Models\Reparacion');
    }
}
