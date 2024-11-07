<!DOCTYPE html>
<html>
<head>
    <title>Reporte  de  Fugas por Clase - {{ $nombreMes }} {{ $año }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
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
            margin: 0 auto;
            width: 95%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 5px;
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
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('imagenes/escudo.jfif') }}" alt="Escudo" class="top-left">
        <img src="{{ public_path('imagenes/cocha.jfif') }}" alt="cocha" class="top-right">
        <h1>GOBERNACIÓN DE COCHABAMBA</h1>
    </div>
    
    <div class="content">
        <h1>Reporte  de  Fugas por Clase - {{ $nombreMes }} {{ $año }}</h1>
        
        @if($datosPorClase->isEmpty())
            <p>No se encontraron fugas para el mes seleccionado.</p>
        @else
            <table>
                <thead>
                    <tr>
                        @foreach ($datosPorClase->groupBy('clase') as $clase => $items)
                            <th colspan="3">{{ $clase }}</th>
                        @endforeach
                    </tr>
                    <tr>
                        @foreach ($datosPorClase->groupBy('clase') as $clase => $items)
                            <th>Sexo</th>
                            <th>Edad</th>
                            <th>Total</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @php
                        $currentClase = null;
                        $classTotals = [];
                    @endphp

                    @foreach($datosPorClase as $fuga)
                        <tr>
                            @foreach ($datosPorClase->groupBy('clase') as $clase => $items)
                                @if($fuga->clase === $clase)
                                    <td>{{ $fuga->sexo }}</td>
                                    <td>{{ $fuga->edad }}</td>
                                    <td>{{ $fuga->total }}</td>
                                @else
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach

                    <tr class="subtotal-row">
                        @foreach ($datosPorClase->groupBy('clase') as $clase => $items)
                            @php
                                $classTotal = $items->sum('total');
                            @endphp
                            <td colspan="2" class="subtotal-header"><strong>Total para {{ $clase }}</strong></td>
                            <td class="subtotal-header"><strong>{{ $classTotal }}</strong></td>
                        @endforeach
                    </tr>

                    <tr>
                        <td colspan="{{ count($datosPorClase->groupBy('clase')) * 3 }}"><strong>Total General</strong></td>
                        <td><strong>{{ $totalAnimales }}</strong></td>
                    </tr>
                </tbody>
            </table>
        @endif
    </div>
</body>
</html>
