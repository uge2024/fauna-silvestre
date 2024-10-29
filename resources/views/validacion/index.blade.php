@extends('layouts.admin')

@section('contenido')
    <div class="container">
        <header>
            <h1>Sistema de Registro y Control de Fauna Silvestre</h1>
        </header>

        <p class="welcome-msg">Bienvenido, {{ Auth::user()->name }}!</p>

        <div class="section">
            <h2>Control de Especies</h2>
            <p>Gestiona el registro y control de especies en sus hábitats naturales.</p>
            <img src="https://example.com/images/wildlife-control.jpg" alt="Control de Especies" class="dashboard-img">
        </div>

        <div class="section">
            <h2>Monitoreo de Hábitats</h2>
            <p>Monitorea las áreas protegidas y los hábitats de especies en peligro.</p>
            <img src="https://example.com/images/habitat-monitoring.jpg" alt="Monitoreo de Hábitats" class="dashboard-img">
        </div>

        <div class="section">
            <h2>Reportes y Estadísticas</h2>
            <p>Accede a reportes detallados y estadísticas sobre la fauna silvestre.</p>
            <img src="https://example.com/images/reports-statistics.jpg" alt="Reportes y Estadísticas" class="dashboard-img">
        </div>

        <div class="logout">
            <a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Cerrar sesión
            </a>

            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>

    <style>
        /* Estilos específicos para el Dashboard */
        header {
            background-color: #4CAF50;
            padding: 20px;
            text-align: center;
            color: white;
        }
        .container {
            padding: 20px;
            background-color: #f4f4f4;
            border-radius: 10px;
            margin-top: 20px;
        }
        .welcome-msg {
            font-size: 1.2em;
            margin-bottom: 20px;
        }
        .section {
            margin-bottom: 40px;
        }
        .section img.dashboard-img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }
        .logout {
            margin-top: 20px;
            text-align: center;
        }
        .logout a {
            background-color: #f44336;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }
        .logout a:hover {
            background-color: #e53935;
        }
    </style>
@endsection
