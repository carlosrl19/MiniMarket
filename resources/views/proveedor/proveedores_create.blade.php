@extends('layouts.layouts')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="font-size: 0.8rem">
            <li class="breadcrumb-item text-secondary"><i class="fas fa-home"></i></li>
            <li class="breadcrumb-item active" aria-current="page">Crear proveedor</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="card shadow mb-4" style="background: whitesmoke">
        <div class="card-header py-3" style="background: #4e73df; border-radius:5px 5px 0 0;">
            <div style="float: left">
                <h2 class="m-0 font-weight-bold" style="color: white; font-size: clamp(0.8rem, 3vw, 1rem);">Añadir proveedor</h2>
            </div>
        </div>

        <div class="card-body">
            <!-- Nested Row within Card Body -->
            <div class="row" style="background: whitesmoke">
                <div class="col-lg-12">
                    <div class="p-5" style="font-family: 'Nunito', sans-serif; font-size: small; padding-top: 10px">
                        <form action="{{ route('proveedor.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <div class="col-sm-4 mb-3 mb-sm-0">
                                    <label class="form-label" for="nombre_proveedor">Empresa:</label>
                                    <input type="text" class="form-control @error('nombre_proveedor') is-invalid @enderror" id="nombre_proveedor"
                                           name="nombre_proveedor" value="{{ old('nombre_proveedor') }}"  autocomplete="off"
                                           autofocus>
                                    @error('nombre_proveedor')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-sm-4">
                                    <label class="form-label" for="telefono_proveedor">Teléfono de la Empresa :</label>
                                    <input type="tel" class="form-control @error('telefono_proveedor') is-invalid @enderror" id="telefono_proveedor"
                                           name="telefono_proveedor" value="{{ old('telefono_proveedor') }}"  autocomplete="off"
                                           autofocus
                                           onkeypress="return funcionNumeros(event);" maxlength="8">
                                    @error('telefono_proveedor')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-sm-4">
                                    <label class="form-label" for="rtn_proveedor">RTN:</label>
                                    <input type="text" class="form-control @error('rtn_proveedor') is-invalid @enderror" id="rtn_proveedor"
                                           name="rtn_proveedor" value="{{ old('rtn_proveedor') }}"  autocomplete="off"
                                           autofocus maxlength="14"
                                           placeholder="##############"
                                           onkeypress="return funcionNumeros(event);">
                                    @error('rtn_proveedor')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label class="form-label" for="contacto_proveedor">Nombre del encargado:</label>
                                    <input type="text" class="form-control @error('contacto_proveedor') is-invalid @enderror" id="contacto_proveedor"
                                           name="contacto_proveedor" value="{{ old('contacto_proveedor') }}"  autocomplete="off"
                                           autofocus>
                                            @error('contacto_proveedor')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-sm-6">
                                    <label class="form-label" for="telefono_contacto_proveedor">Teléfono del encargado:</label>
                                    <input type="tel" class="form-control @error('telefono_contacto_proveedor') is-invalid @enderror" id="telefono_contacto_proveedor"
                                           name="telefono_contacto_proveedor" value="{{ old('telefono_contacto_proveedor') }}"  autocomplete="off"
                                           autofocus
                                           onkeypress="return funcionNumeros(event);" maxlength="8">
                                    @error('telefono_contacto_proveedor')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-0">
                                <label class="form-label" for="direccion_proveedor">Dirección de la empresa:</label>
                                <textarea class="form-control @error('direccion_proveedor') is-invalid @enderror"
                                          id="direccion_proveedor"
                                          name="direccion_proveedor"  autocomplete="off"
                                          placeholder="Dirección de la empresa proveedora de productos"
                                          maxlength="255" rows="3">{{old('direccion_proveedor')}}</textarea>
                                @error('direccion_proveedor')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group row" style="margin-top: 15px">
                                <div class="col-sm-6">
                                    <a href="/proveedor" style="font-size: clamp(0.6rem, 3.2vw, 1rem); display: inline-block; background: #2c3034; color: white; border: 2px solid #ffffff; border-radius: 10px;"
                                       class="btn btn-google btn-user btn-block">
                                        {{ __('Regresar') }}
                                    </a>
                                </div>
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <button type="submit" style="font-size: clamp(0.6rem, 3.2vw, 1rem); display: inline-block; color: white; border: 2px solid #ffffff;border-radius: 10px;"
                                            class="btn btn-primary btn-user btn-block">
                                        {{ __('Registrar') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript">

        function funcionLetras(event) {
        const tecla = event.key;
        const regex = /^[a-zA-Z]+$/;
        
        if (!regex.test(tecla)) {
                event.preventDefault();
            }
        }

        function funcionNumeros(evt) {
            var code = (evt.which) ? evt.which : evt.keyCode;
            if (code == 8) {
                return true;
            } else if (code == 45) {
                return true;
            } else if (code >= 48 && code <= 57) {
                return true;
            } else {
                return false;
            }
        }

        function mostrar() {
            if (document.getElementById("imagen_producto").files.length <= 0) return;

            var archivo = document.getElementById("imagen_producto").files[0];

            if (archivo.size > 8000000) {
                alert("El tamaño máximo permitido para las imágenes de productos es 8 MB. Intente optimizar la imagen.");
                document.getElementById("imagen_producto").value = "";
            } else {
                var reader = new FileReader();
                if (archivo) {
                    reader.readAsDataURL(archivo);
                    reader.onloadend = function () {
                        document.getElementById("imagen").src = reader.result;
                    }
                }
            }
        }
    </script>
@endpush
