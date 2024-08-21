@extends('layouts.layouts')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="font-size: clamp(0.6rem, 3.2vw, 0.8rem)">
            <li class="breadcrumb-item text-secondary"><i class="fas fa-home"></i></li>
            <li class="breadcrumb-item active" aria-current="page">Usuarios</li>
        </ol>
    </nav>
@endsection

@can('create_category')
@section('create')
    <a class="btn btn-sm btn-success" href="{{route("usuarios.create")}}" style="font-size: clamp(0.6rem, 3.2vw, 0.8rem); border-radius: 5px">
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
        <table class="display table table-striped" id="example" style="font-size: 0.6rem; width: 100%">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>E-mail</th>
                    <th>Rol de usuario</th>
                    <th>Teléfono</th>
                    <th style="text-align: center">Opciones</th>
                </tr>
            </thead>
            
            <tbody>
                @foreach($users as $valor => $user)
                <tr style="font-family: 'Nunito', sans-serif; font-size: small">
                    <td style="text-transform: uppercase">
                        <strong>
                            <a href="{{route('usuarios.show', $user)}}">{{ $user->name }}</a>
                        </strong>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <strong>{{ $user->type }}</strong>
                    </td>
                    <td>{{ $user->telephone }}</td>
                    @if($user->type == 'Administrador')
                        <td style="text-align: center">
                            <strong class="text-danger">Usuario protegido</strong>
                        </td>
                        @else
                        <td style="text-align: center">
                            @can('destroy_users')
                            <strong>No disponible</strong>
                            @else
                            <strong>&nbsp;No permitido</strong>
                            @endcan
                        </td>
                    @endif                                
                </tr>
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
    <script src="{{ asset('dataTable_configs/dataTable_user.js') }}"></script>
@endsection

