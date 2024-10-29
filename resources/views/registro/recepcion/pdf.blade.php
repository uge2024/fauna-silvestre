<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalles de Recepción</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 10px;
            font-size: 14px;
            line-height: 1.6;
            color: #333;
        }
        h1 {
            font-size: 25px;
            color: #000000;
            text-align: center;
            margin-bottom: 20px;
        }
        h2 {
            font-size: 20px;
            color: #000000;
            text-align
            margin-bottom: 15px;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #f2f2f2;
        }
        .field-label {
            font-weight: bold;
            color: #092add; /* Rojo brillante */
        }
        .highlight {
            background-color: #d4edda; /* Verde claro */
            font-weight: bold; /* Negrita */
            color: #155724; /* Verde oscuro para el texto */
        }
        .text-center {
            text-align: center;
        }
        img {
            max-width: 100%;
            height: auto;
            border-radius: 4px;
            margin-top: 10px;
        }
        .header {
            position: relative;
            text-align: center;
            margin-bottom: 20px;
            padding: 20px;
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
            top: 15px;
            right: 15px;
        }
        .header img.bottom-left {
            bottom: 10px;
            left: 10px;
        }
        .header img.bottom-right {
            bottom: 10px;
            right: 10px;
        }
    </style>
</head>
<body>
<div class="header">
    <img src="{{ public_path('imagenes/escudo.jfif') }}" alt="Escudo" class="top-left">
    <img src="{{ public_path('imagenes/cocha.jfif') }}" alt="cocha" class="top-right">
    <h1>GOBERNACIÓN DE COCHABAMBA</h1>
    
</div>
<h2>Formulario Único de Registro de Fauna Silvestre					
</h2>
<div class="container">
    <table>
        <tr>
            <td class="field-label" style="width: 15%;">Código Asignado:</td>
            <td style="width: 25%;">{{ $codigo_animal }}</td>
            <td class="field-label" style="width: 15%;">Especie</td>
            <td style="width: 25%;">{{ $especie }}</td>
            <td class="field-label" style="width: 20%;">Nombre Común</td>
            <td class="long-text">{{ $nombre }}</td>
        </tr>
        <tr>
            <td class="field-label" style="width: 15%;">Color</td>
            <td style="width: 25%;">{{ $color }}</td>
            <td class="field-label" style="width: 15%;">Estado_General</td>
            <td style="width: 25%;">{{ $estado }}</td>
            <td class="field-label" style="width: 20%;">Sospecha de Enfermedad</td>
            <td class="long-text">{{ $sospech_enfermedad }}</td>
        </tr>
        <tr>
            <td class="field-label" style="width: 10%;">Alteraciones o Heridas</td>
            <td class="long-text" colspan="2">{{ $alteraciones_heridas }}</td>
            <td class="field-label" style="width: 10%;">Observaciones</td>
            <td class="long-text" colspan="2">{{ $observaciones }}</td>
        </tr>
        <tr>
            <td class="field-label" style="width: 15%;">Medicación</td>
            <td colspan="2" class="long-text">{{ $medicacion }}</td>
            <td class="field-label" style="width: 15%;">Alimentación</td>
            <td colspan="2" class="long-text">{{ $alimentacion }}</td>
        </tr>
        <tr>
            <td class="field-label" style="width: 20%;">Motivo de Recepción</td>
            <td style="width: 10%;" class="{{ $motivo_recepcion == 'Rescate' ? 'highlight' : '' }}">Rescate</td>
            <td style="width: 10%;" class="{{ $motivo_recepcion == 'Confiscación' ? 'highlight' : '' }}">Confiscación</td>
            <td style="width: 10%;" class="{{ $motivo_recepcion == 'Entrega Voluntaria' ? 'highlight' : '' }}">Entrega Voluntaria</td>
            <td style="width: 10%;" class="{{ $motivo_recepcion == 'Traslado' ? 'highlight' : '' }}">Traslado</td>
            <td style="width: 10%;" class="{{ $motivo_recepcion == 'Otro' ? 'highlight' : '' }}">Otro</td>
        </tr>
        <tr>
            <td class="field-label" style="width: 20%;">Clase</td>
            <td style="width: 10%;" class="{{ $clase == 'Mamífero' ? 'highlight' : '' }}">Mamífero</td>
            <td style="width: 10%;" class="{{ $clase == 'Ave' ? 'highlight' : '' }}">Ave</td>
            <td style="width: 10%;" class="{{ $clase == 'Reptil' ? 'highlight' : '' }}">Reptil</td>
            <td style="width: 10%;" class="{{ $clase == 'Anfibio' ? 'highlight' : '' }}">Anfibio</td>
            <td style="width: 10%;" class="{{ $clase == 'Pez' ? 'highlight' : '' }}">Pez</td>
        </tr>
        <tr>
            <td class="field-label" style="width: 20%;">Edad</td>
            <td style="width: 10%;" class="{{ $edad == 'Neonato' ? 'highlight' : '' }}">Neonato</td>
            <td style="width: 10%;" class="{{ $edad == 'Juvenil' ? 'highlight' : '' }}">Juvenil</td>
            <td style="width: 10%;" class="{{ $edad == 'Adulto' ? 'highlight' : '' }}">Adulto</td>
            <td style="width: 10%;" class="{{ $edad == 'Anciano' ? 'highlight' : '' }}">Anciano</td>
            <td></td>
        </tr>
        <tr>
            <td class="field-label" style="width: 20%;">Sexo</td>
            <td style="width: 10%;" class="{{ $sexo == 'Macho' ? 'highlight' : '' }}">Macho</td>
            <td style="width: 10%;" class="{{ $sexo == 'Hembra' ? 'highlight' : '' }}">Hembra</td>
            <td style="width: 10%;" class="{{ $sexo == 'Desconocido' ? 'highlight' : '' }}">Desconocido</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="field-label" style="width: 20%;">Contacto con Otros Animales</td>
            @foreach (['Perros', 'Gatos', 'Aves de Traspatio', 'Equinos', 'Animales Introducidos (Exóticos)'] as $opcion)
                <td style="width: 10%;" class="{{ in_array($opcion, $contacto_animales) ? 'highlight' : '' }}">{{ $opcion }}</td>
            @endforeach
        </tr>
    </table>
    @if ($fotografia)
    <div class="form-group">
        <label class="field-label">Fotografía:</label>
        <div class="text-center">
            <img src="{{ public_path('imagenes/recepcion/'.$fotografia) }}" alt="Fotografía del Animal">
        </div>
    </div>
    @endif
</div>
</body>
</html>
