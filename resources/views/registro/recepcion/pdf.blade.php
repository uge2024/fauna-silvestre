<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de Recepción</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size: 14px;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f9;
        }
        h1, h2 {
            text-align: center;
            color: #000;
        }
        h1 {
            font-size: 24px; /* Reducido el tamaño de la fuente del título */
            margin-bottom: 10px;
        }
        h2 {
            font-size: 22px;
            margin-bottom: 15px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            vertical-align: top;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        td.long-text {
            word-wrap: break-word;
            max-width: 250px;
        }
        .highlight {
            background-color: #d4edda;
            font-weight: bold;
            color: #155724;
        }
        .field-label {
            font-weight: bold;
            color: #092add;
        }
        .text-center {
            text-align: center;
        }
        .header {
            position: relative;
            text-align: center;
            margin-bottom: 15px; /* Reducido el margen inferior */
            padding: 10px 20px; /* Menos padding */
            background-color: #f1f1f1;
            border-bottom: 2px solid #0056b3;
        }
        .header img {
            position: absolute;
            height: 60px; /* Reducido el tamaño de las imágenes */
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
        img {
            max-width: 100%;
            height: auto;
            border-radius: 4px;
            margin-top: 10px;
        }
    </style>
</head>
<body>

    <header class="header">
        <!-- Imagen en la esquina superior izquierda -->
        <img src="{{ public_path('imagenes/escudo.jfif') }}" alt="Escudo de la Gobernación" class="top-left">
        <!-- Imagen en la esquina superior derecha -->
        <img src="{{ public_path('imagenes/cocha.jfif') }}" alt="Cocha" class="top-right">
        <!-- Título centrado -->
        <h1>GOBERNACIÓN DE COCHABAMBA</h1>
    </header>

    <h2>Formulario Único de Registro de Fauna Silvestre</h2>

    <div class="container">
        <table>
            <!-- Fila 1 -->
            <tr>
                <td class="field-label">Código Asignado:</td>
                <td>{{ $codigo_animal }}</td>
                <td class="field-label">Especie:</td>
                <td>{{ $especie }}</td>
                <td class="field-label">Nombre Común:</td>
                <td>{{ $nombre }}</td>
            </tr>

            <!-- Fila 2 -->
            <tr>
                <td class="field-label">Color:</td>
                <td>{{ $color }}</td>
                <td class="field-label">Estado General:</td>
                <td>{{ $estado }}</td>
                <td class="field-label">Sospecha de Enfermedad:</td>
                <td>{{ $sospech_enfermedad }}</td>
            </tr>

            <!-- Fila 3 -->
            <tr>
                <td class="field-label">Alteraciones o Heridas:</td>
                <td colspan="2">{{ $alteraciones_heridas }}</td>
                <td class="field-label">Observaciones:</td>
                <td colspan="2">{{ $observaciones }}</td>
            </tr>

            <!-- Fila 4 -->
            <tr>
                <td class="field-label">Medicación:</td>
                <td colspan="2">{{ $medicacion }}</td>
                <td class="field-label">Alimentación:</td>
                <td colspan="2">{{ $alimentacion }}</td>
            </tr>

            <!-- Fila 5 - Motivo de Recepción -->
            <tr>
                <td class="field-label">Motivo de Recepción:</td>
                <td class="{{ $motivo_recepcion == 'Rescate' ? 'highlight' : '' }}">Rescate</td>
                <td class="{{ $motivo_recepcion == 'Confiscación' ? 'highlight' : '' }}">Confiscación</td>
                <td class="{{ $motivo_recepcion == 'Entrega Voluntaria' ? 'highlight' : '' }}">Entrega Voluntaria</td>
                <td class="{{ $motivo_recepcion == 'Traslado' ? 'highlight' : '' }}">Traslado</td>
                <td class="{{ $motivo_recepcion == 'Otro' ? 'highlight' : '' }}">Otro</td>
            </tr>

            <!-- Fila 6 - Clase -->
            <tr>
                <td class="field-label">Clase:</td>
                <td class="{{ $clase == 'Mamífero' ? 'highlight' : '' }}">Mamífero</td>
                <td class="{{ $clase == 'Ave' ? 'highlight' : '' }}">Ave</td>
                <td class="{{ $clase == 'Reptil' ? 'highlight' : '' }}">Reptil</td>
                <td class="{{ $clase == 'Anfibio' ? 'highlight' : '' }}">Anfibio</td>
                <td class="{{ $clase == 'Pez' ? 'highlight' : '' }}">Pez</td>
            </tr>

            <!-- Fila 7 - Edad -->
            <tr>
                <td class="field-label">Edad:</td>
                <td class="{{ $edad == 'Neonato' ? 'highlight' : '' }}">Neonato</td>
                <td class="{{ $edad == 'Juvenil' ? 'highlight' : '' }}">Juvenil</td>
                <td class="{{ $edad == 'Adulto' ? 'highlight' : '' }}">Adulto</td>
                <td class="{{ $edad == 'Anciano' ? 'highlight' : '' }}">Anciano</td>
                <td></td>
            </tr>

            <!-- Fila 8 - Sexo -->
            <tr>
                <td class="field-label">Sexo:</td>
                <td class="{{ $sexo == 'Macho' ? 'highlight' : '' }}">Macho</td>
                <td class="{{ $sexo == 'Hembra' ? 'highlight' : '' }}">Hembra</td>
                <td class="{{ $sexo == 'Desconocido' ? 'highlight' : '' }}">Desconocido</td>
                <td></td>
                <td></td>
            </tr>

            <!-- Fila 9 - Contacto con Otros Animales -->
            <tr>
                <td class="field-label">Contacto con Otros Animales:</td>
                @foreach (['Perros', 'Gatos', 'Aves de Traspatio', 'Equinos', 'Animales Introducidos (Exóticos)'] as $opcion)
                    <td class="{{ in_array($opcion, $contacto_animales) ? 'highlight' : '' }}">{{ $opcion }}</td>
                @endforeach
            </tr>
        </table>

        @if ($fotografia)
        <div class="form-group text-center">
            <label class="field-label">Fotografía:</label>
            <img src="{{ public_path('imagenes/recepcion/'.$fotografia) }}" alt="Fotografía del Animal">
        </div>
        @endif
    </div>
</body>
</html>
