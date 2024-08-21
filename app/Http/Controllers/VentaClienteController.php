<?php

namespace App\Http\Controllers;

use App\Models\DetalleVenta;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\User;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Dompdf\Dompdf;

class VentaClienteController extends Controller
{
    public function index()
    {
        $ventas = Venta::with('detalle_venta')
            ->select('ventas.id', 'ventas.numero_factura_venta', 'ventas.fecha_factura', 'a.name as usuario', 'b.name as cliente', 'tipo_cliente_factura', 'ventas.estado')
            ->join("users as a", "ventas.user_id", "=", "a.id")
            ->join("users as b", "ventas.cliente_id", "=", "b.id")
            ->where('estado', '=', 'en_proceso')
            ->paginate(8);

        foreach ($ventas as $venta) {
            $total = 0;
            foreach ($venta->detalle_venta as $detalle) {
                $total += $detalle->cantidad_detalle_venta * $detalle->precio_venta;
            }
            $venta->total = $total;  // Asigna el total calculado al objeto de venta
        }

        return view('venta\ventas_index', compact('ventas'));
    }

    public function factura()
    {
        return view('venta.facturas');

    }
    
    // Cierre de caja diario
    public function generarFacturaPorFecha(Request $request)
    {
        $fecha = $request->query('fecha');
        $ventas = Venta::whereDate('fecha_factura', $fecha)->get();
    
        // Generar HTML para el PDF
        $html = view('livewire.ventas.factura_cierre_diario', ['ventas' => $ventas, 'fecha' => $fecha])->render();
    
        // Configurar opciones para Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
    
        // Crear instancia de Dompdf
        $dompdf = new Dompdf($options);
        
        // Cargar HTML en Dompdf
        $dompdf->loadHtml($html);
    
        // (Opcional) Establecer tamaño de papel y orientación
        $dompdf->setPaper('A4', 'portrait');
    
        // Renderizar el PDF
        $dompdf->render();
    
        // Nombre del archivo con la fecha y hora actual
        $nombreArchivo = 'Cierre de caja diario ' . \Carbon\Carbon::now()->format('d-m-Y h:iA') . '.pdf';
    
        // Descargar el PDF automáticamente con el nombre personalizado
        $dompdf->stream($nombreArchivo, ['Attachment' => true]);
    }

    public function generarFacturaMesActual()
    {
        // Obtener el primer día del mes actual
        $primerDiaMes = now()->startOfMonth()->toDateString();
        
        // Obtener el último día del mes actual
        $ultimoDiaMes = now()->endOfMonth()->toDateString();

        // Filtrar las ventas del mes actual
        $ventas = Venta::whereBetween('fecha_factura', [$primerDiaMes, $ultimoDiaMes])->get();

        // Generar HTML para el PDF
        $html = view('livewire.ventas.factura_cierre_mensual', ['ventas' => $ventas, 'fecha' => ''])->render();

        // Configurar opciones para Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);

        // Crear instancia de Dompdf
        $dompdf = new Dompdf($options);
        
        // Cargar HTML en Dompdf
        $dompdf->loadHtml($html);

        // (Opcional) Establecer tamaño de papel y orientación
        $dompdf->setPaper('A4', 'portrait');

        // Renderizar el PDF
        $dompdf->render();

        // Establecer el idioma local a español
        setlocale(LC_TIME, 'es_ES');

        // Nombre del archivo con la fecha y hora actual en español
        $nombreArchivo = 'Ventas del mes ' . strftime('%B %Y') . '.pdf';

        // Descargar el PDF automáticamente con el nombre personalizado
        $dompdf->stream($nombreArchivo, ['Attachment' => true]);
    }

    public function create()
    {
        $productos = Producto::all();
        $users = User::where('type', '=', 'cliente')->get();
        $ventas = DB::select('SELECT numero_factura_venta from ventas where id = (SELECT max(id) FROM ventas)');

        if(count($ventas) == 0){
            $num_factura = '001-001-00-00000001';
        }else{
            $num_factura = '001-001-00-';
            $num_factura_anterioir = substr($ventas[0]->numero_factura_venta,10,8);
            $numero = intval($num_factura_anterioir);
            $numero += 1;

            if($numero < 10){
                $num_factura = $num_factura."0000000".$numero;
            }else if($numero >= 10 && $numero < 99){
                $num_factura = $num_factura."00000".$numero;
            }else if($numero >= 100 && $numero < 999){
                $num_factura = $num_factura."0000".$numero;
            }else if($numero >= 1000 && $numero < 9999){
                $num_factura = $num_factura."0000".$numero;
            }else if($numero >= 10000 && $numero < 99999){
                $num_factura = $num_factura."000".$numero;
            }else if($numero >= 100000 && $numero < 999999){
                $num_factura = $num_factura."00".$numero;
            }else if($numero >= 1000000 && $numero < 9999999){
                $num_factura = $num_factura."0".$numero;
            }else if($numero >= 10000000 && $numero < 99999999){
                $num_factura = $num_factura.$numero;
            }
        }

        return view('venta\ventas_create')->with('productos', $productos)->with('users', $users)->with('num_factura', $num_factura);
    }

    public function store(Request $request)
    {
        $request ->validate([
            'cliente_id'=>  ['required'],
            'tipo_cliente_factura' => ['required'],
            'tuplas' => ['required'],
        ],[
            'cliente_id.required' => '¡Debes seleccionar un cliente antes de realizar la venta!',
            'tipo_cliente_factura.required' => '¡Debes seleccionar el tipo de cliente!',
        ]);

        $venta = new Venta();
        $venta->numero_factura_venta = $request->input('numero_factura');
        $venta->fecha_factura = $request->input('current_date');
        $venta->user_id = $request->input('usuario_id');
        $venta->cliente_id = $request->input('cliente_id');
        $venta->tipo_cliente_factura = $request->input('tipo_cliente_factura');
        $venta->estado = $request->input("pagado") == "true" ? "pagado" : "en_proceso";
        $venta->save();

        for ($i=0; $i < intval($request->input("tuplas")) ; $i++) {
            $array = explode ( ' ', $request->input("detalle-".$i) );
            $detalle_venta = new DetalleVenta();
            $detalle_venta->venta_id = $venta->id;
            $detalle_venta->producto_id = $array[0];
            $detalle_venta->cantidad_detalle_venta = $array[1];
            if ($request->input('tipo_cliente_factura') == 'mayorista') {
                $detalle_venta->precio_venta = Producto::findOrFail($array[0])->prec_venta_may;
            }
            if ($request->input('tipo_cliente_factura') == 'consumidor_final') {
                $detalle_venta->precio_venta = Producto::findOrFail($array[0])->prec_venta_fin;
            }
            $detalle_venta->save();
        }

        return redirect()->route('ventas.index');
    }

    public function show($id)
    {

        $venta = Venta::findOrFail($id);
        return view('venta.ventas_show')->with("venta",$venta);
    }
}
