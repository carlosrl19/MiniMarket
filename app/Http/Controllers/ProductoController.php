<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use App\Http\Requests\Products\StoreRequest;
use App\Http\Requests\Products\UpdateRequest;
use Illuminate\Http\Request;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $productos = Producto::with('categoria')->get();
        $categorias = Categoria::where('status','=',1)->get();
        return view('producto.productos_index', compact('productos', 'categorias'));
    }
    
    public function store(StoreRequest $request)
    {
        $crearprod = new Producto();
        $crearprod->codigo = $request->input('codigo');
        $crearprod->marca = $request->input('marca');
        $crearprod->modelo = $request->input('modelo');
        $crearprod->descripcion = $request->input('descripcion');
        $crearprod->existencia = $request->input('existencia');
        $crearprod->prec_compra = $request->input('prec_compra');
        $crearprod->prec_venta_may = $request->input('prec_venta_may');
        $crearprod->prec_venta_fin = $request->input('prec_venta_fin');
        $crearprod->id_categoria = $request->input('id_categoria');
    
        if ($request->hasFile('imagen_producto')) {
            $image = $request->file('imagen_producto');
            $destinationPath = 'images/products/';
            $file_name = $image->getClientOriginalName();
            $profileImage = $file_name;
            $image->move($destinationPath, $profileImage);
    
            // Optimizar la imagen recién subida con spatie/image-optimizer
            $optimizerChain = OptimizerChainFactory::create();
            $optimizerChain->optimize($destinationPath . $profileImage);
    
            $crearprod['imagen_producto'] = $profileImage;
        } else {
            $crearprod['imagen_producto'] = 'no_image_available.png';
        }
    
        $crearprod->save();
    
        return redirect()->route('productos.index')->with('realizado', 'El producto fue creado exitosamente.');
    }

    public function show($id)
    {
        $verproducto = Producto::find($id);
        return view('producto.productos_show', compact('verproducto'));
    }

    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        $categorias = Categoria::all();
        return view('producto.productos_edit', compact('categorias'))->with('producto', $producto);
    }

    public function update(UpdateRequest $request, $id)
    {
        $producto = Producto::findOrFail($id);
    
        // Actualizar los valores del producto
        $producto->codigo = $request->input('codigo');
        $producto->marca = $request->input('marca');
        $producto->modelo = $request->input('modelo');
        $producto->descripcion = $request->input('descripcion');
        $producto->existencia = $request->input('existencia');
        $producto->prec_compra = $request->input('prec_compra');
        $producto->prec_venta_may = $request->input('prec_venta_may');
        $producto->prec_venta_fin = $request->input('prec_venta_fin');
        $producto->id_categoria = $request->input('id_categoria');
    
        // Manejar la imagen del producto si se proporciona
        if ($request->hasFile('imagen_producto')) {
            $image = $request->file('imagen_producto');
            $destinationPath = 'images/products/';

            // Generar un nombre de archivo único
            $file_name = time() . '_' . $image->getClientOriginalName();
            
            // Eliminar la imagen anterior si existe
            if ($producto->imagen_producto != 'no_image_available.png') {
                $oldImagePath = public_path($destinationPath . $producto->imagen_producto);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Mover la nueva imagen
            $image->move($destinationPath, $file_name);

            // Optimizar la imagen recién subida
            $optimizerChain = OptimizerChainFactory::create();
            $optimizerChain->optimize($destinationPath . $file_name);

            $producto->imagen_producto = $file_name;
        }
    
        $producto->save();
    
        return redirect()->route('productos.index')->with('realizado', 'El producto fue actualizado de manera exitosa.');
    }

    public function destroy($id)
    {
        try {
            Producto::destroy($id);
            return redirect()->route('productos.index')->with('realizado','El producto fue eliminado de manera exitosa.');
        } catch (\Illuminate\Database\QueryException $e) { // se captura y pasa el error a un mensaje de error
            $errorCode = $e->errorInfo[1];
            if($errorCode == 1451) {
                return redirect()->route('productos.index')->with('error', 'El producto no puede ser eliminado porque existen compras asociadas.');
            }
            return redirect()->route('productos.index')->with('error', 'Acción no permitida.');
        }
    }
    
    public function index_inventario(Request $request)
    {
        $productos = Producto::with('categoria')->get();
        return view('inventario.Inventario_index', compact('productos'));
    }
}
