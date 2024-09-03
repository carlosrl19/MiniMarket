@extends('layouts.layouts')

@section('head')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <!-- Tomselect -->
    <link href="{{ asset('vendor/tomselect/tom-select.min.css') }}" rel="stylesheet">
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="font-size: clamp(0.6rem, 3.2vw, 0.8rem)">
            <li class="breadcrumb-item text-secondary"><i class="fas fa-home"></i></li>
            <li class="breadcrumb-item active" aria-current="page">Registrar compra</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="card shadow mb-4" style="background: whitesmoke;">
        <div class="card-header py-3" style="background-color: #4e73df; border-radius:5px 5px 0 0;">
            <div style="float: left">
                <h2 class="m-0 font-weight-bold" style="color: white; font-size: clamp(0.8rem, 3vw, 1rem);">Registrar compra</h2>
            </div>
            <div style="float: right">
                <form action="{{ route('compras.destroy', $compra->id) }}" id='form_eliminar' method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="display: inline-block; color: white; border: 2px solid #ffffff; border-radius: 4px; font-size: clamp(0.7rem, 3vw, 0.8rem);"
                            class="btn btn-sm btn-danger btn-user btn-block">
                        <i class="fas fa-ban"></i> {{ __('Cancelar compra') }}
                    </button>
                </form>
            </div>
        </div>

        <div class="card-body" style="font-family: 'Nunito', sans-serif; font-size: clamp(0.7rem, 3vw, 0.8rem)">
            <div class="row" id="tblaBody">
                <div class="col-lg-6">
                    <div class="table-responsive" id="tblaBody">
                        <table class="table table" id="dataTable">
                            <thead class="card-header py-3" style="background: #1a202c; color: white;">
                            <tr>
                                <th>N°</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $sum = 0;
                            @endphp
                            @forelse($compra->detalle_compra as $i => $detalle)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $detalle->producto->marca}} - {{ $detalle->producto->modelo}} </td>
                                    <td>{{ $detalle->cantidad_detalle_compra }}</td>
                                    <td>L {{ number_format($detalle->precio, 2, ".", ",") }}</td>
                                    <td>L {{ number_format($detalle->precio*$detalle->cantidad_detalle_compra, 2, ".", ",") }}</td>
                                    <td style="max-width: 4rem">
                                        <a class="borrar-producto fas text-lg fa-trash-alt text-danger" wire:click.prevent="eliminar_item_carrito({{$i}})"></a>
                                    </td>
                                </tr>
                                @php
                                    $sum += $detalle->precio*$detalle->cantidad_detalle_compra;
                                @endphp
                            @empty
                                <tr>
                                    <td colspan="8">Sin detalles disponibles en la base de datos.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <hr>
                </div>

                <div class="col-lg-6 d-lg-block">
                    <form method="POST" class="user" action="{{route("compras.guardar_compra")}}" >
                        @csrf
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="text" name="compra_id" id="compra_id" value="{{ $compra->id }}" hidden>
                                <label for="docummento_compra">Factura:</label>
                                <input type="text" readonly class="form-control @error('docummento_compra') is-invalid @enderror" id="docummento_compra"
                                       name="docummento_compra" value="CP-{{Carbon\Carbon::now()->setTimezone('America/Costa_Rica')->format('Y-md-Hms')}}" required autocomplete="off"
                                        placeholder="{{ __('') }}"
                                       style="text-transform: uppercase; background-color: white; font-size: clamp(0.7rem, 3vw, 0.8rem)">
                                @error('docummento_compra')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-sm-6">
                                <label for="fecha_compra">Fecha:</label>
                                <input type="datetime-local" class="form-control @error('fecha_compra') is-invalid @enderror"
                                    id="fecha_compra"
                                    name="fecha_compra" value="{{Carbon\Carbon::now()->setTimezone('America/Costa_Rica')->format('Y-m-d H:i')}}"
                                    required
                                    autocomplete="off"
                                    readonly
                                    style="background-color: white; font-size: clamp(0.7rem, 3vw, 0.8rem)">
                                @error('fecha_compra')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="proveedor_id">Proveedor:</label>
                                    <select class="form-control @error('proveedor_id') is-invalid @enderror"  id="proveedor_id" required autocomplete="off" name="proveedor_id" style="font-size: clamp(0.7rem, 3vw, 0.8rem)">
                                        <option value="" disabled>Seleccione el proveedor</option>
                                        @forelse ($provedores as $provedore)
                                            <option 
                                                @if( $compra->proveedor_id == $provedore->id )
                                                    selected
                                                @endif value="{{ $provedore->id }}">{{ $provedore->nombre_proveedor }}
                                            </option>
                                        @empty
                                            <option value="0">Proveedor</option>
                                        @endforelse
                                    </select>
                                    @error('proveedor_id')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="sum">Total a pagar: </label>
                                    <p style="background-color: darkgreen; color: #fff; padding: 0.5vw; border-radius: 3px;"><strong>Lps. {{ number_format($sum, 2, ".", ",") }}</strong></p>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row" style="margin-top: 15px">

                            <div class="col-sm-4 mb-1 mb-sm-0">
                                <a href="{{ route('compras.index') }}" style="display: inline-block; background: #2c3034; color: white; border: 2px solid #ffffff; border-radius: 10px;"
                                   class="btn btn-google  btn-sm btn-user btn-block">
                                    {{ __('Regresar') }}
                                </a>
                            </div>

                            <div class="col-sm-5">
                                <a style="display: inline-block; background: #b02a37; color: white; border: 2px solid #ffffff;border-radius: 10px;"
                                   data-toggle="modal" data-target="#modal_agregar_detalle" class="btn btn-google btn-user btn-block" onclick="provedor()">
                                   <i class="fas fa-plus-circle"></i> Productos
                                </a>
                            </div>
                            
                            <div class="col-sm-3 mb-3 mb-sm-0">
                                <button type="submit" style="display: inline-block; color: white; border: 2px solid #ffffff; border-radius: 10px;"
                                        class="btn btn-sm btn-primary btn-user btn-block">
                                    {{ __('Registrar') }}
                                </button>
                            </div>                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_agregar_detalle" data-bs-backdrop="static"
         data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #b02a37; color: white; font-size: clamp(0.7rem, 6vw, 1rem);">
                    <p class="modal-title" id="staticBackdropLabel">Agregar productos</p>
                </div>

                <form action="{{ route('compras.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-6">
                                <input type="text" name="compra_id" id="compra_id" value="{{ $compra->id }}" hidden>
                                <div class="col-sm-12">
                                    <label for="producto_id" class="form-label">Productos en inventario:</label>
                                    <select class="@error('producto_id') is-invalid @enderror"
                                            id="producto_id"
                                            required autocomplete="off" name="producto_id"  onchange="funcionObtenerCosto()">
                                        <option value="" disabled selected>Seleccione el producto a comprar</option>
                                        @foreach ($productos as $producto)
                                            <option value="{{ $producto->id }}" {{ old('producto_id') == $producto->id ? 'selected' : '' }}>{{$producto['marca']}} - {{$producto['modelo']}}</option>
                                        @endforeach
                                    </select>
                                    @error('producto_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-sm-4">
                                    <label for="precio" class="text-secondary-d1">Precio de compra:</label>
                                    <input type="text"
                                        class="form-control @error('precio') is-invalid @enderror"
                                        id="precio"
                                        name="precio" value="{{ old('precio') }}" required
                                        autocomplete="off"
                                            readonly
                                        style="background-color: white; border-left: 4px solid lightgray;">
                                    @error('precio')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-sm-4">
                                    <label for="existencia" class="text-secondary-d1">Existencia actual:</label>
                                    <input type="text"
                                        class="form-control @error('existencia') is-invalid @enderror"
                                        id="existencia"
                                        name="existencia" value="{{ old('existencia') }}" required
                                        autocomplete="off"
                                            readonly
                                        style="background-color: white; border-left: 4px solid lightgray;">
                                    @error('existencia')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-sm-4">
                                    <label for="firstName" class="form-label">Cantidad a comprar:</label>
                                    <input type="number" min="1" class="form-control" id="cantidad_detalle_compra"
                                        name="cantidad_detalle_compra" value="" required>
                                </div>

                                <input type="text" id="id_prove" name="id_prove" hidden>
                            </div>

                            <div class="col-6">
                                <img src="/images/products/{{$producto->imagen_producto}}" width="320px" height="240px" style="object-fit: contain; border-radius: 10%; padding: 15px">
                            </div>
                        </div>
                    </div>

                    <!-----ESTE BOTON ES EL BOTON DEL MODAL PARA CREAR EL NUEVO INVENTARIO-->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm" style="background-color: #2c3034; color: #fff;" data-dismiss="modal">Cancelar
                        </button>
                        <button type="submit" class="btn btn-sm btn-primary">Continuar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <style>
    .table-responsive {
        max-height: 400px;
        overflow-y: auto;
        display: block;
    }

    .table thead th {
        position: sticky;
        top: 0;
        background-color: #000;
        z-index: 1;
    }
    </style>

    <script>
        function funcionObtenerCosto(){ // Obtener existencia también
            var select = document.getElementById("producto_id");
            var valor = select.value;

            @foreach ($productos as $producto)
            if(valor == {{$producto->id}}){
                // Obtener precio
                var input = document.getElementById("precio");
                input.value = "{{$producto->prec_compra}}";
                
                // Obtener existencia
                var input = document.getElementById("existencia");
                input.value = "{{$producto->existencia}}";
            }
            @endforeach
        }

        function provedor() {
            $('#id_prove').val($('#proveedor_id').val());
         }
    </script>

    <!-- Tomselect -->
    <script src="{{ asset('vendor/tomselect/tom-select.complete.js') }}"></script>
    <script src="{{ asset('js/tomselect/ts_products.js') }}"></script>

@endsection
