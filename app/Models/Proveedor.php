<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    public function compra()
    {
        return $this->hasMany('App\Models\Compra');
    }

    protected $fillable = [
        'nombre_proveedor',
        'telefono_proveedor',
        'rtn_proveedor',
        'contacto_proveedor',
        'telefono_contacto_proveedor',
        'direccion_proveedor',
    ];    

}

