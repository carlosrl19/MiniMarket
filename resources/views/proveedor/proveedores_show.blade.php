@extends('layouts.layouts')

@section('breadcrumb')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb" style="font-size: clamp(0.6rem, 3.2vw, 0.8rem)">
    <li class="breadcrumb-item text-secondary"><i class="fas fa-home"></i></li>
    <li class="breadcrumb-item active" aria-current="page">Detalles del proveedor</li>
  </ol>
</nav>
@endsection

@section('content')
    <link href={{ asset("css/target.css") }} rel="stylesheet" type="text/css">
    <div class="container py-1">
        <div class="card">
            <div class="text-center" style="font-size: clamp(0.8rem, 3vw, 1.2rem); background-color: #4e73df; color: white"><strong>Detalles del proveedor</strong></div>
            <div class="row ">
                <div class="col-lg-8" style="background: whitesmoke; color: white; font-family: 'Nunito', sans-serif; font-size: small; text-align: justify">
                    <div class="p-5">
                        <h5 class="m-b-20 p-b-5 b-b-default f-w-600" style="font-size: clamp(0.9rem, 3vw, 1rem); color: #1a202c;"><strong>{{$proveedor->nombre_proveedor}}</strong></h5>
                        <hr style="color: #1a202c; font-family: 'Nunito', sans-serif; font-size: clamp(0.9rem, 3vw, 1rem); color: #1a202c;">
                        <div class="row" style="font-size: clamp(0.8rem, 3.2vw, 1rem);">
                            <div class="col-sm-12" style="margin-top: 10px">
                                <p  style="color: #1a202c;"><strong>RTN: </strong>{{$proveedor->rtn_proveedor}}</p>
                            </div>

                            <div class="col-sm-12" style="margin-top: 10px">
                                <p  style="color: #1a202c;"><strong>Encargado: </strong>{{$proveedor->contacto_proveedor}}</p>
                            </div>

                            <div class="col-sm-12"style="margin-top: 10px">
                                <p  style="color: #1a202c;"><strong>Teléfono (encargado): </strong>{{$proveedor->telefono_contacto_proveedor}}</p>
                            </div>

                            <div class="col-sm-12"style="margin-top: 10px">
                                <p  style="color: #1a202c;"><strong>Teléfono (empresa): </strong>{{$proveedor->telefono_proveedor}}</p>
                            </div>

                            <div class="col-sm-12" style="margin-top: 10px">
                                <p  style="color: #1a202c;"><strong>Dirección: </strong>{{$proveedor->direccion_proveedor}}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 text-center" style="padding-bottom: 10px">
                    <div>
                        <img src="/images/resources/bg_proveedor.jpg" width="320px" height="320px" style="object-fit: cover; border-radius: 10%; padding: 15px">
                    </div>

                    <div class="text-center">
                        @can('update_provider')
                        <a href="{{route("proveedor.edit", $proveedor)}}" style="width: auto; display: inline-block; background: #0d6efd; color: white; border: 2px solid #ffffff; border-radius: 10px; font-size: clamp(0.6rem, 3.2vw, 0.9rem);"
                           class="btn btn-google btn-user ">
                            {{ __('Editar') }}
                        </a>
                        @endcan
                        <a href="/proveedor" style="width: auto; display: inline-block; background: #2c3034; color: white; border: 2px solid #ffffff; border-radius: 10px; font-size: clamp(0.6rem, 3.2vw, 0.9rem);"
                           class="btn btn-google btn-user ">
                            {{ __('Regresar') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
