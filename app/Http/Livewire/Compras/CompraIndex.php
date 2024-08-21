<?php

namespace App\Http\Livewire\Compras;

use App\Models\Compra;
use App\Models\DetalleCompra;
use Livewire\Component;

class CompraIndex extends Component
{

    public $sortField = 'fecha_compra';
    public $sortDirection = 'desc';

    public $filtros = [
        "busqueda" => "",
        "fecha_inicial" => "",
        "fecha_final" => "",
        "estado" => [
            "nombre" => "Todas",
            "valor" => "",
        ],
    ];

    public function render()
    {
        return view('livewire.compras.compra-index', [
            'compras' => Compra::filter($this->filtros)
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate(8)
        ])->extends('layouts.layouts')->section('content');
    }


    public function setFiltroEstado($valor, $nombre){
        $this->filtros["estado"]["valor"] = $valor;
        $this->filtros["estado"]["nombre"] = $nombre;
    }

    public function setFiltroFecha($fecha_inicial, $fecha_final){
        $this->filtros["fecha_inicial"] = $fecha_inicial;
        $this->filtros["fecha_final"] = $fecha_final;
    }

    // propiedad computada para generar el nombre del filtro de fecham y mostrarlo al usuario
    public function getNombreFiltroFechaProperty()
    {
        return "{$this->filtros["fecha_inicial"]} / {$this->filtros["fecha_final"]}";
    }


    public function eliminarCompra($id){
        $compra = Compra::findOrFail($id);

        if ($compra) {
            DetalleCompra::where('compra_id', $compra->id)->delete();
            $compra->delete();
        }

        return redirect()->route('compras.index')->with('success','¡Compra eliminada con éxito!');
    }

    public function sortBy($field){
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }
}
