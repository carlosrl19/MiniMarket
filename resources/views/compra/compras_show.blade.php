@section('sidebarToggle')
	<a href="{{ route('compras.index' )}}" class="btn btn-sm btn-secondary"><i class="fas fa-arrow-left"></i> Volver</a>
@endsection

@section('create')
	<button id="printButton" class="btn btn-sm btn-danger"><i class="fas fa-file-pdf"></i> Imprimir</button>
@endsection

<div class="container">
   <div class="card cart">
    <label class="title font-weight-light"></a>&nbsp;&nbsp;#{{ $compra->docummento_compra }}</label>
        <div class="steps">
            <div class="step-container">
                <img src="{{ asset('images/resources/logo_upscaled.jpg')}}" width="35%" height="90%" style="border: 2px solid #e3e3e3; padding: 2%; border-radius: 3%">
                <div class="step card" style="box-shadow: none; height: 90%; margin: 0 0 0 0.3rem; justify-content: center">
                    <span>DATOS DE COMPRA</span>
                    <p class="font-weight-light"><strong>Empleado</strong>:&nbsp;{{ $compra->user->name }}</p>
                    <p class="font-weight-light"><strong>Proveedor</strong>:&nbsp;{{ $compra->proveedor->nombre_proveedor }}</p>
                    <p class="font-weight-light"><strong>Fecha</strong>:&nbsp;
                        {{ \Carbon\Carbon::parse($compra->fecha_compra)}}
                    </p>
                    <p class="font-weight-light"><strong>Factura</strong>:&nbsp;{{ $compra->docummento_compra }}</p>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped" style="width: 100%; font-size: 0.8rem; text-align: center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio de compra</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $total = 0;
                        @endphp
                        @foreach ($compra->detalle_compra as $i => $detalle)
                        <tr>
                            <td class="num">{{ ++$i }}</td>
                            <td class="descripcion" style="text-align: center">
                                {{ $detalle->producto->marca . ' ' . $detalle->producto->modelo }}
                            </td>
                            <td class="cant">
                                @if($detalle->cantidad_detalle_compra == 1)
                                    {{ $detalle->cantidad_detalle_compra }} unidad
                                @else
                                    {{ $detalle->cantidad_detalle_compra }} unidades
                                @endif
                            </td>
                            <td class="precu">L {{ number_format($detalle->precio, 2) }}</td>
                            <td class="total">L
                                {{ number_format($detalle->precio * $detalle->cantidad_detalle_compra, 2) }}
                            </td>
                        </tr>
                        @php
                            $total += $detalle->precio * $detalle->cantidad_detalle_compra;
                        @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card checkout">
            <div class="footer">
                <label class="price">Total de compra</label>
                <button class="checkout-btn">L. {{ number_format($total, 2, '.', ',') }}</button>
            </div>
        </div>
   </div>
</div>

<script>
	const printButton = document.getElementById('printButton');
	printButton.addEventListener('click', function() {
		window.print();
	});
</script>

<link href={{ asset("css/facturas.css") }} rel="stylesheet" type="text/css">


<style>
*{
	margin: 0;
	padding: 0;
	box-sizing: border-box;
}
p, label, span, table{
	font-size: 9pt;
}
.h2{
	font-size: 16pt;
}
.h3{
	font-size: 12pt;
	display: block;
	background: #0a4661;
	color: #FFF;
	text-align: center;
	padding: 3px;
	margin-bottom: 5px;
}
#page_pdf{
	width: 95%;
	margin: 15px auto 10px auto;
}

#factura_head, #factura_cliente, #factura_detalle{
	width: 100%;
	margin-bottom: 10px;
}
.logo_factura{
	width: 25%;
}
.info_empresa{
	width: 50%;
	text-align: center;
}
.info_factura{
	width: 25%;
}
.info_cliente{
	width: 100%;
}
.datos_cliente{
	width: 100%;
}
.datos_cliente tr td{
	width: 50%;
}
.datos_cliente{
	padding: 10px 10px 0 10px;
}
.datos_cliente label{
	width: 75px;
	display: inline-block;
}
.datos_cliente p{
	display: inline-block;
}

.textright{
	text-align: right;
}
.textleft{
	text-align: left;
}
.textcenter{
	text-align: center;
}
.round{
	border-radius: 10px;
	border: 1px solid #0a4661;
	overflow: hidden;
}
.round p{
	padding: 0 15px;
}

#factura_detalle{
	border-collapse: collapse;
}
#factura_detalle thead th{
	background: #058167;
	color: #FFF;
	padding: 5px;
}
#detalle_productos tr:nth-child(even) {
    background: #ededed;
}
.label_gracias{
	font-family: verdana;
	font-weight: bold;
	font-style: italic;
	text-align: center;
	margin-top: 20px;
}
/* Ocultar buscador de datatable */
.dataTables_filter {
  display: none;
}

/* Texto de muestra por página - lado superior */
.dataTables_length{
  display: none;
}

/* Texto de muestra por página - lado inferior */
.dataTables_info{
  display: none;
}

/* Paginación */
.dataTables_paginate{
  display: none;
}

.dataTables_wrapper .dt-buttons {
  text-align: center;
  padding: 2px 10px 2px 10px;
}

@media print {
        /* Oculta la barra de navegación superior */
        .navbar {
            display: none !important;
        }

        /* Oculta la barra lateral */
        .sidebar {
            display: none !important;
        }
        .options{
            display: none !important;
        }

        /* Ajusta el ancho del contenido principal */
        .container.bootdey {
            width: 100%;
            margin: 0;
        }

        /* Ajusta el tamaño de la fuente para la impresión */
        body {
            font-size: 12pt;
        }
    }
</style>