@extends('layouts.layouts')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="font-size: 0.8rem">
            <li class="breadcrumb-item text-secondary"><i class="fas fa-home"></i></li>
            <li class="breadcrumb-item active" aria-current="page">Productos</li>
        </ol>
    </nav>
@endsection

@can('create_products')
@section('create')
    <a class="btn btn-sm btn-success" href="{{ route("productos.create") }}" style="font-size: clamp(0.6rem, 3.2vw, 0.8rem); border-radius: 5px">
        <i class="fa fa-plus-square" style="color: white"></i>&nbsp; Crear
    </a>
@endsection
@endcan

@section('content')

    @if(session('realizado'))
        <div class="alert alert-success alert-dismissible fade show" style="font-size: clamp(0.6rem, 3.2vw, 0.8rem);" role="alert">
            <strong>{{ session('realizado') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" style="font-size: clamp(0.6rem, 3.2vw, 0.8rem);" role="alert">
            <strong>{{ session('error') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="mb-4">
        <table class="display table table-striped" id="example"  style="font-size: 0.6rem; width: 100%">
            <thead>
            <tr>
                <th>Código barra</th>
                <th>Producto</th>
                <th>Descripción</th>
                <th>Existencia</th>
                <th>Precio venta</th>
                <th>Opciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($productos as $item => $producto)
                <tr style="font-family: 'Nunito', sans-serif; font-size: small">
                    <td style="width: 8rem; max-width: 8rem; text-transform: uppercase">
                        @if($producto->codigo == '')
                            <p class="text-danger"><strong>Sin código</strong></p>
                        @else
                            {{$producto->codigo}}
                        @endif
                    </td>
                    <td style="text-transform: uppercase; min-width: 150px; max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        <strong>
                            <a href="{{ route('productos.show', $producto) }}">{{ $producto->marca }} {{ $producto->modelo }}</a>
                        </strong>
                    </td>
                    <td style="max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $producto->descripcion}}">{{ $producto->descripcion }}</td>
                    <td>
                        @if($producto->existencia == 0)
                            <p class="text-danger">{{ $producto->existencia }} unidades</p>
                        @else
                            <p>{{ $producto->existencia }} unidades</p>             
                        @endif           
                    </td>
                    <td>L. {{ number_format($producto->prec_venta_fin, 2, ".", ",") }}</td>
                    <td style="text-align: center; width: 4rem; max-width: 4rem;">
                        @can('destroy_products')
                        <a class="btn btn-sm btn-danger" href="#" data-toggle="modal" data-target="#modal-eliminar{{ $producto->id }}">
                            <i class="fa fa-trash-alt" aria-hidden="true"></i>
                        </a>

                        <div class="modal fade" id="modal-eliminar{{ $producto->id }}"
                            data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                            aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger" style="color: white; font-size: clamp(0.7rem, 6vw, 1rem);">
                                        <p class="modal-title" id="staticBackdropLabel">Eliminar producto</p>
                                    </div>
                                    <form action="{{ route('productos.destroy', $producto->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-body" style="font-size: clamp(0.7rem, 6vw, 0.8rem);">
                                            ¿Desea eliminar el producto: <strong style="text-transform: uppercase">{{ $producto->marca }}</strong> con presentación <strong>{{ $producto->modelo }}</strong>?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary btn-sm"
                                                    data-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @else
                        <strong class="text-danger">&nbsp; No permitido</strong>
                        @endcan
                    </td>
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
    <br>
    
    @include('layouts.datatables')
    <script src="{{ asset('dataTable_configs/dataTable_product.js') }}"></script>
@endsection
