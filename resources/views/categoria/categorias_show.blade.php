@extends('layouts.layouts')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="font-size: clamp(0.6rem, 3.2vw, 0.8rem)">
            <li class="breadcrumb-item text-secondary"><i class="fas fa-home"></i></li>
            <li class="breadcrumb-item active" aria-current="page">Detalles de categoría</li>
        </ol>
    </nav>
@endsection

@section('content')
    <link href={{ asset("css/target.css") }} rel="stylesheet" type="text/css">
    <div class="container py-1" style="background: whitesmoke">
        <!-- Carta -->
        <div class="card">
            <div class=" text-center" style="font-size: clamp(0.8rem, 3vw, 1.2rem); background-color: #4e73df; color: white"><strong>Detalles de categoría</strong></div>
            <div class="row ">
                <div class="col-lg-8" style="background: whitesmoke; color: white; font-family: 'Nunito', sans-serif; text-align: justify">
                    <div class="p-5">
                        <p class="m-b-20 p-b-5 b-b-default f-w-600" style="font-size: clamp(0.9rem, 3vw, 1rem); color: #1a202c;"><strong>Datos generales</strong></p>
                        <hr style="color: #1a202c;">
                        <div class="row" style="font-size: clamp(0.8rem, 3.2vw, 1rem);">
                            <div class="col-sm-12">
                                <p  style="color: #1a202c;"><strong>Categoria: </strong>{{$categoria->name}}</p>
                            </div>

                            <div class="col-sm-12" style="margin-top: 10px">

                                @if( $categoria->status == 0)
                                    <p style="color: #1a202c;"><strong style="color: #1a202c">Estado: </strong> Inactivo</p>
                                @endif
                                @if( $categoria->status == 1)
                                    <p style="color: #1a202c;"><strong style="color: #1a202c">Estado: </strong> Activo</p>
                                @endif

                            </div>

                            <div class="col-sm-12" style="margin-top: 10px">
                                <p  style="color: #1a202c;"><strong>Descripción: </strong>{{$categoria->description}}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 text-center" style="padding-bottom: 10px">
                    <div>
                        <img src="/images/resources/bg_categoria.png" width="320px" height="320px" style="object-fit: cover; border-radius: 10%; padding: 15px">
                    </div>

                    <div class="text-center">
                        @can('update_category')
                        <a href="{{route("categorias.edit", $categoria)}}" style="width: auto; display: inline-block; background: #0d6efd; color: white; border: 2px solid #ffffff;border-radius: 10px; font-size: clamp(0.6rem, 3.2vw, 0.9rem);"
                           class="btn btn-google btn-user ">
                            {{ __('Editar') }}
                        </a>
                        @endcan
                        <a href="/categorias" style="width: auto; display: inline-block; background: #2c3034; color: white; border: 2px solid #ffffff;border-radius: 10px; font-size: clamp(0.6rem, 3.2vw, 0.9rem);"
                           class="btn btn-google btn-user ">
                            {{ __('Regresar') }}
                        </a>
                    </div>

                </div>



            </div>
        </div>
        <!-- Carta -->
    </div>

@endsection
