@extends('layouts.layouts')
@section('content')
    <!-- Custom fonts for this template -->
    <div class="container-fluid">
        <div class="alert alert-info">
            <p>En este apartado se mostrará información sobre los ingresos (<i class="text-success fas fa-arrow-up"></i>) y egresos (<i class="text-danger fas fa-arrow-down"></i>)  del Minimarket ACAI, así como el total monetario de ventas del día, semana y mes actual, junto al empleado que realizó dichas ventas.</p>
        </div>
        <!-- Content Row -->
        <div class="row">
            <!-- Ingresos anuales -->
            <div class="col-xl-4 col-md-5 mb-4">
                <div class="card border-left-info shadow h-100 py-2"  style="padding: 10px">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Ingresos (Anual)</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">L. {{ number_format($ingresos, 2, ".", ",") }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-arrow-circle-up fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Egresos -->
            <div class="col-xl-4 col-md-5 mb-4">
                <div class="card border-left-danger shadow h-100 py-2"  style="padding: 10px">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Egresos (Anual)</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">L. {{ number_format($egresos, 2, ".", ",") }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-arrow-circle-down fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ganancia -->
            <div class="col-xl-4 col-md-5 mb-4">
                <div class="card border-left-success shadow h-100 py-2"  style="padding: 10px">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Margen de Ganancia (Anual)
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    @if($ingresos - $egresos < 0 )
                                        <span class="text-danger">L. {{ number_format($ingresos - $egresos, 2, ".", ",") }}</span>
                                    @else
                                        <span class="text-success">L. {{ number_format($ingresos - $egresos, 2, ".", ",") }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-8 mb-4">
                <!-- Chart content -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <canvas id="myChart" height="390px"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <!-- Month sales -->
                <div class="card shadow mb-4">
                    <div class="card-header" style="background: #4e73df; color: white">
                        <h6 class="m-0 font-weight-bold">Ventas del mes ({{ Carbon\Carbon::now()->locale('es')->monthName }})</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" id="tblaBody">
                            <table class="table" id="dataTable">
                                <tbody style="font-size: 0.85rem">
                                @if(count($vendedores) > 0)
                                    @foreach ($vendedores as $vende)
                                        <tr>
                                            <td>{{ $vende->name }}</td>
                                            <td>L. {{ number_format($vende->total, 2, ".", ",") }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <p style="font-size: 0.85rem">Sin ventas registradas en el mes.<p>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Week sales -->
                <div class="card shadow mb-4">
                    <div class="card-header" style="background: #FB6D48; color: white">
                        <h6 class="m-0 font-weight-bold">Ventas de la semana</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" id="tblaBody">
                            <table class="table" id="dataTable">
                                <tbody style="font-size: 0.85rem">
                                @if(count($ventas_semana_actual) > 0)
                                    @foreach ($ventas_semana_actual as $venta)
                                    <tr>
                                        <td>{{ $venta->user->name }}</td>
                                        <td>L. {{ number_format($venta->total_semana_actual, 2, ".", ",") }}</td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <p style="font-size: 0.85rem">Sin ventas registradas en la semana.<p>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Day sales -->
                <div class="card shadow mb-4">
                    <div class="card-header" style="background: #6C757D; color: white">
                        <h6 class="m-0 font-weight-bold">Ventas del día ({{ \Carbon\Carbon::now()->format('d/m/Y') }})</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" id="tblaBody">
                            <table class="table" id="dataTable">
                                <tbody style="font-size: 0.85rem">
                                @if(count($ventas_dia) > 0)
                                    @foreach ($ventas_dia as $venta)
                                        <tr>
                                            <td>{{ $venta->user->name }}</td>
                                            <td>L. {{ number_format($venta->total_dia, 2, ".", ",") }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <p style="font-size: 0.85rem">Sin ventas registradas en el día.<p>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push("scripts")

    <!-- High Charts js -->
    <script src={{ asset("js/highchar.js") }}></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let compras = @json($valores_compre);
        let ventas = @json($valores_ventas);

        const ctx = document.getElementById('myChart');

        const data = {
            labels: ['Ene',
                    'Feb',
                    'Mar',
                    'Abr',
                    'May',
                    'Jun',
                    'Jul',
                    'Ago',
                    'Sep',
                    'Oct',
                    'Nov',
                    'Dic'],
            datasets: [
                {
                    label: 'Ingresos',
                    data: [parseFloat(ventas[0].Total),parseFloat(ventas[1].Total),parseFloat(ventas[2].Total),
                    parseFloat(ventas[3].Total),parseFloat(ventas[4].Total),parseFloat(ventas[5].Total),
                    parseFloat(ventas[6].Total),parseFloat(ventas[7].Total),parseFloat(ventas[8].Total),
                    parseFloat(ventas[9].Total),parseFloat(ventas[10].Total),parseFloat(ventas[11].Total)],
                    borderColor: '#0DCAF0',
                    backgroundColor: 'rgba(12, 202, 240, 0.6)',
                    borderWidth: 2,
                    borderRadius: 1,
                    borderSkipped: false,
                },
                {
                    label: 'Egresos',
                    data: [parseFloat(compras[0].Total),parseFloat(compras[1].Total),parseFloat(compras[2].Total),
                    parseFloat(compras[3].Total),parseFloat(compras[4].Total),parseFloat(compras[5].Total),
                    parseFloat(compras[6].Total),parseFloat(compras[7].Total),parseFloat(compras[8].Total),
                    parseFloat(compras[9].Total),parseFloat(compras[10].Total),parseFloat(compras[11].Total)],
                    borderColor: '#DC3545',
                    backgroundColor:'rgba(220, 53, 69, 0.6)',
                    borderWidth: 2,
                    borderRadius: 1,
                    borderSkipped: false,
                },
                {
                    label: 'MG',
                    data: [ventas[0].Total - compras[0].Total,ventas[1].Total - compras[1].Total,
                    ventas[2].Total - compras[2].Total,ventas[3].Total - compras[3].Total,
                    ventas[4].Total - compras[4].Total,ventas[5].Total - compras[5].Total,
                    ventas[6].Total - compras[6].Total,ventas[7].Total - compras[7].Total,
                    ventas[8].Total - compras[8].Total,ventas[9].Total - compras[9].Total,
                    ventas[10].Total - compras[10].Total,ventas[11].Total - compras[11].Total],
                    borderColor: '#198754',
                    backgroundColor:'rgba(25, 135, 84, 0.6)',
                    borderWidth: 2,
                    borderRadius: 1,
                    borderSkipped: false,
                },
            ]
        };
        new Chart(ctx, {
            type: 'bar',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
            scales: {
                y: {
                beginAtZero: true
                }
            },
            }
        });
    </script>
@endpush
