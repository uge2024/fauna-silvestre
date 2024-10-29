<!DOCTYPE html>
<html>
<head>
    <title>Informe Clínico</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0; /* Elimina márgenes del body */
            padding: 20px;
            line-height: 1.6;
            background-color: #f9f9f9;
        }
        h1 {
            text-align: center;
            color: #2c3e50;
            margin-top: 120px; /* Espacio adicional para evitar que el título tape las imágenes */
        }
        h2 {
            text-align: center;
            color: #2c3e50;
        }
        .header {
            position: relative;
            height: 120px; /* Ajusta la altura para dar espacio a las imágenes */
            background-color: #f1f1f1;
            border-bottom: 2px solid #0056b3;
        }
        .header img {
            position: absolute;
            height: 90px; /* Ajusta el tamaño según necesites */
            width: auto;
        }
        .header img.top-left {
            top: 10px;
            left: 10px;
        }
        .header img.top-right {
            top: 10px;
            right: 10px;
        }
        .content {
            margin-top: 20px;
        }
        .content p {
            text-align: justify;
            color: #555;
        }
        .animal-image img {
            max-width: 200px;
            max-height: 200px;
            display: block;
            margin: 20px auto;
            border: 1px solid #ddd;
            border-radius: 10px;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 12px;
            color: #888;
        }
        img {
            max-width: 100%;
            height: auto;
            border-radius: 4px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="header">
    <img src="{{ public_path('imagenes/escudobol.jfif') }}" alt="Escudo" class="top-left">
    <h1>GOBERNACIÓN DE COCHABAMBA</h1>
    <img src="{{ public_path('imagenes/cocha.jfif') }}" alt="Cocha" class="top-right">
    
</div>

<h2></h2>
<h2>{{ $informe->institucion->nombre ?? 'Institución Desconocida' }}</h2>

<div class="content">
    <p><strong>Fecha del Informe:</strong> {{ $informe->fecha }}</p>
    <p><strong>ID del Informe:</strong> {{ $informe->id_informeclinico }}</p>

    <p>
        El presente informe corresponde al animal identificado como 
        @if($informe->recepcion)
            <strong>{{ $informe->recepcion->nombre }}</strong>, el cual fue recibido en la institución mencionada. 
            @if($informe->recepcion->fotografia)
                La siguiente es una fotografía del animal en recepción:
            @endif
        @elseif($informe->nacimiento)
            <strong>{{ $informe->nacimiento->nombre }}</strong>, nacido en nuestras instalaciones. 
            @if($informe->nacimiento->fotografia)
                La siguiente es una fotografía del animal al momento de su nacimiento:
            @endif
        @else
            <strong>No disponible</strong>.
        @endif
    </p>

    <!-- Mostrar imagen del animal -->
    @if(optional($informe->recepcion)->fotografia)
        <div class="animal-image">
            <img src="{{ public_path('imagenes/recepcion/' . $informe->recepcion->fotografia) }}" alt="Fotografía del Animal Recepción">
        </div>
    @elseif(optional($informe->nacimiento)->fotografia)
        <div class="animal-image">
            <img src="{{ public_path('imagenes/nacimientos/' . $informe->nacimiento->fotografia) }}" alt="Fotografía del Animal Nacimiento">
        </div>
    @endif

    <p>
        Durante la evaluación clínica del animal, se ha determinado el siguiente anamnesis: 
        <strong>{{ $informe->anamnesis }}</strong>.
    </p>
    <p>
        Durante la evaluación clínica del animal, se ha determinado el siguiente diagnóstico: 
        <strong>{{ $informe->diagnostico }}</strong>.
    </p>

    <p>
        Se ha prescrito el siguiente tratamiento: <strong>{{ $informe->tratamiento }}</strong>.
    </p>

    <p>
        El programa sanitario que se está siguiendo en este caso es el siguiente: <strong>{{ $informe->programa_sanitario }}</strong>.
    </p>

    <p>
        El veterinario responsable del seguimiento de este caso es: <strong>{{ $informe->veterinario }}</strong>.
    </p>
</div>

</body>
</html>
