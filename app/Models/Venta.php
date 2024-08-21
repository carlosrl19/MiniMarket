<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    public function cliente()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function detalle_venta()
    {
        return $this->hasMany('App\Models\DetalleVenta');
    }

    // Filtro de busqueda
    public function scopeFilter($query, $filtros)
    {
        return $query->where(function ($query) use ($filtros) {
            if ($filtros['fecha_inicial'] && $filtros['fecha_final']) {
                $query->whereBetween('fecha_factura', [$filtros["fecha_inicial"], $filtros["fecha_final"]]);
            }

            $query->where("numero_factura_venta", 'like', "%{$filtros['busqueda']}%")
            ->orWhereHas('user', function ($q) use ($filtros) {
                $q->where('name', 'like', "%{$filtros['busqueda']}%");
            })
            ->orWhereHas('cliente', function ($q) use ($filtros) {
                $q->where('name', 'like', "%{$filtros['busqueda']}%");
            })
            ->orWhere("fecha_factura", 'like', "%{$filtros['busqueda']}%")
            
                    ->where('estado', 'like', "%{$filtros["estado"]["valor"]}%");
        });
    }
}
