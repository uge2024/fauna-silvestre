@extends('layouts.admin')

@section('contenido')
<div class="video-background">
    <video autoplay muted loop 
       style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; z-index: -1;">
    <source src="https://cdn.pixabay.com/video/2019/02/14/21375-317320786_large.mp4 " type="video/mp4">
    Tu navegador no soporta el video.
    </video>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header text-center">{{ __('') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <header>
                            <h1>SISTEMA DE REGISTRO Y CONTROL DE FAUNA SILVESTRE</h1>
                        </header>

                        <p class="welcome-msg">Bienvenido, {{ Auth::user()->name }}!</p>

                        <!-- Descripción general del sistema -->
                        <div class="section">
                            <!-- Agrega contenido aquí si es necesario -->
                        </div>

                        <!-- Sección de módulos -->
                        <div class="section">
                           
                            <div class="modules">
                                <div class="module-card">
                                    <h3>Registros</h3>
                                    <ul>
                                        <li>Recepciones: Gestión de la recepción de fauna.</li>
                                        <li>Nacimientos: Registro de los nacimientos de fauna.</li>
                                        <li>Fugas: Control y seguimiento de fugas de fauna.</li>
                                        <li>Decesos: Registro y gestión de decesos.</li>
                                    </ul>
                                </div>
                                <div class="module-card">
                                    <h3>Derivaciones</h3>
                                    <p>Administra las transferencias de fauna entre diferentes entidades.</p>
                                </div>
                                <div class="module-card">
                                    <h3>Informe Clínica</h3>
                                    <p>Genera informes clínicos detallados sobre la salud de los animales registrados.</p>
                                </div>
                                
                            </div>
                        </div>

                        <!-- Información adicional -->
                        <!-- Agrega contenido aquí si es necesario -->

                        <!-- Imagen de estadísticas -->
                        
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body, html {
        height: 100%;
        margin: 0;
    }

    .video-background {
        position: relative;
        height: 100%;
        width: 100%;
        overflow: hidden;
    }

    .container-fluid {
        position: relative;
        z-index: 1; /* Asegura que el contenido esté sobre el video */
        padding: 20px;
        background-color: transparent; /* Fondo transparente para que el video sea visible */
    }

    .card {
        border: none;
        box-shadow: none;
        background-color: transparent;
    }

    header {
        background-color: black; /* Fondo del cuadro en rojo */
        padding: 20px;
        text-align: center;
        color: white; /* Texto en blanco */
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
        font-family: 'Arial', sans-serif;
        font-size: 2.2em;
    }

    .welcome-msg {
        font-size: 2em;
        margin-bottom: 30px;
        color: #333;
        text-align: center;
        font-family: 'Arial', sans-serif;
    }

    .section {
        margin-bottom: 60px;
    }

    .text-content {
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .text-content h2 {
        font-size: 1.8em;
        color: #3f51b5;
        margin-bottom: 15px;
        font-family: 'Arial', sans-serif;
    }

    .text-content p {
        font-size: 1.2em;
        line-height: 1.6;
        color: #555;
    }

    .dashboard-img {
        width: 100%;
        max-width: 100%;
        height: auto;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .large-dashboard-img {
        width: 100%;
        height: auto;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .logout {
        margin-top: 50px;
        text-align: center;
    }

    .logout a {
        background-color: #f44336;
        color: white;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 5px;
        font-size: 1.1em;
    }

    .logout a:hover {
        background-color: #e53935;
    }

    nav {
        z-index: 10; /* Asegura que el menú esté sobre el video */
    }

    .modules {
        display: flex;
        flex-wrap: wrap;
        gap: 20px; /* Espacio entre tarjetas */
        justify-content: space-around; /* Distribuye el espacio entre las tarjetas */
    }

    .module-card {
        background-color: #f4f4f4;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
        flex: 1 1 calc(33.333% - 40px); /* Flexibilidad en el ancho */
        box-sizing: border-box;
        margin-bottom: 20px;
        min-width: 280px; /* Asegura que las tarjetas no sean demasiado pequeñas */
    }

    @media (max-width: 768px) {
        .module-card {
            flex: 1 1 calc(50% - 20px); /* Ajusta el ancho en pantallas pequeñas */
        }
    }

    @media (max-width: 480px) {
        .module-card {
            flex: 1 1 100%; /* Una tarjeta por fila en pantallas muy pequeñas */
        }
    }
</style>
@endsection
