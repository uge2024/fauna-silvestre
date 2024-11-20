<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>luciaticona </title>
  <style>
    /* Estilo para el encabezado */
    /* Estilo para el encabezado */
    /* Estilo para el encabezado */
    .navbar-nav {
      background-color: #3de0de;
      /* Un color más brillante */
      border-bottom: 4px solid #72fcfa;
      /* Borde más grueso y claro */
      width: 100%;
      /* Asegura que el fondo cubra toda la fila */
      display: flex;
      /* Asegura que los elementos dentro estén alineados en fila */
      justify-content: space-between;
      /* Distribuye los elementos uniformemente */
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
      /* Luz sombreada */
    }

    .navbar-nav .nav-link {
      color: #333;
      /* Color del texto */
    }

    .navbar-nav .nav-link:hover {
      color: #007bff;
      /* Color del texto al pasar el mouse */
    }


    /* Estilo para el menú */
    .main-sidebar {
      background-color: #1a1a1a;
      /* Fondo aún más oscuro */
      color: #ffffff;
      /* Texto claro para mayor contraste */
    }

    .main-sidebar .nav-link {
      color: #f8f9fa;
      /* Texto claro para los enlaces */
    }

    .main-sidebar .nav-link.active {
      background-color: #343a40;
      /* Fondo ligeramente más claro para el enlace activo */
      color: #ffffff;
      /* Texto blanco para el enlace activo */
    }

    .main-sidebar .brand-link {
      background-color: #2c2c2c;
      /* Fondo oscuro para el logotipo */
      color: #f8f9fa;
      /* Texto claro para el logotipo */
    }

    .main-sidebar .nav-icon {
      color: #f8f9fa;
      /* Color de los iconos */
    }

    .main-sidebar .nav-treeview>.nav-item>.nav-link {
      background-color: #2c2c2c;
      /* Fondo oscuro para submenús */
      color: #f8f9fa;
      /* Texto claro para submenús */
    }

    .main-sidebar .nav-treeview>.nav-item>.nav-link:hover {
      background-color: #3a3a3a;
      /* Fondo más claro al pasar el ratón por submenús */
    }
  </style>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="{{ asset('imagenes/images.jpg') }}" alt="images" height="60" width="60">
    </div>

    <!-- Navbar -->
    <!-- Right navbar links -->


    <nav class="main-header navbar navbar-expand navbar-white navbar-light">

      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="home.blade" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="#" class="nav-link">Contact</a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">

        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-comments"></i>
            <span class="badge badge-danger navbar-badge">3</span>
          </a>
        </li>

        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            <span class="badge badge-warning navbar-badge">15</span>
          </a>
        </li>

        <li>
          <a class="btn btn-danger text-white" href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="icon-mid bi bi-box-arrow-left me-2"></i>Salir
          </a>
        </li>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
          @csrf
        </form>



        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="index3.html" class="brand-link">
        <img src="{{ asset('imagenes/images (1).jpg') }}" alt="images (1)" class="brand-image img-circle elevation-4" style="opacity: 1; width: 70px; height: 70px;">

        <span class="brand-text font-weight-light">FAUNA SILVESTRE</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item menu-open">
              <a href="{{ route('home')}}" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
              </ul>
            </li>

            <!-- Solo administradores -->
            @if(auth()->user() && auth()->user()->hasRole('admin'))
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-copy"></i>
                <p>
                  Usuarios
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('usuario.index')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Usuarios</p>
                  </a>
                </li>


              </ul>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-copy"></i>
                <p>
                  Instituciones
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('municipio.index')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Municipios</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('institucion.index')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Instituciones</p>
                  </a>
                </li>

              </ul>
            </li>
            @endif
            <!-- FIN Solo administradores -->


            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-chart-pie"></i>
                <p>
                  Registros
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('recepcion.index')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Recepcion</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('nacimiento.index')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Nacimientos</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('fuga.index')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Fugas</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('deceso.index')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Decesos</p>
                  </a>
                </li>

              </ul>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-edit"></i>
                <p>
                  Informeclinica
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('informeclinico.index')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>fichaclinica</p>
                  </a>
                </li>

              </ul>
            </li>
            <li class="nav-item">
              <a href="" class="nav-link">
                <i class="nav-icon fas fa-tree"></i>
                <p>
                  Derivaciones
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('transferencia.index')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>TransferenciaS</p>
                  </a>
                </li>

              </ul>
            </li>


            <li class="nav-item">
              <a href="" class="nav-link">
                <i class="nav-icon fas fa-tree"></i>
                <p>
                  Reportes
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('reporte.index')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Flujo Poblacional</p>
                  </a>
                </li>

              </ul>
            </li>

   



          </ul>
          </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          @yield('contenido')
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
      <strong>Copyright &copy; 2024 <a href="https://ticsacorporativo.com/">registroanimals</a>.</strong>
      All rights reserved.
      <div class="float-right d-none d-sm-inline-block">

      </div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- ChartJS -->
  <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
  <!-- Sparkline -->
  <script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
  <!-- JQVMap -->
  <script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
  <script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
  <!-- jQuery Knob Chart -->
  <script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
  <!-- daterangepicker -->
  <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
  <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
  <!-- Summernote -->
  <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
  <!-- overlayScrollbars -->
  <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('dist/js/adminlte.js') }}"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="{{ asset('dist/js/demo.js') }}"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>
</body>

</html>