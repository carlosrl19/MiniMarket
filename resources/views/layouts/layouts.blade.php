<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ACAI</title>
    <!-- FAVICONS ICON -->
	<link rel="shortcut icon" type="image/ico" href="{{ asset('images/resources/logo.ico') }}">
    
    <!-- CSS Fontawesome -->
    <link href="{{ asset('admin/fontawesome/css/all.min.css') }}" rel="stylesheet">

    <!-- Datatable -->
	<link href="{{ asset('vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
	<link href="{{ asset('vendor/datatables/css/buttons.dataTables.min.css') }}" rel="stylesheet">

    <!-- CSS de Mejoras visuales -->
    <link href="{{ asset('css/card.css') }}" rel="stylesheet">

    <!-- CSS SB Admin -->
    <link href="{{ asset('admin/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- CSS Bootstrap 5.2 -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    @yield('head')

    @livewireStyles
</head>

<body id="page-top">
@livewireScripts

<!-- Page Wrapper -->
<div id="wrapper">
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center">
            <div class="sidebar-brand-icon">
                <img src="{{ asset('images/resources/sidebar_logo.png') }}" width="60px" height="60px">
            </div>
            <div class="sidebar-brand-text mx-3">Minimarket ACAI</div>
        </a>

        @can('dashboard')
        <!-- Divider -->
        <hr class="sidebar-divider bg-white" style="margin-top: 1rem">

        <!-- Heading -->
        <div class="sidebar-heading">
            Dashboard
        </div>

        <!-- Nav Item - Ventas -->
        <li class="nav-item">
            <a class="nav-link text-white" href="/">
                <i class="fas fa-fw fa-tachometer-alt text-white"></i>
            <span>Dashboard</span></a>
        </li>
        @endcan

        @can('sidebar_products')
        <!-- Divider -->
        <hr class="sidebar-divider bg-white" style="margin-top: 1rem">

        <!-- Heading -->
        <div class="sidebar-heading">
            MODULO DE PRODUCTOS
        </div>

        <!-- Nav Item - Productos -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
               aria-expanded="true" aria-controls="collapseTwo">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box2-heart-fill" viewBox="0 0 16 16">
                    <path d="M3.75 0a1 1 0 0 0-.8.4L.1 4.2a.5.5 0 0 0-.1.3V15a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V4.5a.5.5 0 0 0-.1-.3L13.05.4a1 1 0 0 0-.8-.4h-8.5ZM8.5 4h6l.5.667V5H1v-.333L1.5 4h6V1h1v3ZM8 7.993c1.664-1.711 5.825 1.283 0 5.132-5.825-3.85-1.664-6.843 0-5.132Z"/>
                </svg>
                <span class="text-white">Productos</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{route('productos.index')}}">Lista de productos</a>
                    <a class="collapse-item" href="{{ route('inventario.index') }}">Lista de inventario</a>
                    <a class="collapse-item" href="{{route('categorias.index')}}">Lista de categorias</a>
                </div>
            </div>
        </li>
        @endcan

        @can('sidebar_purchase')
        <!-- Nav Item - Compras -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFourSix"
               aria-expanded="true" aria-controls="collapseFourSix">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-handbag-fill" viewBox="0 0 16 16">
                    <path d="M8 1a2 2 0 0 0-2 2v2H5V3a3 3 0 1 1 6 0v2h-1V3a2 2 0 0 0-2-2zM5 5H3.36a1.5 1.5 0 0 0-1.483 1.277L.85 13.13A2.5 2.5 0 0 0 3.322 16h9.355a2.5 2.5 0 0 0 2.473-2.87l-1.028-6.853A1.5 1.5 0 0 0 12.64 5H11v1.5a.5.5 0 0 1-1 0V5H6v1.5a.5.5 0 0 1-1 0V5z"/>
                </svg>
                <span class="text-white">Compras</span>
            </a>
            <div id="collapseFourSix" class="collapse" aria-labelledby="headingFourSix" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('proveedor.index') }}">Lista de proveedores</a>
                    <a class="collapse-item" href="{{ route('compras.index') }}">Registro de compras</a>
                </div>
            </div>
        </li>
        @endcan

        <!-- Divider -->
        <hr class="sidebar-divider bg-white" style="margin-top: 1rem">

        <!-- Heading -->
        <div class="sidebar-heading">
            MODULO DE VENTAS
        </div>

        @can('sidebar_sales')
        <!-- Nav Item - Ventas -->
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('ventas.index') }}">
                <i class="fas fa-fw fa-chart-bar text-white"></i>
            <span>Registro de ventas</span></a>
        </li>
        @endcan

        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('ventas.create') }}">
                <i class="fas fa-fw fa-laptop text-white"></i>
            <span>Facturar</span></a>
        </li>

        @can('sidebar_users')
        <hr class="sidebar-divider bg-white" style="margin-top: 1rem">

        <div class="sidebar-heading">
            MODULO USUARIOS
        </div>

        <li class="nav-item">
            <a class="nav-link text-white" href="{{route('usuarios.index')}}">
                <i class="fas fa-fw fa-users text-white"></i>
            <span>Usuarios</span></a>
        </li>
        @endcan
    </ul>

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
                    <i class="fa fa-bars text-primary"></i>
                </button>

                @yield('sidebarToggle')

                <div style="margin-top: auto;">
                    @yield('breadcrumb')
                </div>

                <ul class="navbar-nav ml-auto">
                    <div style="margin: auto;">@yield('create')</div>
                
                    <div class="topbar-divider d-none d-sm-block"></div>

                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small" style="font-size: clamp(0.6rem, 3.2vw, 0.8rem);">{{ Auth::user()->name }}</span>
                            <img class="img-profile rounded-circle" style="object-fit: cover" src="/images/uploads/{{ Auth::user()->image }}" alt="Profile">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas text-danger fa-sign-out-alt fa-sm fa-fw mr-2"></i>
                                Cerrar sesión
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>

            <!-- Begin Page Content -->
            <div class="container-fluid">
                <div style="overflow: auto">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header" style="font-size: clamp(0.8rem, 6vw, 1rem); background: #4e73df; color: white;">
                <p class="modal-title" id="exampleModalLabel">¿Listo para salir?</p>
            </div>
            <div class="modal-body" style="font-size: clamp(0.7rem, 6vw, 0.82rem);">Seleccione "Cerrar sesión" a continuación si está listo para finalizar su sesión actual.</div>
            <div class="modal-footer" style="font-size: clamp(0.7rem, 6vw, 1rem);">
                <button class="btn btn-sm btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-sm btn-danger" type="submit">
                        {{ __('Cerrar sesión') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src={{ asset("admin/jquery/jquery.min.js") }}></script>
<script src={{ asset("admin/bootstrap/js/bootstrap.bundle.min.js") }}></script>

<!-- Sidebar toggle script -->
<script src={{ asset("admin/js/sb-admin-2.min.js") }}></script>

@stack('scripts')
</body>

</html>
