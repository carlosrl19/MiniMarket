<?php

namespace App\Http\Livewire\Compras;

use App\Models\Categoria;
use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\DetalleVenta;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\User;
use App\Models\Venta;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ComprasCreate extends Component
{
    public $filtro_producto = "";
    public $idcompra = 0;
    public $compra;
    public $editar = false;

    public $data = [
        "docummento_compra" => "",
        "fecha_compra" => "",
        "user_id" => "",
        "username" => "",
        "proveedor_id" => "",
        "cliente_telefono" => "",
        "tipo_cliente_factura" => "",
        "estado"
    ];

    public $carrito = [];


    public function render()
    {
        return view('compra.compras_create', [
            "provedors" => Proveedor::all(),
            "productos" => Producto::where("marca", "like", "%{$this->filtro_producto}%")
                ->orWhere("modelo", "like", "%{$this->filtro_producto}%")
                ->orWhere("codigo", "like", "%{$this->filtro_producto}%")
                ->get()
        ])
            ->extends('layouts.layouts')
            ->section('content');
    }


    public function mount($id = null)
    {
        if ($id != null) {
            $this->idcompra = $id;
            $this->editar = true;
            $this->compra = Compra::findOrFail($id);

            $this->data["docummento_compra"] = $this->compra->docummento_compra;
            $this->data["fecha_compra"] = $this->compra->fecha_compra;
            $this->data["user_id"] = $this->compra->user_id;
            $this->data["proveedor_id"] = $this->compra->proveedor_id;
            $this->data["estado_compra"] = $this->compra->estado_compra;
            $this->data["user_id"] = Auth::user()->id;
            $this->data["username"] = Auth::user()->name;

            foreach ($this->compra->detalle_compra as $item) {
                $vals = [
                    "id" => $item->id,
                    "producto_id" => $item->producto_id,
                    "detalle" => "{$item->producto->marca} {$item->producto->modelo}",
                    "cantidad_detalle_compra" => $item->cantidad_detalle_compra,
                    "precio_compra" => $item->precio,
                    "total" => $item->cantidad_detalle_compra * $item->precio,
                ];
                array_push($this->carrito, $vals);
            }
        } else {
            $this->data["docummento_compra"] = "CP".Carbon::now()->format('Ymdhms');
            $this->data["fecha_compra"] = Carbon::now()->setTimezone('America/Costa_Rica')->format('Y-m-d') . 'T' . Carbon::now()->setTimezone('America/Costa_Rica')->format('H:i');
            $this->data["user_id"] = Auth::user()->id;
            $this->data["username"] = Auth::user()->name;
        }
    }

    // propiedad computada para traer el telefono del cliente seleccionado
    public function getTelProperty()
    {
        if ($this->data["proveedor_id"]) {
            return Proveedor::find($this->data["proveedor_id"])->telefono_proveedor;
        }
    }

    // propiedad computada para traer el tipo de cliente seleccionado
    public function getCustomerProperty()
    {
        if ($this->data["proveedor_id"]) {
            return Proveedor::find($this->data["proveedor_id"])->contacto_proveedor;
        }
    }

    // propiedad computada para calcular el total de la venta
    public function getTotalProperty()
    {
        $totales = array_column($this->carrito, 'total');
        return array_sum($totales);
    }


    public function actualizar_total($cantidad, $index = 0)
    {
        // actualizo la cantidad y el total

        $stock = Producto::findOrFail($this->carrito[$index]["producto_id"])->existencia;

            if ( $cantidad >= $stock ) {
                $this->carrito[$index]["cantidad_detalle_compra"] = $stock  ;
            }
            else {
                $this->carrito[$index]["cantidad_detalle_compra"] = $cantidad;
            }
        $this->carrito[$index]["total"] = $this->carrito[$index]["cantidad_detalle_compra"] * $this->carrito[$index]["precio_compra"];
    }


    public function actualizar_precio($precio, $index = 0)
    {
        if (!is_numeric($precio)) {
            $precio = 1;
        }

        if ($precio <= 0) {
            $precio = 1;
        }
        $this->carrito[$index]["precio_compra"] = $precio;

        $this->carrito[$index]["total"] = $this->carrito[$index]["cantidad_detalle_compra"] * $this->carrito[$index]["precio_compra"];
    }

    public function agregar_item_carrito($producto)
    {
        $item = [
            "producto_id" => $producto["id"],
            "detalle" => "{$producto["marca"]} {$producto["modelo"]}",
            "cantidad_detalle_compra" => 1,
            "precio_compra" => $producto["prec_compra"],
            "total" => $producto["prec_compra"],
        ];

        // verifico si el producto que se va a agregar ya existe
        $existe = in_array("{$producto['id']}", array_column($this->carrito, 'producto_id'));

        // si el producto no existe entonces lo agrego de lo contrario muestro un error
        if (!$existe) {

            $stock = Producto::findOrFail($producto["id"])->existencia;
            if ($stock == 0) {
            }
            else {
                array_push($this->carrito, $item);
            }


        } else {
            #busco el index del elemento que contengo el id del producto que ando buscando
            $index = array_search("{$producto['id']}", array_column($this->carrito, 'producto_id'));

            // aumento la cantidad en 1 y el total
            $this->carrito[$index]["cantidad_detalle_compra"] += 1;
            $stock = Producto::findOrFail($producto["id"])->existencia;
            if ( $this->carrito[$index]["cantidad_detalle_compra"] > $stock ) {
                $this->carrito[$index]["cantidad_detalle_compra"] = $stock;
            }

            $this->carrito[$index]["total"] = $this->carrito[$index]["cantidad_detalle_compra"] * $this->carrito[$index]["precio_compra"];
        }
    }

    public function guardar($pagar = false)
    {


        if (!$this->editar) {
            // valido los datos del formulario
        $this->validate([
            'data.docummento_compra' => ['required','unique:compras,docummento_compra,'. $this->data["docummento_compra"]],
            'data.proveedor_id' => ['required','min:1']
        ],
        [
            'data.docummento_compra.required' => '¡Numero de documento es obligatorio!',
            'data.docummento_compra.unique' => '¡Numero de documento es debe ser unico!',
            'data.proveedor_id.required' => '¡Debes seleccionar a un proveedor!',
            'data.proveedor_id.min' => '¡Debes seleccionar a un proveedor!',
        ]);

            $compra = new Compra();
            $compra->docummento_compra = $this->data["docummento_compra"];
            $compra->fecha_compra = $this->data["fecha_compra"];
            $compra->user_id = $this->data["user_id"];
            $compra->proveedor_id = $this->data["proveedor_id"];
            $compra->estado_compra = 'E';
            $compra->save();

            if ($compra) {
                foreach ($this->carrito as $key => $item) {
                    $detalle_compra = new DetalleCompra();
                    $detalle_compra->compra_id = $compra->id;
                    $detalle_compra->producto_id = $item["producto_id"];
                    $detalle_compra->cantidad_detalle_compra = $item["cantidad_detalle_compra"];
                    $detalle_compra->precio = $item["precio_compra"] ;
                    $detalle_compra->save();
                }
                foreach ($compra->detalle_compra as $key => $value) {
                    $prodcuto = Producto::findOrFail($value->producto_id);
                    $prodcuto->existencia = $prodcuto->existencia + $value->cantidad_detalle_compra;
                    $prodcuto->prec_compra =  $value->precio;
                    $prodcuto->save();
                }

            }

            return redirect()->route('compras.index')->with('success', '¡Compra guardada con éxito!');
        } else {
            $this->validate([
                'data.docummento_compra' => ['required','unique:compras,docummento_compra,'. $this->compra->id],
                'data.proveedor_id' => ['required','min:1']
            ],
            [
                'data.docummento_compra.required' => '¡Numero de documento es obligatorio!',
                'data.docummento_compra.unique' => '¡Numero de documento es debe ser unico!',
                'data.proveedor_id.required' => '¡Debes seleccionar a un proveedor!',
                'data.proveedor_id.min' => '¡Debes seleccionar a un proveedor!',
            ]);
            $this->compra->docummento_compra = $this->data["docummento_compra"];
            $this->compra->fecha_compra = $this->data["fecha_compra"];
            $this->compra->user_id = $this->data["user_id"];
            $this->compra->proveedor_id = $this->data["proveedor_id"];
            $this->compra->save();

            foreach ($this->compra->detalle_compra as $key => $value) {
                $prodcuto = Producto::findOrFail($value->producto_id);
                $prodcuto->existencia = $prodcuto->existencia - $value->cantidad_detalle_compra;
                $prodcuto->save();
            }

            //elimino los items de esta venta para volver agregarlos con los nuevos cambios
            DetalleCompra::where('compra_id', $this->compra->id)->truncate();

            foreach ($this->carrito as $key => $item) {
                $detalle_compra = new DetalleCompra();
                $detalle_compra->compra_id = $this->compra->id;
                $detalle_compra->producto_id = $item["producto_id"];
                $detalle_compra->cantidad_detalle_compra = $item["cantidad_detalle_compra"];
                $detalle_compra->precio = $item["precio_compra"];
                $detalle_compra->save();

                $prodcuto = Producto::findOrFail($item["producto_id"]);
                $prodcuto->existencia = $prodcuto->existencia + $detalle_compra->cantidad_detalle_compra;
                $prodcuto->prec_compra =  $item["precio_compra"];
                $prodcuto->save();
            }

            return redirect()->route('compras.index')->with('success', '¡Compra editada con éxito!');
        }
    }

    public function eliminar_item_carrito($index)
    {
        // elimino el item del arreglo
        unset($this->carrito[$index]);
    }
}
