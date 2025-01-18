<body>
    <div id="page_pdf">
    <table id="factura_head">
        <tr>
            <td class="info_empresa">
                <div>
                    <span class="h2"><strong>{{ config('app.name') }}</strong></span>
                    <p>Todo lo que necesites</p>
                    <p>Teléfono: +(504) 8965-2710</p>
                    <p>Ubicados entre 13 y 14 calle SO, esquina opuesta a Planet Fitness Gym.</p>
                </div>
            </td>
            <td class="info_factura">
                <div class="round">
                    <span class="h3">Compras - cierre de caja mensual</span>
                    <?php
                    $meses = array(
                        "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
                        "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
                    );
                    ?>
                    <p><strong>Mes:</strong> <?php echo $meses[$mesSeleccionado - 1]; ?> - {{ \Carbon\Carbon::now()->format('Y') }}</p>
                    <p><strong>Fecha actual:</strong> {{ \Carbon\Carbon::now()->format('d-m-Y') }}</p>
                    <p><strong>Hora actual:</strong> {{ \Carbon\Carbon::now()->format('h:i A') }}</p>
                    <br>
                </div>
            </td>
        </tr>
    </table>
    <table class="display table table-striped" style="width: 100%">
        <thead style="font-size: 0.7rem; color: #fff; background-color: #2C7865;">
            <tr>
                <th class="textcenter">Nº</th>
                <th class="textcenter">Fecha Hora</th>
                <th class="textcenter">Producto</th>
                <th class="textcenter">Cantidad</th>
                <th class="textright" width="70px">Precio</th>
                <th class="textright" width="90px">Subtotal</th>
            </tr>
        </thead>
        <tbody id="detalle_productos" style="font-size: clamp(0.5rem, 3vw, 0.80rem);">
            @php
                $total=0;
            @endphp
            @if(count($compras) > 0)
                @foreach ($compras as $i => $compra)
                    @foreach ($compra->detalle_compra as $detalle)
                        <tr>
                            <td class="textcenter">{{++$i}}</td>
                            <td class="textcenter">{{ $compra->created_at->format('d-m-Y h:i:s A') }}</td>
                            <td class="textcenter">{{ $detalle->producto->modelo }}</td>
                            <td class="textcenter">{{ $detalle->cantidad_detalle_compra }}</td>
                            <td class="textright">{{ number_format($detalle->precio, 2, ".", ",") }}</td>
                            <td class="textright">{{ number_format($detalle->precio * $detalle->cantidad_detalle_compra, 2, ".", ",") }}</td>
                        </tr>
                        @php
                            $total+=$detalle->precio*$detalle->cantidad_detalle_compra;
                        @endphp
                    @endforeach
                @endforeach
            @else
            <tr>
                <td colspan="5" class="textcenter" style="text-decoration: underline">No existen ventas registradas este mes para ser mostradas.</td>
            </tr>
            @endif
        </tbody>
        <tfoot id="detalle_totales">
            <tr>
                <th colspan="5" class="textright"><h3>Total</h3></th>
                <th colspan="1" class="textright"><h3>L. {{ number_format($total, 2, ".", ",") }}</h3></th>
            </tr>
        </tfoot>
    </table>
</div>

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
	background: #2C7865;
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
	border: 1px solid #2C7865;
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
            font-size: 14pt;
        }
    }
</style>
</body>