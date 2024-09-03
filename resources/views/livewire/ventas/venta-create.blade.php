<div>
    @include('layouts.flash-message')

    @section('head')
    <link rel="stylesheet" href="{{ asset('css/pos.css')}}">
    @endsection

    @section('breadcrumb')
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb" style="font-size: clamp(0.6rem, 3.2vw, 0.8rem)">
                <li class="breadcrumb-item text-secondary"><i class="fas fa-home"></i></li>
                <li class="breadcrumb-item active" aria-current="page">Facturación</li>
            </ol>
        </nav>
    @endsection

    <div class="content-wrapper">
        <form>
            @csrf
            <div class="row">
                <div class="col-lg-6">
                    <div class="card" style="min-height: 83vh; max-height: 83vh; overflow: auto;">
                        <div class="card-body">
                            <div style="max-height: 65vh; overflow-y: auto;">
                                <table class="table table-striped table-bordered border-b-2">
                                    <!-- Encabezado de la tabla -->
                                    <thead class="text-secondary" style="font-size: clamp(0.5rem, 3vw, 1rem);">
                                        <tr>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>Precio</th>
                                            <th>Subtotal</th>
                                            <th style="max-width: 4rem"></th>
                                        </tr>
                                    </thead>
                                    <!-- Cuerpo de la tabla -->
                                    <tbody style="font-size: clamp(0.5rem, 3vw, 0.8rem);">
                                        @php
                                        $total_carrito = 0;
                                        @endphp
                                        @forelse ($carrito as $index => $item )
                                        <tr>
                                            <td class="titulo">
                                                <div style="width: 9.5vw; white-space: nowrap; text-overflow: ellipsis; overflow: hidden;">
                                                    {{$item["detalle"]}}
                                                </div>
                                            </td>
                                            <td>
                                                <input style="width: 3vw;" type="number" min="1" value="{{$item["cantidad_detalle_venta"]}}" wire:change="actualizar_total($event.target.value, {{ $index}})" class="input_Element">
                                            </td>
                                            <td>{{number_format($item["precio_venta"], 2, ".", ",")}}</td>
                                            <td>{{number_format($item["total"], 2, ".", ",")}}</td>
                                            <td style="max-width: 4rem">
                                                <a class="borrar-producto fas text-lg fa-trash-alt text-danger" wire:click.prevent="eliminar_item_carrito({{$index}})"></a>
                                            </td>
                                        </tr>
                                        @php
                                        $total_carrito += $item["total"];
                                        @endphp
                                        @empty
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer border-0">
                            <br>
                            <p class="text-muted" style="text-align: center; display: flex; justify-content: space-between; font-size: 18px; font-weight: bold">Total:
                                <span style="margin-left: auto;">Lps. 
                                <span id="totalAmount" style="margin-left: auto;">{{number_format( $total_carrito, 2, ".", ",") }}</span>
                            </p>
                            <input type="text" name="pagado" hidden>
                            <a ref="#" wire:click.prevent="guardar({{ true }})" class="btn btn-primary" id="Submit" type="button" style="font-size: clamp(0.5rem, 3vw, 1rem); border: none; margin: 5px; width: 100%">
                                Finalizar venta
                            </a>
                        </div>
                    </div>
                </div>
        </form>

        <!-- Products images div -->
        <div class="col-lg-6">
            <div class="card" style="display: flex; min-height: 83vh; max-height: 83vh; overflow: auto">
                <div class="card-header card-header-fixed">
                    <div class="mb-1" style="display: flex;">
                        <button class="btn btn-sm btn-danger" type="button" disabled><i class="fas fa-search"></i></button>
                        <input type="text" autocomplete="off" name="buscar_producto" id="buscar_producto" wire:model="filtro_producto" class="form-control border-1 small" placeholder="Buscar producto" autocomplete="off" aria-label="Search" aria-describedby="basic-addon2">
                    </div>
                </div>
                <div class="card-body">
                    <div class="row" style="overflow: auto;">
                        <section>
                            <div class="producto" id="producto" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));">
                                @if(count($productos) > 0)
                                    @foreach($productos as $pro)
                                        <div class="agregar-factura" x-data="{ open: true }" style="display: block; height: 170px; width: 140px; padding: 3px">
                                            <div class="card h-100 btn" data-id="{{$pro->id}}" data-codigo="{{$pro->codigo}}" wire:click="agregar_item_carrito({{$pro}})" style="background-color: {{ $pro->existencia == 0 ? '#ff5a5a' : 'inherit' }}">
                                                <!-- Cantidad en existencia -->
                                                @php
                                                    $index = array_search("{$pro->id}", array_column($carrito, 'producto_id'));
                                                @endphp
                                                <div class="badge bg-dark position-absolute" style="top: 0.5rem; right: 0.5rem">
                                                    @if(isset($carrito[$index]) && $carrito[$index]["producto_id"] == $pro->id)
                                                    {{$pro->existencia - $carrito[$index]["cantidad_detalle_venta"] }} unidades
                                                    @else
                                                    {{$pro->existencia}} unidades
                                                    @endif
                                                </div>

                                                <!-- Imagen del producto-->
                                                <img class="card-img-top" style="object-fit: contain" src="/images/products/{{$pro->imagen_producto}}" width="60px" height="80px" title="{{$pro->marca}} {{$pro->modelo}}"/>
                                                
                                                <div style="text-align: center;">
                                                    <div class="text-center">

                                                        <!-- Nombre del producto -->
                                                        <p class="nombre {{ $pro->existencia == 0 ? 'text-white' : '' }}" id="nombre" style="width: 120px; white-space: nowrap; text-overflow: ellipsis; overflow: hidden;">
                                                            <strong style="font-size: 0.7rem" class="text-secondary {{ $pro->existencia == 0 ? 'text-white' : '' }}">{{$pro->marca." ".$pro->modelo}}</strong>
                                                        </p>

                                                        <!-- Precio del producto-->
                                                        <div class="p">
                                                            <span id="pre" class="pre {{ $pro->existencia == 0 ? 'text-white' : 'text-muted' }} text-decoration-line">
                                                                <strong style="font-size: 15px"> L.{{number_format($pro->prec_venta_fin, 2, ".", ",")}}</strong>
                                                                @if(isset($carrito[$index]) && $carrito[$index]["producto_id"] == $pro->id)
                                                                    @php
                                                                        $carrito[$index]["precio_venta"] = $pro->prec_venta_fin;
                                                                        $carrito[$index]["total"] = $carrito[$index]["precio_venta"] * $carrito[$index]["cantidad_detalle_venta"];
                                                                    @endphp
                                                                @endif
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <!-- Mensaje de búsqueda sin resultados -->
                                    <div class="alert alert-danger" role="alert">
                                        <i class="fas fa-database"></i>&nbsp; <span style="font-size: clamp(0.7rem, 6vw, 0.8rem)">Sin productos que coincidan con la búsqueda.</span>
                                    </div>
                                @endif
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const inputBuscarProducto = document.getElementById('buscar_producto');

            inputBuscarProducto.addEventListener('input', function () {
                const codigo = inputBuscarProducto.value.trim(); // Obtiene el código del input
                if (codigo) {
                    const botonProducto = document.querySelector(`[data-codigo="${codigo}"]`); // Encuentra el botón con ese código
                    if (botonProducto) { // Si existe un botón para ese código
                        botonProducto.click(); // Simula un clic en el botón
                        inputBuscarProducto.value = '';

                        // Simular Ctrl+Z 
                        // Se simula para que el input se limpie y pueda escanearse otro producto sin necesidad de limpiar manualmente
                        document.execCommand('undo', false, null);
                    }
                }
            });
        });
    </script>

    <script src="{{ asset('customjs/submit_1_click_disabler.js')}}"></script>
</div>