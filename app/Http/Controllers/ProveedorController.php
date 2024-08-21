<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use App\Http\Requests\Providers\StoreRequest;
use App\Http\Requests\Providers\UpdateRequest;

use Illuminate\Http\Request;

class ProveedorController extends Controller
{

    public function index(Request $request)
    {
        $proveedores = Proveedor::get();
        return view('proveedor.proveedores_index', compact('proveedores'));
    }
    public function create()
    {
        return view('proveedor.proveedores_create');
    }


    public function store(StoreRequest $request)
    {
        Proveedor::create($request->all());
        return redirect()->route('proveedor.index')->with('realizado', 'El proveedor fue creado exitosamente.');
    }

    public function show($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        return view("proveedor.proveedores_show")->with("proveedor", $proveedor);
    }

    public function edit(Proveedor $proveedor)
    {
        return view('proveedor.proveedores_edit', compact('proveedor'));
    }

    public function update(UpdateRequest $request, Proveedor $proveedor)
    {
        $proveedor->update($request->all());
        return redirect()->route("proveedor.index")->with("realizado", "El proveedor fue actualizado exitosamente.");
    }

    public function destroy($id)
    {
        $proveedor = Proveedor::find($id);

        if ($proveedor->compra()->exists()) {
            return redirect()->route('proveedor.index')->with("error", "No se puede eliminar el proveedor porque tiene compras asociadas.");
        }

        Proveedor::destroy($id);
        return redirect()->route('proveedor.index')->with("realizado", "El proveedor se eliminó exitosamente.");
    }
}