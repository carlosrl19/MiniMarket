<?php

namespace App\Http\Livewire\Ventas;

use App\Models\DetalleVenta;
use App\Models\Venta;
use Carbon\Carbon;
use Livewire\Component;

class VentaIndex extends Component
{   
    public $filtros = [
        "busqueda" => "",
        "fecha_inicial" => "",
        "fecha_final" => "",
        "estado" => [
            "nombre" => "Todas",
            "valor" => "",
        ],
    ];

    public $sortField = 'fecha_factura';
    public $sortDirection = 'desc';

    public function render()
    {
        return view('livewire.ventas.venta-index', [
                'ventas' => Venta::filter($this->filtros)
                    ->orderBy($this->sortField, $this->sortDirection)
                    ->get()
        ])
        ->extends('layouts.layouts')
        ->section('content');
    }

    // public function mount(){
    //     $this->setFiltroFecha(Carbon::now()->toDateString('Y-m-d'), Carbon::now()->toDateString('Y-m-d'));
    // }

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


    public function eliminarVenta($id){
        $venta = Venta::findOrFail($id);

        if ($venta) {
            DetalleVenta::where('venta_id', $venta->id)->delete();
            $venta->delete();
        }

        return redirect()->route('ventas.index')->with('success','¡Venta eliminada con éxito!');
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
