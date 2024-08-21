<?php

namespace App\Http\Livewire\Compras;

use App\Models\Compra;
use Dompdf\Dompdf;
use Dompdf\Options;
use Livewire\Component;

class ComprasShow extends Component
{

    public $compra = [];

    public function mount(Compra $compra)
    {
        $this->compra = $compra;
    }
    public function render()
    {
        return view('compra.compras_show')->extends('layouts.layouts')
        ->section('content');
    }


    public function pdf()
    {
        $variable = [];
        $vistas = '';
        for ($i=0; $i < $this->compra->detalle_compra->count(); $i++) {
            array_push($variable, $this->compra->detalle_compra[$i] );

            if(($i+1) % 6 == 0){
                $vistas .= view('compra.compras_pdf')->with('compra',$this->compra)->with('detalles',$variable);
                unset($variable);
                $variable = [];
            }

        }

        if (count($variable) > 0) {
            $vistas .= view('compra.compras_pdf')->with('compra',$this->compra)->with('detalles',$variable);
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
            $dompdf->stream("Factura-".$this->compra->docummento_compra.".pdf");
    }


}
