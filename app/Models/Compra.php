<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    public function proveedor()
    {
        return $this->belongsTo('App\Models\Proveedor');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function detalle_compra()
    {
        return $this->hasMany('App\Models\DetalleCompra');
    }

    // Filtro de busqueda
    public function scopeFilter($query, $filtros)
    {
        return $query->where(function ($query) use ($filtros) {
            if ($filtros['fecha_inicial'] && $filtros['fecha_final']) {
                $query->whereBetween('fecha_compra', [$filtros["fecha_inicial"], $filtros["fecha_final"]]);
            }

            $query->where("docummento_compra", 'like', "%{$filtros['busqueda']}%")
                ->where('estado_compra', 'like', "%{$filtros["estado"]["valor"]}%");
        });
    }

}
