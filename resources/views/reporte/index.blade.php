@extends('layouts.admin')

@section('contenido')
    <style>
        body {
            background-image: url('/imagenes/fo.jpg'); /* Ruta de la imagen */
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.9); /* Fondo blanco con transparencia */
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .card-header {
            background-color: rgba(0, 123, 255, 0.8); /* Azul con transparencia */
        }

        .table {
            background-color: white;
        }
    </style>

    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white text-center">
            <h2><i class="fas fa-chart-line"></i> Generar Reporte de Flujos Poblacionales</h2>
            <p>Seleccione las fechas para generar un informe detallado.</p>
        </div>
        <div class="card-body">
            <!-- Formulario para seleccionar las fechas -->
            <form action="{{ route('reporte.generar') }}" method="GET" class="p-3">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="fecha_inicio" class="form-label"><strong>Fecha de Inicio</strong></label>
                        <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="fecha_fin" class="form-label"><strong>Fecha de Fin</strong></label>
                        <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" required>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-file-alt"></i> Generar Reporte
                    </button>
                </div>
                </div>
                <div class="text-center">
                <form action="{{ route('exportar.excel.manual') }}" method="GET">
    <button type="submit" class="btn btn-success btn-lg">
        <i class="fas fa-file-excel"></i> Exportar a Excel
    </button>
</form>

</div>


    </div>

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
                <!-- Tabla con los datos -->
                <table class="table table-striped table-bordered text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>Categoría</th>
                            @foreach ($datos->pluck('clase')->unique() as $clase)
                                <th>{{ $clase }}</th>
                            @endforeach
                            <th>Total por Categoría</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $categorias = ['Recepción', 'Fuga', 'Deceso', 'Nacimiento', 'Transferencia'];
                        @endphp

                        @foreach ($categorias as $categoria)
                            <tr>
                                <td class="bg-warning text-dark"><strong>{{ $categoria }}</strong></td>
                                @php $subtotal = 0; @endphp
                                @foreach ($datos->pluck('clase')->unique() as $clase)
                                    <td>
                                        @php
                                            $total = $datos->where('clase', $clase)->sum("total_" . strtolower($categoria));
                                            $subtotal += $total;
                                        @endphp
                                        {{ $total > 0 ? $total : '' }}
                                    </td>
                                @endforeach
                                <td class="bg-light"><strong>{{ $subtotal > 0 ? $subtotal : '' }}</strong></td>
                            </tr>
                        @endforeach

                        <!-- Fila de totales generales -->
                        <tr>
                            <td><strong>Total General</strong></td>
                            @foreach ($datos->pluck('clase')->unique() as $clase)
                                <td>
                                    @php
                                        $totalPorClase = $datos->where('clase', $clase)->sum(function($item) {
                                            return $item->total_recepcion + $item->total_fuga + $item->total_deceso + $item->total_nacimiento + $item->total_transferencia;
                                        });
                                    @endphp
                                    {{ $totalPorClase > 0 ? $totalPorClase : '' }}
                                </td>
                            @endforeach
                            <td class="bg-success text-white">
                                <strong>
                                    @php
                                        $totalGeneral = $datos->sum(function($item) {
                                            return $item->total_recepcion + $item->total_fuga + $item->total_deceso + $item->total_nacimiento + $item->total_transferencia;
                                        });
                                    @endphp
                                    {{ $totalGeneral > 0 ? $totalGeneral : '' }}
                                </strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection
