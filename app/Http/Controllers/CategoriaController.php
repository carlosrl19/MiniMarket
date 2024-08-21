<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Http\Requests\Categories\StoreRequest;
use App\Http\Requests\Categories\UpdateRequest;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::get();
        return view('categoria/categorias_index')->with('categorias', $categorias);
    }
    
    public function create()
    {
        return view('categoria.categorias_create');
    }

    public function store(StoreRequest $request)
    {
        Categoria::create($request->all());
        return redirect()->route("categorias.index")->with("exito", "La categoría fue creada exitosamente.");
    }

    public function show($id)
    {
        $categoria = Categoria::findOrFail($id);
        return view("categoria.categorias_show")->with("categoria", $categoria);
    }

    public function edit(Categoria $categoria)
    {
        return view('categoria.categorias_edit', compact('categoria'));
    }

    public function update(UpdateRequest $request, Categoria $categoria)
    {
        $categoria->update($request->all());
        return redirect()->route("categorias.index")->with("exito", "La categoría fue actualizada exitosamente.");
    }

    public function destroy(Categoria $categoria)
    {
        $categoria->delete();
        return redirect()->route("categorias.index")->with("exito", "La categoría fue eliminada exitosamente.");
    }

    public function cambioEstado(Categoria $categoria)
    {
        $categoria->delete();
        if ( $categoria->status == 0) {
            $categoria->status = 1;
        } else {
            $categoria->status = 0;
        }
        $categoria->save();

        return redirect()->route("categorias.index")->with("exito", "El estado de la categoría fue cambiado exitosamente.");
    }
}
