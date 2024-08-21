@extends('layouts.layouts')
@section('content')
    <link href={{ asset("css/target.css") }} rel="stylesheet" type="text/css">
    <div class="container py-1">
        <div class="card">
            <div class="text-center" style="font-size: clamp(0.8rem, 3vw, 1.2rem); background-color: #4e73df; color: white"><strong>Detalles de usuario</strong></div>
            <div class="row">
                <div class="col-lg-8" style="background: whitesmoke; color: white; font-family: 'Nunito', sans-serif; font-size: small; text-align: justify">
                    <div class="p-5">
                        <h5 class="m-b-20 p-b-5 b-b-default f-w-600" style="color: #1a202c; font-size: large"><strong>{{$user->name}}</strong></h5>
                        <hr style="color: #1a202c; font-family: 'Nunito', sans-serif;"> 
                        <div class="row" style="font-size: clamp(0.8rem, 3.2vw, 1rem);">
                            <div class="col-sm-12" style="margin-top: 10px">
                                <h6 style="color: #1a202c;">
                                    <strong>Correo electrónico: </strong>{{$user->email}}
                                </h6>
                            </div>

                            <div class="col-sm-12" style="margin-top: 10px">
                                <h6 style="color: #1a202c;">
                                    <strong>Telefóno: </strong>{{$user->telephone}}
                                </h6>
                            </div>

                            <div class="col-sm-12"style="margin-top: 10px">
                                <h6 style="color: #1a202c;">
                                    <strong>Rol: </strong>{{$user->type}}
                                </h6>
                            </div>

                            <div class="col-sm-12" style="margin-top: 10px">
                                <h6 style="color: #1a202c;">
                                    <strong>Dirección: </strong>{{$user->address}}
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 text-center" style="padding-bottom: 10px">
                    <div>
                        <img src="/images/uploads/{{ $user->image }}" width="290px" height="290px" style="border-radius: 10%; padding: 15px">
                    </div>

                    <div class="text-center">
                        <a href="/usuarios" style="width: auto; display: inline-block; background: #2c3034; color: white; border: 2px solid #ffffff;border-radius: 10px; font-size: clamp(0.8rem, 3.2vw, 0.9rem);"
                           class="btn btn-google btn-user ">
                            {{ __('Regresar') }}
                        </a>

                        @can('update_users')
                        <a href="{{route("usuarios.edit", $user)}}" style="width: auto; display: inline-block; background: #0d6efd; color: white; border: 2px solid #ffffff;border-radius: 10px; font-size: clamp(0.8rem, 3.2vw, 0.9rem);"
                           class="btn btn-google btn-user ">
                            {{ __('Editar') }}
                        </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
