@extends('layouts.admin')

@section('contenido')
<div class="container">
    <h3 class="my-4">
        <i class="fas fa-exchange-alt" style="font-size: 40px; color: #2b2d46; margin-right: 15px; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);"></i> Transferencias
    </h3>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error:</strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

    <a href="{{ route('transferencia.create') }}" class="btn btn-primary mb-3">Nueva Transferencia</a>

    <form method="GET" action="{{ route('transferencia.index') }}" class="mb-3">
        <div class="input-group">
            
            <input type="text" name="texto" class="form-control" placeholder="Buscar..." value="{{ request('texto') }}">
            <button class="btn btn-secondary" type="submit">Buscar</button>
        </div>
    </form>
    @php
    use Carbon\Carbon;
    \Carbon\Carbon::setLocale('es');  // Establecer el idioma a español
@endphp
    <form action="{{ route('transferencia.reporte.pdf') }}" method="GET" class="form-inline mb-3">
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
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Institución Actual</th>
                    <th>Recepción</th>
                    <th>Nacimiento</th>
                    <th>Fecha</th>
                    <th>Institución Destino</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transferencias as $transferencia)
                    <tr>
                        <td>{{ $transferencia->id_transferencia }}</td>
                        <td>{{ $transferencia->institucion->nombre ?? 'N/A' }}</td>
                        <td>{{ $transferencia->recepcion ? $transferencia->recepcion->nombre : 'N/A' }}</td>
                        <td>{{ $transferencia->nacimiento ? $transferencia->nacimiento->nombre : 'N/A' }}</td>
                        <td>{{ $transferencia->fecha }}</td>
                        <td>{{ $transferencia->institucionDestino->nombre ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('transferencia.show', $transferencia->id_transferencia) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('transferencia.edit', $transferencia->id_transferencia) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal" onclick="setDeleteAction('{{ route('transferencia.destroy', $transferencia->id_transferencia) }}')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $transferencias->links() }}
    </div>
</div>

<!-- Modal para confirmar la eliminación -->
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
                    ¿Estás seguro de que deseas eliminar esta transferencia?
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
