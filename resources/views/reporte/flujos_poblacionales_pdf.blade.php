<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Flujos Poblacionales - {{ $fechaInicio }} a {{ $fechaFin }}</title>
    <style>
        @page {
            size: letter landscape;
            margin: 10mm;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
        }

        .header {
            position: relative;
            text-align: center;
            margin-bottom: 30px;
            padding: 1px;
            background-color: #f1f1f1;
            border-bottom: 2px solid #0056b3;
        }

        .header img.top-left {
            position: absolute;
            top: 0;
            left: 0;
            width: 80px;
        }

        .header img.top-right {
            position: absolute;
            top: 0;
            right: 0;
            width: 80px;
        }

        h1 {
            font-size: 18px;
            margin: 0;
            line-height: 80px;
        }

        .content {
            text-align: center;
            margin-top: 20px;
        }

        .content h1 {
            font-size: 16px;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            font-size: 12px;
        }

        th {
            background-color: #007BFF;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .class-header {
            background-color: #007BFF;
            color: white;
            font-weight: bold;
            text-align: center;
        }

        .subtotal-header {
            background-color: #e9ecef;
            font-weight: bold;
        }

        .subtotal-row td {
            text-align: center;
        }

        .total-general {
            font-size: 18px;
            font-weight: bold;
            color: white;
            background-color: #28a745;
            padding: 10px;
            margin-top: 20px;
            text-align: center;
            border-radius: 5px;
        }

        .total-category {
            font-weight: bold;
            background-color: #ffc107;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('imagenes/escudo.jfif') }}" alt="Escudo" class="top-left">
        <img src="{{ public_path('imagenes/cocha.jfif') }}" alt="Cocha" class="top-right">
        <h1>GOBERNACIÓN DE COCHABAMBA</h1>
    </div>

    <div class="content">
        <h1>Reporte de Flujos Poblacionales</h1>
        <h3>Fecha Inicio: {{ $fechaInicio }} - Fecha Fin: {{ $fechaFin }}</h3>

        <table>
            <thead>
                <tr>
                    <th>Categoria</th>
                    @foreach ($datos->pluck('clase')->unique() as $clase)
                        <th>{{ $clase }}</th>
                    @endforeach
                    <th>Total de Categorias</th>
                </tr>
            </thead>
            <tbody>
                <!-- Fila para la categoría Recepción -->
                <tr>
                    <td class="total-category"><strong>Recepción</strong></td>
                    @php $subtotalRecepcion = 0; @endphp
                    @foreach ($datos->pluck('clase')->unique() as $clase)
                        <td>
                            {{ $totalRecepcion = $datos->where('clase', $clase)->sum('total_recepcion') }}
                            @php $subtotalRecepcion += $totalRecepcion; @endphp
                        </td>
                    @endforeach
                    <td>{{ $subtotalRecepcion > 0 ? $subtotalRecepcion : '' }}</td>
                </tr>

                <!-- Fila para la categoría Fuga -->
                <tr>
                    <td class="total-category"><strong>Fuga</strong></td>
                    @php $subtotalFuga = 0; @endphp
                    @foreach ($datos->pluck('clase')->unique() as $clase)
                        <td>
                            {{ $totalFuga = $datos->where('clase', $clase)->sum('total_fuga') }}
                            @php $subtotalFuga += $totalFuga; @endphp
                        </td>
                    @endforeach
                    <td>{{ $subtotalFuga > 0 ? $subtotalFuga : '' }}</td>
                </tr>

                <!-- Fila para la categoría Deceso -->
                <tr>
                    <td class="total-category"><strong>Deceso</strong></td>
                    @php $subtotalDeceso = 0; @endphp
                    @foreach ($datos->pluck('clase')->unique() as $clase)
                        <td>
                            {{ $totalDeceso = $datos->where('clase', $clase)->sum('total_deceso') }}
                            @php $subtotalDeceso += $totalDeceso; @endphp
                        </td>
                    @endforeach
                    <td>{{ $subtotalDeceso > 0 ? $subtotalDeceso : '' }}</td>
                </tr>

                <!-- Fila para la categoría Nacimiento -->
                <tr>
                    <td class="total-category"><strong>Nacimiento</strong></td>
                    @php $subtotalNacimiento = 0; @endphp
                    @foreach ($datos->pluck('clase')->unique() as $clase)
                        <td>
                            {{ $totalNacimiento = $datos->where('clase', $clase)->sum('total_nacimiento') }}
                            @php $subtotalNacimiento += $totalNacimiento; @endphp
                        </td>
                    @endforeach
                    <td>{{ $subtotalNacimiento > 0 ? $subtotalNacimiento : '' }}</td>
                </tr>

                <!-- Fila para la categoría Transferencia -->
                <tr>
                    <td class="total-category"><strong>Transferencia</strong></td>
                    @php $subtotalTransferencia = 0; @endphp
                    @foreach ($datos->pluck('clase')->unique() as $clase)
                        <td>
                            {{ $totalTransferencia = $datos->where('clase', $clase)->sum('total_transferencia') }}
                            @php $subtotalTransferencia += $totalTransferencia; @endphp
                        </td>
                    @endforeach
                    <td>{{ $subtotalTransferencia > 0 ? $subtotalTransferencia : '' }}</td>
                </tr>

                <!-- Fila de totales generales -->
                <tr class="font-weight-bold">
                    <td><strong>Total General de las Clases</strong></td>
                    @foreach ($datos->pluck('clase')->unique() as $clase)
                        <td>
                            {{ $totalPorClase = $datos->where('clase', $clase)->sum(function($item) {
                                return $item->total_recepcion + $item->total_fuga + $item->total_deceso + $item->total_nacimiento + $item->total_transferencia;
                            }) }}
                        </td>
                    @endforeach
                    <td>
                        {{ $totalGeneral = $datos->sum(function($item) {
                            return $item->total_recepcion + $item->total_fuga + $item->total_deceso + $item->total_nacimiento + $item->total_transferencia;
                        }) }}
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Total General fuera de la tabla -->
        <div class="total-general">
            Total General: {{ $totalGeneral }}
        </div>
    </div>
</body>
</html>
