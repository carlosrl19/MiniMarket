<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = [
        'codigo',
        'marca',
        'modelo',
        'descripcion',
        'existencia',
        'prec_compra',
        'prec_venta_may',
        'prec_venta_fin',
        'id_categoria',
        'imagen_producto',
    ];

    public function categoria(){
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }

    public function detalle_compre()
    {
        return $this->hasOne('App\Models\DetalleCompra');
    }

    public function detalle_venta()
    {
        return $this->hasOne('App\Models\DetalleVenta');
    }

    public function masDetalles()
    {
        return $this->hasMany('App\Models\DatosAdicionalesProductos');
    }
}
