<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\Producto;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Dompdf\Options;
use Dompdf\Dompdf;

class CompraClienteController extends Controller
{
    public function index()
    {
        $compras = Compra::get();
        $com = Compra::where('estado_compra', '=', 'p')
            ->where('user_id', '=', Auth::user()->id)
            ->get();
    
        return view('compra.compras_index', compact('compras', 'com'));
    }

    public function create()
    {
        $provedores = Proveedor::all();
        $productos = Producto::join('categorias', 'categorias.id', '=', 'productos.id_categoria')
            ->select('productos.id','productos.codigo', 'productos.marca','productos.modelo', 'productos.existencia',
                'productos.prec_venta_may', 'productos.imagen_producto', 'productos.prec_venta_fin','productos.prec_compra','productos.id_categoria',
                'categorias.name')
            ->get();

        // Obtener la compra existente o crear una nueva
        $compra = Compra::where('estado_compra', '=', 'p')
            ->where('user_id', '=', Auth::user()->id)
            ->first(); // Cambiado a first() para obtener un solo registro o null

        if (!$compra) {
            // Si no hay compra, crea una nueva
            $compra = new Compra();
            $compra->docummento_compra = '';
            $compra->fecha_compra = Carbon::now();
            $compra->proveedor_id = 1; // Asegúrate de que este ID sea válido
            $compra->user_id = Auth::user()->id;
            $compra->estado_compra = 'p';
            $compra->save();
        }
        
        // Pasar la compra (ya sea nueva o existente) a la vista
        return view('compra.compras_create')->with('compra', $compra)
            ->with('provedores', $provedores)
            ->with('productos', $productos);
    }

    // Cierre de caja diario
    public function generarFacturaPorFecha(Request $request)
    {
        $fecha = $request->query('fecha');
        $compras = Compra::whereDate('fecha_compra', $fecha)->get();
    
        // Generar HTML para el PDF
        $html = view('compra.factura_cierre_diario', ['compras' => $compras, 'fecha' => $fecha])->render();
    
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
        $nombreArchivo = 'Compras - cierre de caja diario ' . $fecha . '.pdf';
    
        // Descargar el PDF automáticamente con el nombre personalizado
        $dompdf->stream($nombreArchivo, ['Attachment' => true]);
    }

    public function generarFacturaMesActual(Request $request)
    {
        // Obtener el mes seleccionado
        $mesSeleccionado = $request->input('fechaCierreMensual');
        
        // Obtener el primer día del mes seleccionado
        $primerDiaMes = now()->month($mesSeleccionado)->startOfMonth()->toDateString();
        
        // Obtener el último día del mes seleccionado
        $ultimoDiaMes = now()->month($mesSeleccionado)->endOfMonth()->toDateString();
    
        // Filtrar las ventas del mes seleccionado
        $compras = Compra::whereBetween('fecha_compra', [$primerDiaMes, $ultimoDiaMes])->get();
    
        // Generar HTML para el PDF y pasar el mes seleccionado
        $html = view('compra.factura_cierre_mensual', [
            'compras' => $compras,
            'fecha' => '',
            'mesSeleccionado' => $mesSeleccionado
        ])->render();
    
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
    
        // Array de nombres de meses en español
        $meses = array(
            "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
            "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
        );
    
        // Obtener el nombre del mes en español
        $nombreMes = $meses[$mesSeleccionado - 1];
    
        // Nombre del archivo con el mes en español
        $nombreArchivo = 'Compras del mes ' . $nombreMes . ' ' . date('Y', strtotime($primerDiaMes)) . '.pdf';
    
        // Descargar el PDF automáticamente con el nombre personalizado
        $dompdf->stream($nombreArchivo, ['Attachment' => true]);
    }
    
    // Agregar items a la compra (indirectamente guarda el estado de la lista porque la actualiza)
    public function store(Request $request)
    {
        // Update the supplier if provided
        if ($request->input('id_prove') != '') {
            $compra = Compra::findOrFail($request->input('compra_id'));
            $compra->proveedor_id = $request->input('id_prove');
            $compra->save();
        }
    
        // Check if the product already exists in the purchase details
        $detalle = DetalleCompra::where('compra_id', $request->input('compra_id'))
            ->where('producto_id', $request->input('producto_id'))
            ->first();
    
        if ($detalle) {
            // If it exists, update the quantity
            $detalle->cantidad_detalle_compra = $request->input('cantidad_detalle_compra');
            $detalle->save();
        } else {
            // If it doesn't exist, create a new entry
            $detalles = new DetalleCompra();
            $detalles->compra_id = $request->input('compra_id');
            $detalles->producto_id = $request->input('producto_id');
            $detalles->cantidad_detalle_compra = $request->input('cantidad_detalle_compra');
            $detalles->precio = $request->input('precio');
            $detalles->save();
        }
    
        return redirect()->route('compras.create');
    }

    // Actualizar desde el input del front-end
    public function newItemOrQuantity(Request $request)
    {
        // Update the supplier if provided
        if ($request->input('id_prove') != '') {
            $compra = Compra::findOrFail($request->input('compra_id'));
            $compra->proveedor_id = $request->input('id_prove');
            $compra->save();
        }
    
        // Check if the product already exists in the purchase details
        $detalle = DetalleCompra::where('compra_id', $request->input('compra_id'))
            ->where('producto_id', $request->input('producto_id'))
            ->first();
    
        if ($detalle) {
            // If it exists, update the quantity
            $detalle->cantidad_detalle_compra = $request->input('cantidad_detalle_compra');
            $detalle->save();
        } else {
            // If it doesn't exist, create a new entry
            $detalles = new DetalleCompra();
            $detalles->compra_id = $request->input('compra_id');
            $detalles->producto_id = $request->input('producto_id');
            $detalles->cantidad_detalle_compra = $request->input('cantidad_detalle_compra');
            $detalles->precio = $request->input('precio');
            $detalles->save();
        }
    
        return redirect()->route('compras.create');
    }

    // Finalizar compra y guardarla
    public function compra_guardar(Request $request)
    {
        $request->validate([
            'compra_id'=>  ['required'],
            'docummento_compra' => ['required','unique:compras,docummento_compra,'.$request->input('docummento_compra')],
            'proveedor_id' => ['required']
        ]);

        $compra = Compra::findOrFail($request->input('compra_id'));
        $compra->docummento_compra = $request->input('docummento_compra');
        $compra->fecha_compra = Carbon::now();
        $compra->proveedor_id = $request->input('proveedor_id');
        $compra->user_id = Auth::user()->id;
        $compra->estado_compra = 'g';
        $compra->save();

        foreach ($compra->detalle_compra as $key => $value) {
            $prodcuto = Producto::findOrFail($value->producto_id);
            $prodcuto->existencia = $prodcuto->existencia + $value->cantidad_detalle_compra;
            $prodcuto->save();
        }

        return redirect()->route('compras.index')->with("exito", "La compra fue registrada exitosamente.");
    }

    // Eliminar item de la compra
    public function removeItem($id)
    {
        // Encuentra el detalle de compra por ID
        $detalle = DetalleCompra::findOrFail($id);

        // Elimina el detalle de compra
        $detalle->delete();

        // Redirige a la lista de compras con un mensaje de éxito
        return redirect()->route('compras.create')->with('success', 'Producto eliminado correctamente.');
    }
    
    // Cancelar compra
    public function destroy($id)
    {
        DB::delete('delete from detalle_compras where compra_id = ?', [$id]);
        Compra::destroy($id);
        return redirect()->route('compras.index');
    }
}
