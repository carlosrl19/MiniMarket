@extends('layouts.layouts')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="font-size: clamp(0.6rem, 3.2vw, 0.8rem)">
            <li class="breadcrumb-item text-secondary"><i class="fas fa-home"></i></li>
            <li class="breadcrumb-item active" aria-current="page">Crear producto</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="card shadow mb-4" style="background: whitesmoke">
        <div class="card-header py-3" style="background-color: #4e73df; border-radius:5px 5px 0 0;">
            <div style="float: left">
                <h2 class="m-0 font-weight-bold" style="color: white; font-size: clamp(0.8rem, 3vw, 1rem);">Añadir producto</h2>
            </div>
        </div>
        <br>
        <div class="container">
            <form action="{{ route('productos.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body" style="font-family: 'Nunito', sans-serif; font-size: small; padding-top: 10px">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <div class="col-sm-4 mb-3 mb-sm-0">
                                    <label for="prec_compra" class="form-label">Precio compra:</label>
                                    <input type="text" class="form-control @error('prec_compra') is-invalid @enderror"
                                           id="prec_compra"
                                           name="prec_compra" value="{{ old('prec_compra') }}" 
                                           autocomplete="off"
                                           autofocus maxlength="10"
                                           onkeypress="return funcionLempiras(event);">
                                    @error('prec_compra')
                                    <span class="invalid-feedback" role="alert">
                                        <strong id="input">{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-sm-4 mb-3 mb-sm-0" style="display: none;">
                                    <label for="prec_venta_may" class="form-label">Precio venta:</label>
                                    <input type="text"
                                           class="form-control @error('prec_venta_may') is-invalid @enderror"
                                           id="prec_venta_may"
                                           name="prec_venta_may" value="{{ old('prec_venta_may') }}" 
                                           autocomplete="off"
                                           autofocus maxlength="10"
                                           onkeypress="return funcionLempiras(event);">
                                    @error('prec_venta_may')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-sm-4 mb-3 mb-sm-0">
                                    <label for="prec_venta_fin" class="form-label">Precio venta:</label>
                                    <input type="text"
                                           class="form-control @error('prec_venta_fin') is-invalid @enderror"
                                           id="prec_venta_fin"
                                           name="prec_venta_fin" value="{{ old('prec_venta_fin') }}" 
                                           autocomplete="off"
                                           autofocus maxlength="10"
                                           onkeypress="return funcionLempiras(event);">
                                    @error('prec_venta_fin')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-sm-4 mb-3 mb-sm-0">
                                    <label for="id_categoria" class="form-label">Categoria:</label>
                                    <select class="form-control @error('id_categoria') is-invalid @enderror"
                                            id="id_categoria"
                                             autocomplete="off" name="id_categoria"
                                            autofocus style="font-size: clamp(0.6rem, 3.2vw, 0.95rem);">
                                        <option value="" selected disabled>Seleccione la categoría del producto</option>
                                        @foreach ($categorias as $categoria)
                                            @if($categoria->status == 1)
                                            <option value="{{ $categoria->id }}" {{ old('id_categoria') == $categoria->id ? 'selected' : '' }}>{{ $categoria[ 'name' ]}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('id_categoria')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-sm-12 mb-3 mb-sm-0" style="margin-top: 6px">
                                    <label for="descripcion" class="form-label">Descripción:</label>
                                    <textarea class="form-control @error('descripcion') is-invalid @enderror"
                                              id="descripcion"
                                              name="descripcion" 
                                              autofocus style="resize: none"
                                              minlength="5" maxlength="255" rows="5">{{old('descripcion')}}</textarea>
                                    @error('descripcion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-sm-6 mb-3 mb-sm-0" style="margin-top: 6px">
                                    <label for="marca" class="form-label">Marca:</label>
                                    <input type="text" class="form-control @error('marca') is-invalid @enderror"
                                           id="marca"
                                           name="marca" value="{{ old('marca') }}"  autocomplete="off"
                                           autofocus minlength="3" maxlength="40">
                                    @error('marca')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-sm-6 mb-3 mb-sm-0" style="margin-top: 6px">
                                    <label for="modelo" class="form-label">Presentación del producto:</label>
                                    <input type="text" class="form-control @error('modelo') is-invalid @enderror"
                                           id="modelo"
                                           name="modelo" value="{{ old('modelo') }}"  autocomplete="off"
                                           autofocus minlength="3" maxlength="40">
                                    @error('modelo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-sm-9 mb-3 mb-sm-0" style="margin-top: 6px;">
                                    <label class="form-label" for="imagen_producto">Imagen:</label>
                                    <input type="file" accept="image/*" class="form-control @error('imagen_producto') is-invalid @enderror" 
                                    id="imagen_producto" name="imagen_producto" autocomplete="off" style="font-size: clamp(0.6rem, 3.2vw, 0.8rem);" 
                                    autofocus onchange="mostrar()">
                                    @error('imagen_producto')
                                    <span class="invalid-feedback" role="alert">
                                        <p><strong>{{ $message }}<a target="_blank" href="https://www.iloveimg.com/es/comprimir-imagen"> Es necesario optimizar la imagen del producto.</strong></a></p>
                                    </span>
                                    @enderror
                                </div>

                                <!-- Modal -->
                                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger" style="color: white; font-size: clamp(0.7rem, 6vw, 1rem);">
                                                <p class="modal-title" id="exampleModalLabel">Advertencia</p>
                                            </div>
                                            <div class="modal-body" style="font-size: clamp(0.7rem, 6vw, 0.8rem);">
                                                El tamaño máximo permitido para las imágenes de productos es 8 MB. Intente <a target="_blank" href="https://www.iloveimg.com/es/comprimir-imagen">optimizar la imagen</a>  
                                                o cambiar la imagen del producto a una con menor peso.
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3 mb-3 mb-sm-0" style="margin-top: 6px">
                                    <label for="existencia" class="form-label">Existencia:</label>
                                    <input type="text" class="form-control @error('existencia') is-invalid @enderror"
                                           id="existencia"
                                           name="existencia" value="" 
                                           autocomplete="off"
                                           autofocus maxlength="7"
                                           onkeypress="return funcionLempiras(event);">
                                    @error('existencia')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-sm-12 mb-3 mb-sm-0" style="margin-top: 6px">
                                    <label for="codigo" class="form-label">Código de barra:</label>
                                    <input type="text" class="form-control @error('codigo') is-invalid @enderror"
                                           id="codigo"
                                           name="codigo" value="{{ old('codigo') }}"  autocomplete="off"
                                           autofocus minlength="4" maxlength="13" onkeypress="return funcionLempiras(event);">
                                    @error('codigo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                
                                <div class="row justify-content-center mt-2 ml-1">
                                    <div class="col-sm-6">
                                        <a href="/productos"
                                        style="font-size: clamp(0.6rem, 3.2vw, 1rem); display: inline-block; background: #2c3034; color: white; border: 2px solid #ffffff; border-radius: 10px;"
                                        class="btn btn-google btn-user btn-block mb-2">
                                            {{ __('Regresar') }}
                                        </a>
                                    </div>

                                    <div class="col-sm-6">
                                        <button type="submit"
                                                style="font-size: clamp(0.6rem, 3.2vw, 1rem); display: inline-block; color: white; border: 2px solid #ffffff; border-radius: 10px;"
                                                class="btn btn-primary btn-user btn-block">
                                            {{ __('Registrar') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="col-sm-12 mb-3 mb-sm-0"
                                 style="display: flex; align-items: center; justify-content: center; padding: 10px">
                                <div class="col-lg-7 d-none d-lg-block">
                                    <div class="text-center">
                                        <img id="imagen" src="{{ asset('images/products/no_image_available.png') }}" class="img-fluid rounded" width="600" height="600">
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

    <script>
        $(document).ready(function() {
            $('#prec_venta_fin').on('input', function() {
                $('#prec_venta_may').val($(this).val());
            });
        });
    </script>

    <script>
        function funcionLempiras(evt) {
            var code = (evt.which) ? evt.which : evt.keyCode;
            if (code == 46) {
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
                $('#myModal').modal('show'); // Mostrar el modal
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
