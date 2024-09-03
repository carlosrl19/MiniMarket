<?php
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Compras\ComprasShow;
use App\Http\Livewire\Ventas\VentaCreate;
use App\Http\Livewire\Ventas\VentaIndex;
use App\Http\Livewire\Ventas\VentasShow;

Auth::routes();

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');

    /*
    |--------------------------------------------------------------------------
    | Ventas
    |--------------------------------------------------------------------------
    */

    // Visualizar ventas
    Route::get('/ventas', VentaIndex::class)->name('ventas.index');

    // Registrar venta
    Route::get('/ventas/create', VentaCreate::class)->name('ventas.create');

    //Editar venta
    Route::get('/ventas/{id}/editar', VentaCreate::class)->name('ventas.edit');

    // Factura ventas
    Route::get('/ventas/facturas/{venta}', VentasShow::class)->name('ventas.facturas');

    // Cierre de caja diario Venta / Compra
    Route::get('/generar-factura', 'App\Http\Controllers\VentaClienteController@generarFacturaPorFecha')->name('ventas.generar-factura');
    Route::get('/generar-factura-compras', 'App\Http\Controllers\CompraClienteController@generarFacturaPorFecha')->name('compras.generar-factura-compras');

    // Cierre de caja mensual Venta / Compra
    Route::get('/generar-factura-mes-actual', 'App\Http\Controllers\VentaClienteController@generarFacturaMesActual')->name('ventas.generar-factura-mes-actual');
    Route::get('/generar-factura-mes-actual-compras', 'App\Http\Controllers\CompraClienteController@generarFacturaMesActual')->name('compras.generar-factura-mes-actual-compras');

    /*
    |--------------------------------------------------------------------------
    |   A C A I   S Y S T E M   R O U T E S
    |--------------------------------------------------------------------------
    */

    // Inventario
    Route::get('/inventario', 'App\Http\Controllers\ProductoController@index_inventario')->name('inventario.index');

    /* Purchases registration */
    Route::resource('/compras', 'App\Http\Controllers\CompraClienteController')->names('compras');
    Route::post('/compras/guardar', 'App\Http\Controllers\CompraClienteController@compra_guardar')->name('compras.guardar_compra');

    // Sales invoices
    Route::get('/compras/comprobante/{compra}', ComprasShow::class)->name('compras.facturas'); //app/Http/Livewire/Compras/ComprasShow.php

    /* Providers registration */
    Route::resource('/proveedor', 'App\Http\Controllers\ProveedorController')->names('proveedor');
    Route::delete('/proveedor/{id}', 'App\Http\Controllers\ProveedorController@destroy')
    ->name('proveedor.destroy')->where('id', '[0-9]+');

    /* Products registration */
    Route::resource('/productos', 'App\Http\Controllers\ProductoController')->names('productos');
    Route::delete('/productos/{id}', 'App\Http\Controllers\ProductoController@destroy')
    ->name('productos.destroy')->where('id', '[0-9]+');

    /* Categories registration */
    Route::resource('/categorias', 'App\Http\Controllers\CategoriaController')->names('categorias');
    Route::delete('/categorias/{id}', 'App\Http\Controllers\CategoriaController@destroy')
    ->name('categorias.destroy')->where('id', '[0-9]+');
    
    /* Change Categories status */
    Route::post('/categorias/{categoria}', 'App\Http\Controllers\CategoriaController@cambioEstado')->name('categorias.cambiar');

    /* Users registration */
    Route::resource('/usuarios', 'App\Http\Controllers\UserController')->names('usuarios');
    Route::delete('/usuarios/{id}', 'App\Http\Controllers\UserController@destroy')
    ->name('usuarios.destroy');

});

