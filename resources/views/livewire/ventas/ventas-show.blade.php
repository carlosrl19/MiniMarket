@section('sidebarToggle')
<a href="{{ route('ventas.index' )}}" class="btn btn-sm btn-secondary"><i class="fas fa-arrow-left"></i> Volver</a>
@endsection

@section('create')
<button id="printButton" class="btn btn-sm btn-danger"><i class="fas fa-file-pdf"></i> Imprimir</button>
@endsection

<div id="page_pdf">
	<table id="factura_head">
		<tr>
			<td class="logo_factura">
				<div>
					<img src="{{ asset('images/resources/sidebar_logo_generic.png') }}" width="128" height="128">
				</div>
			</td>
			<td class="info_empresa">
				<div>
					<span style="font-size: clamp(0.8rem, 3vw, 0.9rem);"><strong>{{ config('app.name') }}</strong></span>
					<p>Plaza 20, 20 Calle SE, 7 Y 8 avenida SE</p>
				</div>
			</td>
			<td class="info_factura">
				<div>
					<span class="h3">Factura</span>
					<p></p>
					<p></p>
					<p></p>
					<p><strong>No. Factura:</strong> {{$venta->numero_factura_venta}}</p>
					<p><strong>Fecha:</strong> {{\Carbon\Carbon::parse($venta->fecha_factura)->isoFormat("DD")}} de {{\Carbon\Carbon::parse($venta->fecha_factura)->isoFormat("MMMM")}}, {{\Carbon\Carbon::parse($venta->fecha_factura)->isoFormat("YYYY")}}</p>
				</div>
			</td>
		</tr>
	</table>
	<table class="display table table-striped" style="width: 100%">
		<thead style="font-size: 0.7rem;">
			<tr>
				<th>Nº</th>
				<th class="textleft">Producto</th>
				<th>Cantidad</th>
				<th class="textright" width="150px">Precio</th>
				<th class="textright" width="150px">Subtotal</th>
			</tr>
		</thead>
		<tbody id="detalle_productos" style="font-size: clamp(0.5rem, 3vw, 0.69rem);">
			@php
			$total=0;
			@endphp
			@foreach ($venta->detalle_venta as $i => $detalle)
			<tr>
				<td>{{++$i}}</td>
				<td>{{$detalle->producto->marca." ".$detalle->producto->modelo}}</td>
				<td>{{$detalle->cantidad_detalle_venta}}</td>
				<td class="textright">{{ number_format($detalle->precio_venta, 2, ".", ",") }}</td>
				<td class="textright">{{ number_format($detalle->precio_venta * $detalle->cantidad_detalle_venta, 2, ".", ",") }}</td>
			</tr>
			@php
			$total+=$detalle->precio_venta*$detalle->cantidad_detalle_venta;
			@endphp
			@endforeach
		</tbody>
		<tfoot id="detalle_totales">
			<tr style="font-size: clamp(0.5rem, 3vw, 0.9rem);">
				<th colspan="4" class="textright">Total</th>
				<th colspan="1" class="textright">{{ number_format($total, 2, ".", ",") }}</th>
			</tr>
		</tfoot>
	</table>
	<div>
		<h4 class="label_gracias">¡Gracias por su compra!</h4>
	</div>

</div>

@include('layouts.datatables')

<script>
	const printButton = document.getElementById('printButton');
	printButton.addEventListener('click', function() {
		window.print();
	});
</script>

<style>
	* {
		margin: 0;
		padding: 0;
		box-sizing: border-box;
	}

	p,
	label,
	span,
	table {
		font-size: 9pt;
	}

	.h2 {
		font-size: 16pt;
	}

	.h3 {
		font-size: 12pt;
		display: block;
		background: #0a4661;
		color: #FFF;
		text-align: center;
		padding: 3px;
		margin-bottom: 5px;
	}

	#page_pdf {
		width: 95%;
		margin: 15px auto 10px auto;
	}

	#factura_head,
	#factura_cliente,
	#factura_detalle {
		width: 100%;
		margin-bottom: 10px;
	}

	.logo_factura {
		width: 25%;
	}

	.info_empresa {
		width: 50%;
		text-align: center;
	}

	.info_factura {
		width: 25%;
	}

	.info_cliente {
		width: 100%;
	}

	.datos_cliente {
		width: 100%;
	}

	.datos_cliente tr td {
		width: 50%;
	}

	.datos_cliente {
		padding: 10px 10px 0 10px;
	}

	.datos_cliente label {
		width: 75px;
		display: inline-block;
	}

	.datos_cliente p {
		display: inline-block;
	}

	.textright {
		text-align: right;
	}

	.textleft {
		text-align: left;
	}

	.textcenter {
		text-align: center;
	}

	.round {
		border-radius: 10px;
		border: 1px solid #0a4661;
		overflow: hidden;
	}

	.round p {
		padding: 0 15px;
	}

	#factura_detalle {
		border-collapse: collapse;
	}

	#factura_detalle thead th {
		background: #058167;
		color: #FFF;
		padding: 5px;
	}

	#detalle_productos tr:nth-child(even) {
		background: #ededed;
	}

	.label_gracias {
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
	.dataTables_length {
		display: none;
	}

	/* Texto de muestra por página - lado inferior */
	.dataTables_info {
		display: none;
	}

	/* Paginación */
	.dataTables_paginate {
		display: none;
	}

	.dataTables_wrapper .dt-buttons {
		text-align: center;
		padding: 2px 10px 2px 10px;
	}

	@media print {

		/* Oculta la barra de navegación superior */
		.navbar,
		.sidebar,
		.options {
			display: none !important;
		}

		/* Ajusta el ancho del contenido principal para la impresión */
		#page_pdf {
			width: 80mm;
			/* Ajusta al tamaño de papel de la impresora */
			margin: 0 auto;
			/* Centra el contenido */
			font-size: 10pt;
			/* Tamaño de fuente adecuado para impresión */
		}

		/* Ajusta los elementos dentro de la factura */
		#factura_head,
		#factura_detalle {
			width: 100%;
			margin-bottom: 10px;
		}

		/* Asegúrate de que las tablas ocupen el ancho completo */
		table {
			width: 100%;
			border-collapse: collapse;
		}

		th,
		td {
			padding: 5px;
			/* Espaciado adecuado */
			font-size: 9pt;
			/* Tamaño de fuente más pequeño */
		}

		/* Oculta elementos de datatable */
		.dataTables_filter,
		.dataTables_length,
		.dataTables_info,
		.dataTables_paginate {
			display: none;
		}
	}
</style>