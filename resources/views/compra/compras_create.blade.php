@extends('layouts.layouts')

@section('head')
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
                    <table class="table table-striped" id="example">
                        <thead class="card-header py-3" style="background: #1a202c; color: white;">
                            <tr>
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
                                <tr data-detalle-id="{{ $detalle->id }}">
                                    <td>{{ $detalle->producto->marca }} - {{ $detalle->producto->modelo }}</td>
                                    <td style="min-width: 15px; max-width: 15px">
                                        <form action="{{ route('compras.update_list') }}" method="POST" style="display: inline;">
                                            @csrf
                                            <input type="text" name="compra_id" value="{{ $compra->id }}" hidden>
                                            <input type="text" name="producto_id" value="{{ $detalle->producto->id }}" hidden>
                                            <input type="text" name="precio" value="{{ $detalle->precio }}" hidden>
                                            <input type="number" min="1" name="cantidad_detalle_compra" style="font-size: clamp(0.6rem, 3vw, 0.7rem);"
                                                value="{{ $detalle->cantidad_detalle_compra }}" class="form-control cantidad-input" id="cantidad-input_{{ $detalle->id }}">
                                            <div id="toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                                                <i class="fas fa-save"></i>&nbsp;<span style="font-size: clamp(0.6rem, 3vw, 0.7rem)">Nuevos cambios realizados.</span>
                                                <button type="submit" class="btn btn-primary btn-sm" style="font-size: clamp(0.6rem, 3vw, 0.7rem); float: right">Guardar cambios</button>
                                            </div>
                                        </form>
                                    </td>
                                    <td>L {{ number_format($detalle->precio, 2, ".", ",") }}</td>
                                    <td>L {{ number_format($detalle->precio * $detalle->cantidad_detalle_compra, 2, ".", ",") }}</td>
                                    <td style="max-width: 4rem">
                                        <form action="{{ route('compras.remove_item', $detalle->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE') 
                                            <button type="submit" class="borrar-producto fas text-lg fa-trash-alt text-danger" style="border: none; background: none; cursor: pointer;"></button>
                                        </form>
                                    </td>
                                </tr>
                                @php
                                    $sum += $detalle->precio * $detalle->cantidad_detalle_compra;
                                @endphp
                            @empty
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td style="text-align: center; text-decoration: underline">Sin productos en la lista de compras.</td>
                                    <td></td>
                                    <td></td>
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
                                   class="btn btn-google btn-sm btn-user btn-block">
                                    <i class="fas fa-arrow-left"></i> {{ __('Regresar') }}
                                </a>
                            </div>

                            <div class="col-sm-3">
                                <a style="display: inline-block; background: #b02a37; color: white; border: 2px solid #ffffff; border-radius: 10px;"
                                   data-toggle="modal" data-target="#modal_agregar_detalle" class="btn btn-google btn-user btn-block" onclick="provedor()">
                                   <i class="fas fa-plus-circle"></i> Productos
                                </a>
                            </div>
                            
                            @if($sum == 0)
                                <div class="col-sm-5 mb-3 mb-sm-0">
                                    <button class="btn btn-sm btn-warning" type="button" disabled style="padding: 8px; font-size: clamp(0.5rem, 3vw, 1rem); border-radius: 10px; margin: 2px; width: 100%">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        <span style="font-size: clamp(0.6rem, 3vw, 0.82rem)">
                                            Agregar productos
                                        </span>
                                    </button>
                                </div>
                            @else
                                <div class="col-sm-5 mb-3 mb-sm-0">
                                    <button type="submit" style="display: inline-block; color: white; border: 2px solid #ffffff; border-radius: 10px;"
                                            class="btn btn-sm btn-primary btn-user btn-block">
                                         <i class="fas fa-laptop"></i> {{ __('Registrar compra') }}
                                    </button>
                                </div>
                            @endif
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
                                            required autocomplete="off" name="producto_id" onchange="funcionObtenerCosto(); mostrarImagen(this)">
                                        <option value="" disabled selected>Seleccione el producto a comprar</option>
                                        @foreach ($productos as $producto)
                                            <option value="{{ $producto->id }}" 
                                                    data-imagen="{{ $producto->imagen_producto }}" 
                                                    {{ old('producto_id') == $producto->id ? 'selected' : '' }}>
                                                {{$producto['marca']}} - {{$producto['modelo']}}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('producto_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <br>
                                <div class="row g-3">
                                    <div class="col-6">
                                        <div class="col-sm-12">
                                            <label for="precio" class="text-secondary-d1">Precio compra:</label>
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
                                    </div>

                                    <br>
                                    <div class="col-6">
                                        <div class="col-sm-12">
                                            <label for="existencia" class="text-secondary-d1">Existencia:</label>
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
                                    </div>
                                </div>

                                <br>
                                <div class="col">
                                    <label for="cantidad_detalle_compra" class="form-label">Cantidad compra:</label>
                                    <input type="number" min="1" class="form-control" id="cantidad_detalle_compra"
                                        name="cantidad_detalle_compra" value="" required>
                                </div>

                                <input type="text" id="id_prove" name="id_prove" hidden>
                            </div>

                            <div class="col-6">
                                <div class="card" style="border: 1px solid #e3e3e3">
                                    <span style="font-size: clamp(0.6rem, 3vw, 0.7rem); color: lightgray; padding: 10px">Imagen del producto</span>
                                    <img id="imagen_producto" src="/images/products/no_image_available.png" width="auto" height="220" style="object-fit: contain; padding: 15px">
                                </div>
                            </div>
                        </div>
                    </div>

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

        .toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            display: none; /* Oculto por defecto */
            transition: opacity 0.5s ease;
            opacity: 0;
        }

        .toast.show {
            display: block;
            opacity: 1;
        }

        .dt-buttons{
            display: none;
        }

        #example_filter{
            display: block;
            float: left;
        }

        #example_info{
            font-size: clamp(0.6rem, 3vw, 0.6rem);
            font-style: italic;
            font-weight: bold;
        }
    </style>

    @include('layouts.datatables')
    <script src="{{ asset('dataTable_configs/dataTable_purchase_create.js') }}"></script>

    <!-- Get product data -->
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

    <!-- Img viewer -->
    <script>
        function mostrarImagen(select) {
            const selectedOption = select.options[select.selectedIndex];
            const imagenUrl = selectedOption.getAttribute('data-imagen');
            const imagenElement = document.getElementById('imagen_producto');
            
            if (imagenUrl && imagenUrl.trim() !== '') {
                // Verifica si la imagen existe realmente haciendo una petición
                const img = new Image();
                img.onload = function() {
                    imagenElement.src = '/images/products/' + imagenUrl;
                };
                img.onerror = function() {
                    // Si no se encuentra la imagen, carga la imagen por defecto
                    imagenElement.src = '/images/products/no_image_available.png';
                };
                img.src = '/images/products/' + imagenUrl;
            } else {
                // Si no hay imagen, carga la imagen por defecto
                imagenElement.src = '/images/products/no_image_available.png';
            }
        }
    </script>

    <!-- Items to purchase -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const quantityInputs = document.querySelectorAll('.cantidad-input');

            quantityInputs.forEach(input => {
                input.addEventListener('change', function() {
                    const detalleId = this.dataset.detalleId;
                    const newQuantity = parseInt(this.value);
                    const existingRow = document.querySelector(`tr[data-detalle-id="${detalleId}"]`);

                    if (existingRow) {
                        const totalQuantity = newQuantity;

                        // Update the quantity and subtotal
                        existingRow.querySelector('.cantidad-input').value = totalQuantity;
                        existingRow.querySelector('td:nth-child(5)').innerText = 'L ' + (totalQuantity * parseFloat(existingRow.querySelector('input[name="precio"]').value)).toFixed(2);
                    }
                });
            });
        });
    </script>

    <!-- Toast -->
    <script>
       document.querySelectorAll('.cantidad-input').forEach(function(input) {
            input.addEventListener('input', function() {
                const toast = document.getElementById('toast');
                const detalleId = this.id.split('_')[1];

                setTimeout(function() {
                    toast.classList.add('show');
                    toast.querySelector('.detalle-id').textContent = detalleId;

                    setTimeout(function() {
                        toast.classList.remove('show');
                    }, 7000);
                }, 300);
            });
        });
    </script>

@endsection
