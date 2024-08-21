@extends('layouts.layouts')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="font-size: clamp(0.6rem, 3.2vw, 0.8rem)">
            <li class="breadcrumb-item text-secondary"><i class="fas fa-home"></i></li>
            <li class="breadcrumb-item active" aria-current="page">Categorías</li>
        </ol>
    </nav>
@endsection

@can('create_category')
@section('create')
    <a class="btn btn-sm btn-success" href="{{route("categorias.create")}}" style="font-size: clamp(0.6rem, 3.2vw, 0.8rem); border-radius: 5px">
        <i class="fa fa-plus-square" style="color: white"></i>&nbsp; Crear
    </a>
@endsection
@endcan

@section('content')
    @if (session()->has('exito'))
        <div class="alert alert-success alert-dismissible" style="font-size: clamp(0.6rem, 3.2vw, 0.8rem);" role="alert">
            <strong>{{ session('exito') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible" style="font-size: clamp(0.6rem, 3.2vw, 0.8rem);" role="alert">
            <strong>{{ session('error') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="mb-4">
        <table class="display table table-striped" id="example"  style="font-size: 0.6rem; width: 100%">
            <thead>
                <tr>
                    <th>Categoría</th>
                    <th>Descripción</th>
                    <th style="text-align: center">Estado</th>
                    <th style="text-align: center">Productos asociados</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            
            <tbody>
                @foreach($categorias as $valor => $categoria)
                <tr style="font-family: 'Nunito', sans-serif; font-size: small">
                    <td style="text-transform: uppercase;">
                        <strong>
                            @can('details_category')
                            <a href="{{ route('categorias.show', $categoria)}}">{{ $categoria->name }}</a>
                            @else
                            <p>{{ $categoria->name }}</p>
                            @endcan
                        </strong>
                    </td>
                    <td>{{ $categoria->description}} </td>

                    @if( $categoria->status == 0)
                        <td>
                            <p style="color: darkred; text-align: center">
                                <strong>Inactivo</strong>
                            </p>
                        </td>
                    @endif
                    @if( $categoria->status == 1)
                        <td>
                            <p style="color: darkgreen; text-align: center">
                                <strong>Activo</strong>
                            </p>
                        </td>
                    @endif

                    <td style="width: 10rem; max-width: 10rem; text-align: center">
                        @if($categoria->produc > 0)
                            <strong>Sí</strong>
                        @else
                        <strong class="text-danger">No</strong>
                        @endif
                    </td>

                    <td style="width: 8rem; max-width: 8rem;">
                        @if($categoria->produc > 0)
                        @else
                            @if( $categoria->status == 0)
                                <a class="btn btn-sm btn-dark" href="#" data-bs-toggle="modal"
                                data-bs-target={{ "#modal_estado_categoria".$categoria->id }} >
                                    <i class="fa fa-unlock" style="color: white"></i>
                                </a>
                            @endif
                                @if( $categoria->status == 1)
                                    <a class="btn btn-sm btn-dark" href="#" data-bs-toggle="modal"
                                    data-bs-target={{ "#modal_estado_categoria".$categoria->id }} >
                                        <i class="fa fa-lock" style="color: white"></i>
                                    </a>
                                @endif
                        @endif
                        @if($categoria->produc > 0)
                            <strong class="text-danger">Productos asociados</strong>
                        @else
                        @can('destroy_category')
                            <a class="btn btn-sm btn-danger" href="#" data-bs-toggle="modal" data-bs-target="#modal_eliminar_categoria{{ $categoria->id }}">
                                <i class="fa fa-trash-alt" aria-hidden="true"></i>
                            </a>
                        @else
                            <strong class="text-danger">&nbsp;No permitido</strong>
                        @endcan
                        @endif
                    </td>

                    @if($categoria->produc > 0)
                    @else
                        <div class="modal fade" id={{ "modal_estado_categoria".$categoria->id }} tabindex="-1"
                             aria-labelledby={{ "modal_estado_categoria".$categoria->id }} aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header" style="background: darkred; color: white">
                                        <h5 class="modal-title" id="ModalLabel">Estado de categoria</h5>
                                    </div>
                                    <div class="modal-body">
                                        ¿Desea cambiar el estado de la categoria <b>{{ $categoria->name }}</b>?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancelar
                                        </button>
                                        <form
                                            action="{{ route('categorias.cambiar', ['categoria'=>$categoria->id ]) }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-danger">Cambiar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($categoria->produc > 0)
                    @else
                        <div class="modal fade" id={{ "modal_eliminar_categoria".$categoria->id }} tabindex="-1"
                             aria-labelledby={{ "modal_eliminar_categoria".$categoria->id }} aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger" style="color: white; font-size: clamp(0.7rem, 6vw, 1rem);">
                                        <p class="modal-title" id="ModalLabel">Eliminar categoria</p>
                                    </div>
                                    <div class="modal-body" style="font-size: clamp(0.7rem, 6vw, 0.8rem);">
                                        ¿Desea eliminar la categoria <strong style="text-transform: uppercase;">{{ $categoria->name }}</strong>?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary btn-sm"
                                                data-bs-dismiss="modal">Cancelar
                                        </button>
                                        <form
                                            action="{{ route('categorias.destroy', ['id'=>$categoria->id ]) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>

    <style>
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f2f2f2;
        }

        .table-striped tbody tr:nth-of-type(even) {
            background-color: #ffffff;
        }

        .table-striped tbody tr td {
            border-color: #dddddd;
        }
    </style>

    @include('layouts.datatables')
    <script src="{{ asset('dataTable_configs/dataTable_category.js') }}"></script>
@endsection
