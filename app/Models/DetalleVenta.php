<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'venta_id',
        'producto_id',
        'cantidad_detalle_venta',
        'precio_venta',
        'created_at',
        'updated_at'
    ];

    public function venta()
    {
        return $this->belongsTo('App\Models\Venta');
    }

    public function producto()
    {
        return $this->belongsTo('App\Models\Producto');
    }
}
