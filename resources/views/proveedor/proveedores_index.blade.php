@extends('layouts.layouts') 

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="font-size: clamp(0.6rem, 3.2vw, 0.8rem)">
            <li class="breadcrumb-item text-secondary"><i class="fas fa-home"></i></li>
            <li class="breadcrumb-item active" aria-current="page">Proveedores</li>
        </ol>
    </nav>
@endsection

@can('create_provider')
@section('create')
    <a class="btn btn-sm btn-success" href="{{route("proveedor.create")}}" style="font-size: clamp(0.6rem, 3.2vw, 0.8rem); border-radius: 5px">
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
                    <th>Proveedor</th>
                    <th>RTN</th>
                    <th>Teléfono empresa</th>
                    <th>Encargado</th>
                    <th>Teléfono encargado</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($proveedores as $item=> $proveedor)
                <tr style="font-family: 'Nunito', sans-serif; font-size: small">
                    <td>
                        @can('details_provider')
                        <strong>
                            <a href="{{route('proveedor.show',$proveedor)}}">{{ $proveedor->nombre_proveedor }}</a>
                        </strong>
                        @else
                        <strong>
                        <p>{{ $proveedor->nombre_proveedor }}</p>
                        </strong>
                        @endcan
                    </td>
                    <td>{{ $proveedor->rtn_proveedor }} </td>
                    <td>{{ $proveedor->telefono_proveedor }} </td>
                    <td>{{ $proveedor->contacto_proveedor }} </td>
                    <td>{{ $proveedor->telefono_contacto_proveedor }} </td>
                    <td style="text-align: center; width: 4rem; max-width: 4rem;">
                    @can('destroy_provider')
                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                data-bs-target="#modalEliminarProveedor{{ $proveedor->id }}">
                                <i class="fa fa-trash-alt" aria-hidden="true"></i>
                        </button>
                    @else
                        <strong class="text-danger">&nbsp; No permitido</strong>
                    @endcan
                    </td>

                    <!-----------MODAL PARA ELIMINAR UN PROVEEDOR---------------->
                    <div class="modal fade" id="modalEliminarProveedor{{ $proveedor->id }}"
                        data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                        aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header bg-danger" style="color: white; font-size: clamp(0.7rem, 6vw, 1rem);">
                                    <p class="modal-title" id="staticBackdropLabel">Eliminar Proveedor</p>
                                </div>

                                <form action="{{ route('proveedor.destroy',$proveedor->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-body" style="font-size: clamp(0.7rem, 6vw, 0.8rem);">
                                        ¿Desea eliminar al proveedor
                                        <strong>{{ $proveedor->nombre_proveedor }}?</strong>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary btn-sm"
                                            data-bs-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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
    <script src="{{ asset('dataTable_configs/dataTable_provider.js') }}"></script>
@endsection
