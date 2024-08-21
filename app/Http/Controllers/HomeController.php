<?php

namespace App\Http\Controllers;

use App\Http\VarStatic;
use App\Models\DetalleCompra;
use App\Models\DetalleVenta;
use App\Models\Producto;
use App\Models\User;
use App\Models\Venta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $ingresos = 0;
        $egresos = 0;

        // Obtener la fecha de inicio de la semana actual
        $fecha_inicio_semana = Carbon::now()->startOfWeek();

        // Obtener la fecha de fin de la semana actual
        $fecha_fin_semana = Carbon::now()->endOfWeek();

        // Obtener la fecha actual
        $fecha_actual = Carbon::now()->format('Y-m-d');

        $datos_ventas = DB::select('CALL traer_ventas_por_mes(?)', [Carbon::now()->format('Y')]);
        $datos_compras = DB::select('CALL traer_compras_por_mes(?)', [Carbon::now()->format('Y')]);
        $vendedores = DB::select('CALL traer_vendedores(?,?)', [Carbon::now()->format('Y'),Carbon::now()->format('m')]);

        // Nueva consulta para obtener los totales de ventas de cada vendedor para la semana actual
        $ventas_semana_actual = Venta::whereBetween('fecha_factura', [$fecha_inicio_semana, $fecha_fin_semana])
        ->select('user_id', DB::raw('SUM(total) as total_semana_actual'))
        ->groupBy('user_id')
        ->get();

        // Consulta para obtener las ventas del día actual
        $ventas_dia = Venta::whereDate('fecha_factura', $fecha_actual)
        ->select('user_id', DB::raw('SUM(total) as total_dia'))
        ->groupBy('user_id')
        ->get();

        $valores_ventas = [];
        foreach ($datos_ventas as $key => $value) {
            $valores_ventas[] = $value;
        }

        $valores_compre = [];
        foreach ($datos_compras as $key => $value) {
            $valores_compre[] = $value;
        }

        foreach( DetalleVenta::all() as $valor){
            $ingresos += $valor->cantidad_detalle_venta * $valor->precio_venta;
        }

        foreach( DetalleCompra::all() as $valor){
            $egresos += $valor->cantidad_detalle_compra * $valor->precio;
        }

        if(Auth::user()->hasRole('Administrador') || Auth::user()->hasRole('Empleado')){
            return view('home')->with('ingresos',$ingresos)
                ->with('egresos',$egresos)
                ->with('valores_ventas',$valores_ventas)
                ->with('valores_compre',$valores_compre)
                ->with('vendedores',$vendedores)
                ->with('ventas_semana_actual', $ventas_semana_actual)
                ->with('ventas_dia', $ventas_dia);
        }

        $use = User::findOrFail(Auth::user()->id);
        $use->assignRole('Cliente');
        Auth::login($use);
    }
}