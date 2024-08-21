@extends('layouts.layouts')

@section('breadcrumb')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb" style="font-size: clamp(0.6rem, 3.2vw, 0.8rem)">
    <li class="breadcrumb-item text-secondary"><i class="fas fa-home"></i></li>
    <li class="breadcrumb-item active" aria-current="page">Detalles del producto</li>
  </ol>
</nav>
@endsection

@section('content')
    <link href={{ asset("css/target.css") }} rel="stylesheet" type="text/css">
    <div class="container py-1" style="background: whitesmoke">
      <div class="card">
        <div class=" text-center" style="font-size: clamp(0.8rem, 3vw, 1.2rem); background-color: #4e73df; color: white"><strong>Detalles del producto</strong></div>
          <div class="row ">
            <div class="col-lg-8" style="background: whitesmoke; color: white; font-family: 'Nunito', sans-serif; font-size: small; text-align: justify"> 
              <div class="p-4">
                <div style="color: #1a202c;text-align: justify;">
                  <strong>Código de barra:</strong>  {{$verproducto->codigo}}
                </div>

                <div style="color: #1a202c;text-align: justify;">
                  <strong>Marca:</strong>  {{$verproducto->marca}}
                </div>

                <div style="color: #1a202c;text-align: justify;">
                  <strong>Presentación:</strong>  {{$verproducto->modelo}}
                </div>

                <div style="color: #1a202c; text-align: justify;">
                  <strong>Existencia:</strong>  {{$verproducto->existencia}} unidades
                </div>
                        
                <div style="color: #1a202c; text-align: justify;">
                  <strong>Precio compra:</strong> L. {{ number_format($verproducto->prec_compra, 2, ".", ",") }}
                </div>

                <div style="color: #1a202c; text-align: justify;">
                  <strong>Precio venta:</strong> L. {{ number_format($verproducto->prec_venta_fin, 2, ".", ",") }}
                </div>
                       
                <div style="color: #1a202c; text-align: justify;">
                  <strong>Descripción:</strong> {{$verproducto->descripcion}}
                </div>
                <br>
              </div>
            </div>
  
          <div class="col-lg-4 text-center" style="padding-bottom: 10px;">
            <img src="/images/products/{{$verproducto->imagen_producto}}" width="320px" height="240px" style="object-fit: contain; border-radius: 10%; padding: 15px">
            
            <div class="text-center">
              <a href="/productos" style="font-size: clamp(0.6rem, 3.2vw, 0.9rem); width: auto; display: inline-block; background: #2c3034; color: white; border: 2px solid #ffffff; border-radius: 10px;"
                class="btn btn-google">Regresar
              </a>
              @can('update_products')
              <a href="{{ route('productos.edit', $verproducto) }}" style="font-size: clamp(0.6rem, 3.2vw, 0.9rem); width: auto; display: inline-block; background: #0d6efd; color: white; border: 2px solid #ffffff; border-radius: 10px;"
                class="btn btn-google">Editar
              </a>
              @endcan
            </div>
          </div>
        </div>
      </div>
  </div>
@endsection
