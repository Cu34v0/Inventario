<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Panel de Administración</title>
    <link href="<?php echo base_url; ?>Assets/css/style.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo base_url; ?>Assets/css/jquery.dataTables.min.css">
    <link href="<?php echo base_url; ?>Assets/css/styles.css" rel="stylesheet" />
    <script src="<?php echo base_url; ?>Assets/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="<?php echo base_url ?>Usuarios"><i class="fas fa-boxes mx-2"></i>Sistema de Admin</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0 mx-4" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>

        <!-- Navbar-->
        <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="<?php echo base_url; ?>CambioPass">Cambio de Contraseña</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="<?php echo base_url; ?>Usuarios/salir">Cerrar Sesión</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">

                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-tools text-primary"></i></div>
                            Configuración
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="<?php echo base_url; ?>Usuarios"><i class="fas fa-user mx-2 text-primary"></i>Usuarios</a>
                                <a class="nav-link" href="<?php echo base_url; ?>Estaciones"><i class="fas fa-laptop mx-2 text-primary"></i>Estaciones</a>
                                <a class="nav-link" href="<?php echo base_url; ?>Medidas"><i class="fas fa-ruler-horizontal mx-2 text-primary"></i>Medidas</a>
                            </nav>
                        </div>

                        <a class="nav-link" href="<?php echo base_url; ?>Almacenes">
                            <div class="sb-nav-link-icon"><i class="fas fa-pallet text-primary"></i></div>
                            Almacenes
                        </a>

                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts3" aria-expanded="false" aria-controls="collapseLayouts2">
                            <div class="sb-nav-link-icon"><i class="fas fa-parachute-box text-primary"></i></div>
                            Proveedores
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts3" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="<?php echo base_url; ?>Proveedores"><i class="fas fa-clipboard mx-2 text-primary"></i>Agregar</a>
                                <a class="nav-link" href="<?php echo base_url; ?>Calendarizacion"><i class="fas fa-calendar-alt mx-2 text-primary"></i>Calendarización</a>            
                            </nav>
                        </div>                       

                        <a class="nav-link" href="<?php echo base_url; ?>Clientes">
                            <div class="sb-nav-link-icon"><i class="fas fa-users text-primary"></i></div>
                            Clientes
                        </a>

                        <a class="nav-link" href="<?php echo base_url; ?>Existencias">
                            <div class="sb-nav-link-icon"><i class="fas fa-clipboard-list text-primary"></i></div>
                            Existencias
                        </a>

                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts2" aria-expanded="false" aria-controls="collapseLayouts2">
                            <div class="sb-nav-link-icon"><i class="fas fa-cash-register text-primary"></i></div>
                            Ventas
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts2" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="<?php echo base_url; ?>Venta"><i class="fas fa-dollar-sign mx-2 text-primary"></i>Nueva</a>
                                <a class="nav-link" href="<?php echo base_url; ?>HistorialVentas"><i class="fas fa-clock mx-2 text-primary"></i>Historial</a>
                                <a class="nav-link" href="<?php echo base_url; ?>CalendarioVentas"><i class="fas fa-calendar-alt mx-2 text-primary"></i>Calendarización</a>
                            </nav>
                        </div>

                        <a class="nav-link" href="<?php echo base_url; ?>Inventario">
                            <div class="sb-nav-link-icon"><i class="fas fa-folder text-primary"></i></div>
                            Inventario
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Bienvenido:</div>
                    <?php echo $_SESSION['usuario']; ?>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid mt-2">