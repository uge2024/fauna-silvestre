<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BIENVENIDOS - Fauna Silvestre</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: url("{{ asset('imagenes/ti.jpeg') }}") no-repeat center center fixed;
            background-size: cover;
            color: #fff;
            text-align: center;
            padding: 50px;
            margin: 0;
        }

        .container {
            margin-top: 100px;
            background-color: rgba(0, 0, 0, 0.5);
            /* Fondo semitransparente */
            padding: 20px;
            border-radius: 10px;
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 20px;
        }

        h1 {
            font-family: 'Gothic A1', sans-serif;
            /* Fuente gótica */
            font-size: 48px;
            /* Tamaño de fuente más grande */
            font-weight: bold;
            /* Texto en negrita */
            color: #000;
            /* Color del texto, puedes cambiarlo si quieres */
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            /* Sombra de texto para mayor resaltado */
            border: 2px solid #333;
            /* Borde alrededor del texto */
            padding: 10px;
            /* Espaciado interno para que el borde no quede pegado al texto */
            background-color: #f0f0f0;
            /* Fondo opcional para resaltar el texto */
            display: inline-block;
            /* Asegura que el borde se ajuste al tamaño del texto */
        }

        .btn-custom {
            padding: 10px 20px;
            font-size: 1rem;
            color: #fff;
            background-color: #ff073a;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            margin: 5px;
            transition: background-color 0.3s, box-shadow 0.3s;
        }

        .btn-custom:hover {
            background-color: #d0042e;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        .btn-google {
            display: inline-flex;
            align-items: center;
            padding: 10px 20px;
            background-color: #4285F4;
            /* Azul de Google */
            color: white;
            border-radius: 4px;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            margin-top: 10px;
            transition: background-color 0.3s;
        }

        .btn-google:hover {
            background-color: #357ae8;
            /* Color azul más oscuro en hover */
        }

        .google-icon {
            width: 20px;
            height: 20px;
            margin-right: 10px;
        }

        .position-relative {
            position: relative;
            /* Hace que los elementos hijos con posición absoluta se posicionen dentro de este contenedor */
        }

        .button-container {
            position: absolute;
            /* Posiciona el contenedor de los botones de manera absoluta dentro del contenedor padre */
            top: 0;
            /* Coloca el contenedor en la parte superior del contenedor padre */
            right: 0;
            /* Coloca el contenedor en la parte derecha del contenedor padre */
            padding: 10px;
            /* Espaciado alrededor del contenedor de los botones */
            z-index: 1000;
            /* Asegura que el contenedor esté por encima de otros elementos */
        }

        .btn-custom {
            display: inline-block;
            /* Alinea los botones en línea */
            padding: 10px 20px;
            /* Tamaño del espaciado interno del botón */
            margin: 0 5px;
            /* Espaciado entre botones */
            background-color: #007bff;
            /* Color de fondo del botón */
            color: #fff;
            /* Color del texto del botón */
            text-decoration: none;
            /* Quita el subrayado del enlace */
            border-radius: 5px;
            /* Bordes redondeados del botón */
            font-size: 16px;
            /* Tamaño de la fuente del botón */
        }

        .btn-custom:hover {
            background-color: #0056b3;
            /* Color de fondo en hover */
        }


        .imagen-izquierda,
        .imagen-derecha {
            position: absolute;
            top: 0;
            /* Ajusta según sea necesario */
        }

        .imagen-izquierda {
            left: 0;
            /* Posiciona la imagen a la izquierda */
        }

        /* Estilos del contenedor */
        .container {
            position: relative;
            padding: 20px;
            text-align: center;
            /* Centra el texto dentro del contenedor */
        }

        /* Estilos del texto resaltante */
        .resaltante {
            color: #e0e0e0;
            /* Color del texto en un tono gris muy claro */
            font-family: 'Arial', sans-serif;
            /* Fuente de ejemplo, cámbiala según tu preferencia */
            font-weight: bold;
            /* Hacer el texto más grueso */
            font-size: 2.5em;
            /* Tamaño del texto, ajusta según sea necesario */
            text-shadow:
                0 0 5px #000000,
                /* Resplandor negro exterior */
                0 0 10px #000000,
                /* Resplandor negro más grande */
                0 0 15px #00aaff,
                /* Resplandor azul claro para destacar */
                0 0 20px #00aaff,
                /* Resplandor azul claro más grande */
                0 0 25px #00aaff,
                /* Resplandor azul claro aún más grande */
                0 0 30px #00aaff;
            /* Resplandor azul claro máximo */
            text-transform: uppercase;
            /* Convertir texto a mayúsculas para mayor impacto */
            letter-spacing: 3px;
            /* Espaciado entre letras para claridad */
            margin: 100px 0 20px 0;
            /* Espacio superior e inferior alrededor del texto; ajusta según sea necesario */
        }


        .container {
            margin-top: 190px;
            /* Incrementa este valor para mover más abajo el fondo semitransparente */

            padding: 20px;
            border-radius: 10px;
            position: relative;
            text-align: center;
            /* Centra el texto dentro del contenedor */
        }
    </style>
</head>

<body>

    <div class="container">

        <h1 class="resaltante">{{ config('', 'REGISTRO Y CONTROL DE FAUNA SILVESTRE DE GOBIERNO AUTONOMO DEPARTAMENTAL DE COCHABAMBA') }}</h1>
    </div>






    @guest
    <div class="button-container">
        <a href="{{ route('login') }}" class="btn-custom">Iniciar sesión</a>

    </div>
    @else
    <div class="mt-4">
        @if(Auth::user()->hasRole('admin'))
        <a href="{{ route('admin.dashboard') }}" ></a>
        @elseif(Auth::user()->hasRole('user'))
        <a href="{{ route('user.dashboard') }}" ></a>
        @endif
        <a href="{{ route('logout') }}" class="btn-custom"
            onclick="event.preventDefault();
                   document.getElementById('logout-form').submit();">Salir </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
    @endguest
    </div>


</body>

</html>