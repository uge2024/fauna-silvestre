@extends('layouts.admin')

@section('contenido')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Decesos</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Decesos</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="section">
    <div class="row">
        <div class="col-12">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Listado de Decesos</h3>
                    <div class="card-tools">
                        <a href="{{ route('deceso.create') }}" class="btn btn-primary">Nuevo Deceso</a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('deceso.index') }}" method="get">
                        <div class="input-group mb-3">
                            <input type="text" name="texto" class="form-control" placeholder="Buscar..." value="{{ request('texto') }}">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                            </div>
                        </div>
                    </form>
                    @php
    use Carbon\Carbon;
    \Carbon\Carbon::setLocale('es');  // Establecer el idioma a español
@endphp
                    <form action="{{ route('deceso.reporte.pdf') }}" method="GET" class="form-inline mb-3">
    <div class="form-group">
        <label for="mes">Mes:</label>
        <select name="mes" id="mes" class="form-control ml-2" required>
            <option value="">Selecciona un mes</option>
            @for ($i = 1; $i <= 12; $i++)
                <option value="{{ $i }}">{{ ucfirst(\Carbon\Carbon::create()->month($i)->translatedFormat('F')) }}</option>
            @endfor
        </select>
    </div>
    <div class="form-group ml-3">
        <label for="año">Año:</label>
        <input type="number" name="año" id="año" class="form-control ml-2" value="{{ date('Y') }}" min="2000" max="{{ date('Y') }}" required>
    </div>
    <button type="submit" class="btn btn-success ml-3">
        <i class="fas fa-arrow-up"></i> Descargar Reporte PDF
    </button>
</form>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Institución</th>
                                    <th>Animal Recepción</th>
                                    <th>Animal Nacimiento</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($decesos as $deceso)
                                    <tr>
                                        <td>{{ $deceso->id_deceso }}</td>
                                        <td>{{ $deceso->institucion ? $deceso->institucion->nombre : 'Sin institución' }}</td>
                                        <td>{{ $deceso->recepcion ? $deceso->recepcion->nombre : 'N/A' }}</td>
                                        <td>{{ $deceso->nacimiento ? $deceso->nacimiento->nombre : 'N/A' }}</td>
                                        <td>{{ $deceso->fecha }}</td>
                                        <td>
                                            <a href="#" class="btn btn-info btn-sm" data-toggle="modal" data-target="#detailsModal{{ $deceso->id_deceso }}">
                                                <i class="fas fa-eye"></i> <!-- Ícono para ver detalles -->
                                            </a>
                                            <a href="{{ route('deceso.edit', $deceso->id_deceso) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i> <!-- Ícono de editar -->
                                            </a>
                                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal" onclick="setDeleteAction('{{ route('deceso.destroy', $deceso->id_deceso) }}')">
                                                <i class="fas fa-trash"></i> <!-- Ícono de eliminar -->
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Modal Detalles -->
                                    <div class="modal fade" id="detailsModal{{ $deceso->id_deceso }}" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel{{ $deceso->id_deceso }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="detailsModalLabel{{ $deceso->id_deceso }}">Detalles del Deceso</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>ID:</strong> {{ $deceso->id_deceso }}</p>
                                                    <p><strong>Institución:</strong> {{ $deceso->institucion ? $deceso->institucion->nombre : 'Sin institución' }}</p>
                                                    <p><strong>Animal Recepción:</strong> {{ $deceso->recepcion ? $deceso->recepcion->nombre : 'Sin recepción' }}</p>
                                                    <p><strong>Animal Nacimiento:</strong> {{ $deceso->nacimiento ? $deceso->nacimiento->nombre : 'N/A' }}</p>
                                                    <p><strong>Fecha:</strong> {{ $deceso->fecha }}</p>
                                                    <p><strong>Causas:</strong> {{ $deceso->causas }}</p>
                                                    <p><strong>Diagnóstico:</strong> {{ $deceso->diagnostico }}</p>
                                                    <p><strong>Tratamiento:</strong> {{ $deceso->tratamiento }}</p>
                                                    <p><strong>Médico Veterinario:</strong> {{ $deceso->medico_veterinario }}</p>
                                                    @if($deceso->laboratorio_archivo)
                                                        <p><strong>Archivo PDF:</strong> 
                                                            <a href="{{ asset('pdfs/' . $deceso->laboratorio_archivo) }}" target="_blank">
                                                                Ver Archivo
                                                            </a>
                                                        </p>
                                                    @else
                                                        <p><strong>Archivo PDF:</strong> No disponible</p>
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $decesos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Eliminar -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirmar Eliminación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST" id="deleteForm">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    ¿Estás seguro de que deseas eliminar este deceso?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function setDeleteAction(action) {
        document.getElementById('deleteForm').action = action;
    }
</script>
@endsection
