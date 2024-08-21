<?php

namespace App\Http\Livewire\Ventas;

use App\Models\Venta;
use Dompdf\Dompdf;
use Livewire\Component;
use Dompdf\Options;


class VentasShow extends Component
{
    public $venta = [];

    public function mount(Venta $venta)
    {
        $this->venta = $venta;
    }
    public function render()
    {
        return view('livewire.ventas.ventas-show')->extends('layouts.layouts')
        ->section('content');
    }

    public function pdf()
    {
        $variable = [];
        $vistas = '';
        for ($i=0; $i < $this->venta->detalle_venta->count(); $i++) {
            array_push($variable, $this->venta->detalle_venta[$i] );

            if(($i+1) % 6 == 0){
                $vistas .= view('venta.ventas_pdf')->with('venta',$this->venta)->with('detalles',$variable);
                unset($variable);
                $variable = [];
            }

        }

        if (count($variable) > 0) {
            $vistas .= view('venta.ventas_pdf')->with('venta',$this->venta)->with('detalles',$variable);
        }


        //return $vista;

        // Reconocemos los archivos CSS externos
        $options = new Options();
        $options->set('isRemoteEnabled', TRUE);

        $dompdf = new Dompdf($options);
            // Definimos el tamaño y orientación del papel que queremos.
            $dompdf->setPaper('A4', 'portrait');
            // Cargamos el contenido HTML.
            $dompdf->loadHtml($vistas, 'UTF-8');
            // Renderizamos el documento PDF.
            $dompdf->render();
            // Enviamos el fichero PDF al navegador.
            $dompdf->stream("Factura-".$this->venta->numero_factura_venta.".pdf");
    }
}
