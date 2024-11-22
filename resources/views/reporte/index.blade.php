@extends('layouts.admin')

@section('contenido')
    <style>
        /* Estilos generales */
        body {
            background-image: url('/imagenes/fo.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            color: #333;
        }

        /* Tarjetas */
        .card {
            background-color: rgba(255, 255, 255, 0.9);
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .card-header {
            background-color: #007bff;
            color: white;
            border-radius: 10px 10px 0 0;
            text-align: center;
        }

        .card-body {
            padding: 20px;
        }

        /* Formularios */
        .form-label {
            font-weight: bold;
            color: #007bff;
        }

        .form-control {
            border-radius: 5px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        /* Botones */
        .btn {
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 16px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        /* Tablas */
        .table {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .table thead {
            background-color: #007bff;
            color: white;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #ddd;
            padding: 10px;
            vertical-align: middle;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f9f9f9;
        }

        .bg-light {
            background-color: #f8f9fa;
        }

        .bg-success {
            background-color: #28a745 !important;
        }
    </style>

    <!-- Tarjeta principal -->
    <div class="card shadow-lg">
        <div class="card-header">
            <h2><i class="fas fa-chart-line"></i> Generar Reporte de Flujos Poblacionales</h2>
            <p>Seleccione las fechas para generar un informe detallado.</p>
        </div>
        <div class="card-body">
            <!-- Formulario de Reporte -->
            <form action="{{ route('reporte.generar') }}" method="GET" class="p-3">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                        <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                        <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" required>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-file-alt"></i> Generar Reporte
                    </button>
                </div>
            </form>

            <!-- Formulario para Exportar a Excel -->
            <div class="text-center mt-4">
                <div class="p-4" style="border: 2px solid #28a745; border-radius: 10px; background-color: #f8fff4;">
                    <form action="{{ route('reporte.exportarExcel') }}" method="POST" class="row align-items-center">
                        @csrf
                        <div class="col-md-4 mb-3">
                            <label for="fecha_inicio_excel" class="form-label">Fecha Inicio</label>
                            <input type="date" name="fecha_inicio" id="fecha_inicio_excel" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="fecha_fin_excel" class="form-label">Fecha Fin</label>
                            <input type="date" name="fecha_fin" id="fecha_fin_excel" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-success btn-lg w-100">
                                <i class="fas fa-file-excel"></i> Exportar a Excel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Reporte -->
    @if(isset($datos) && $datos->isNotEmpty())
        <div class="card shadow-lg mt-4">
            <div class="card-header bg-success text-white">
                <h3><i class="fas fa-list"></i> Reporte de Flujos Poblacionales</h3>
                <p><strong>Periodo:</strong> {{ $fechaInicio }} al {{ $fechaFin }}</p>
                <a href="{{ route('reporte.pdf', ['fecha_inicio' => $fechaInicio, 'fecha_fin' => $fechaFin]) }}" class="btn btn-light text-success float-end">
                    <i class="fas fa-file-pdf"></i> Descargar PDF
                </a>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered text-center">
                    <thead>
                        <tr>
                            <th>Categoría</th>
                            @foreach ($datos->pluck('clase')->unique() as $clase)
                                <th>{{ $clase }}</th>
                            @endforeach
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (['Recepción', 'Fuga', 'Deceso', 'Nacimiento', 'Transferencia'] as $categoria)
                            <tr>
                                <td><strong>{{ $categoria }}</strong></td>
                                @php $subtotal = 0; @endphp
                                @foreach ($datos->pluck('clase')->unique() as $clase)
                                    <td>
                                        @php
                                            $total = $datos->where('clase', $clase)->sum("total_" . strtolower($categoria));
                                            $subtotal += $total;
                                        @endphp
                                        {{ $total ?: '' }}
                                    </td>
                                @endforeach
                                <td>{{ $subtotal ?: '' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection
