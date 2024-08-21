@extends('layouts.layouts')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="font-size: clamp(0.6rem, 3.2vw, 0.8rem)">
            <li class="breadcrumb-item text-secondary"><i class="fas fa-home"></i></li>
            <li class="breadcrumb-item active" aria-current="page">Inventario</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="mb-4 ">
        <table class="display table table-striped" id="example"  style="font-size: 0.6rem; width: 100%">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Producto</th>
                    <th>Descripción</th>
                    <th>Existencia</th>
                    <th>Precio compra</th>
                    <th>Precio venta</th>
                </tr>
            </thead>
            <tbody>
            @foreach($productos as $item => $producto)
                <tr style="font-family: 'Nunito', sans-serif; font-size: small">
                    <td style="width: 6rem; max-width: 6rem;">
                        @if($producto->codigo == '')
                        <strong class="text-danger">Sin código</strong>
                        @else
                        <strong>{{ $producto->codigo }}</strong>
                        @endif
                    </td>
                    <td style="max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;text-transform: uppercase;" title="{{ $producto->marca }} {{ $producto->modelo }}">{{ $producto->marca }} {{ $producto->modelo }}</td>
                    <td style="max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $producto->descripcion }}">{{ $producto->descripcion }}</td>
                    <td>
                        @if($producto->existencia == 0)
                            <p class="text-danger">{{ $producto->existencia }} unidades</p>
                        @else
                            <p>{{ $producto->existencia }} unidades</p>             
                        @endif           
                    </td>
                    <td><strong style="text-align: left; color: darkred">L. {{ number_format($producto->prec_compra, 2, ".", ",") }}</strong></td>
                    <td><strong style="text-align: left; color: darkslategrey">L. {{ number_format($producto->prec_venta_fin, 2, ".", ",") }}</strong></td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>

    @include('layouts.datatables')
    <script src="{{ asset('dataTable_configs/dataTable_inventory.js') }}"></script>

@endsection
