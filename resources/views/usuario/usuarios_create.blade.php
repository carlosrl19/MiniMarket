@extends('layouts.layouts')
@section('content')
    <div class="card shadow mb-4" style="background: whitesmoke">
        <div class="card-header py-3" style="background: #4e73df; border-radius:5px 5px 0 0;">
            <div style="float: left">
                <h2 class="m-0 font-weight-bold" style="color: white; font-size: clamp(0.8rem, 3vw, 1rem);">Añadir usuario</h2>
            </div>
        </div>
        <br>
        <div class="container">
            <form action="{{ route('usuarios.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body" style="font-family: 'Nunito', sans-serif; font-size: small; padding-top: 10px">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <div class="col-sm-7 mb-3 mb-sm-0">
                                    <label for="name" class="form-label">Nombre completo:</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                           name="name" value="{{ old('name') }}"  autocomplete="off"
                                            maxlength="40"
                                           onkeypress="return funcionLetras(event);"
                                           style="text-transform: capitalize;">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>


                                <div class="col-sm-5 mb-3 mb-sm-0">
                                    <label for="telephone" class="form-label">Teléfono:</label>
                                    <input type="tel" class="form-control @error('telephone') is-invalid @enderror" id="telephone"
                                           name="telephone" value="{{ old('telephone') }}"  autocomplete="off"
                                           
                                           onkeypress="return funcionNumeros(event);" minlength="8" maxlength="8">
                                    @error('telephone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-sm-7 mb-3 mb-sm-0" style="margin-top: 6px">
                                    <label for="email" class="form-label">Correo electrónico:</label>
                                    <input  type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                            name="email" value="{{ old('email') }}"
                                             autocomplete="off">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-sm-5 mb-3 mb-sm-0" style="margin-top: 6px">
                                    <label for="type" class="form-label">Rol de usuario:</label>
                                    <select class="form-control @error('type') is-invalid @enderror"
                                            id="type" autocomplete="off" name="type">
                                        <option value="">Seleccione</option>
                                        <option value="Empleado">Empleado</option>
                                        <option value="Administrador">Administrador</option>
                                    </select>
                                    @error('type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-sm-5 mb-3 mb-sm-0 none" style="margin-top: 6px; display: none">
                                    <label for="customer" class="form-label">Tipo de cliente:</label>
                                    <input  type="customer" class="form-control @error('customer') is-invalid @enderror" id="customer"
                                            name="customer" value="Mayorista" autocomplete="off" readonly style="background-color: white">
                                    @error('customer')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-sm-6 mb-3 mb-sm-0" style="margin-top: 6px">
                                    <label for="password" class="form-label">Contraseña:</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                                           name="password" placeholder="{{ __('Contraseña') }}" 
                                           autocomplete="off">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-sm-6 mb-5 mb-sm-0" style="margin-top: 6px">
                                    <label for="confirm" class="form-label">Confirmar contraseña:</label>
                                    <div class="input-group">
                                        <input id="password-confirm" name="password_confirmation" type="password"
                                               class="form-control"
                                               placeholder="{{ __('Confirmar') }}"  autocomplete="off">
                                        <div class="input-group-append">
                                            <button id="show_password" class="btn btn-primary" style="display: inline-block; background: #2c3034; color: white; " type="button" onclick="fShowPassword()"> <span class="fa fa-eye-slash icon"></span> </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 mb-3 mb-sm-0" style="margin-top: 6px">
                                    <label for="address" class="form-label">Dirección:</label>
                                    <textarea class="form-control @error('address') is-invalid @enderror"
                                              id="address"
                                              name="address" 
                                              
                                              minlength="5" maxlength="255" rows="3">{{old('address')}}</textarea>
                                    @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-sm-12 mb-3 mb-sm-0" style="margin-top: 6px">
                                    <label class="form-label" for="image">Imagen:</label>
                                    <input type="file" accept="image/*"
                                           class="form-control @error('image') is-invalid @enderror"
                                           id="image"
                                           name="image" value="{{old('image')}}" 
                                           autocomplete="off"
                                            onchange="mostrar()">
                                    @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                            </div>
                        </div>
                        {{old('image')}}
                        <div class="col-sm-6">
                            <div class="col-sm-12 mb-3 mb-sm-0"
                                 style="display: flex; align-items: center; justify-content: center;padding: 10px">
                                <div class="col-lg-7 d-none d-lg-block">
                                    <div class="text-center">
                                        <input type="text" id="imgRender" hidden name="imgRender">
                                        <img id="imagen" @if(old('imgRender'))
                                            src="{{old('imgRender')}}"
                                             @else
                                                 src=""
                                             @endif
                                             style="background-color: #fff" class="img-fluid rounded" width="1200" height="1200">
                                    </div>

                                    <div class="form-group row" style="margin-top: 15px">
                                        <div class="col-sm-6">
                                            <a href="javascript:history.back()" style="font-size: clamp(0.6rem, 3.2vw, 1rem); display: inline-block; background: #2c3034; color: white; border: 2px solid #ffffff; border-radius: 10px;" 
                                                class="btn btn-dark btn-sm btn-block">
                                                Regresar
                                            </a>
                                        </div>

                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <button type="submit" style="font-size: clamp(0.6rem, 3.2vw, 1rem); display: inline-block; color: white; border: 2px solid #ffffff; border-radius: 10px;" 
                                                class="btn btn-primary btn-sm btn-block">
                                                Registrar
                                            </button>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
        <br>
    </div>

@endsection
@push('scripts')
    <script src="{{ asset('js/custom_scripts/show_pass.js') }}"></script>
    <script type="text/javascript">
        function funcionLetras(evt) {
            var code = (evt.which) ? evt.which : evt.keyCode;
            var input = evt.target.value;

            // No permitir números, ni símbolos
            if (code >= 33 && code <= 64 || code >= 186 && code <= 222 || code >= 91 && code <= 96) {
                return false;
            }

            // No permitir espacios al principio
            if (code == 32 && input.length === 0) {
                return false;
            }

            // Transformar primera letra de cada palabra a mayúscula
            var words = input.split(" ");
            for (var i = 0; i < words.length; i++) {
                words[i] = words[i].charAt(0).toUpperCase() + words[i].slice(1).toLowerCase();
            }
            var modifiedInput = words.join(" ");
            evt.target.value = modifiedInput;

            // Permitir separar palabras (mínimo una vez, máximo tres)
            if (code == 32) {
                var spaceCount = (input.match(/ /g) || []).length;
                if (spaceCount >= 3) {
                    return false;
                }
            }
            return true;
        }

        function funcionNumeros(evt) {
            var code = (evt.which) ? evt.which : evt.keyCode;
            if (code == 8) {
                return true;
            } else if (code >= 48 && code <= 57) {
                return true;
            } else {
                return false;
            }
        }

        function mostrar(){
            if (document.getElementById("image").files.length <= 0) return;

            var archivo = document.getElementById("image").files[0];

            if (archivo.size > 1000000) {
                const tamanioEnMb = 1000000 / 1000000;
                alert(`El tamaño máximo es ${tamanioEnMb} MB`);

                document.getElementById("image").value = "";
            } else {

                var reader = new FileReader();
                if (archivo) {
                    reader.readAsDataURL(archivo);
                    reader.onloadend = function () {
                        document.getElementById("imagen").src = reader.result;
                        document.getElementById("imgRender").value = reader.result;
                    }
                }
            }
        }
    </script>
@endpush
