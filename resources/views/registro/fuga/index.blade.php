@extends('layouts.admin')

@section('contenido')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">
        <i class="fas fa-kiwi-bird" style="font-size: 40px; color: #2b2d46; margin-right: 15px; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);"></i> Fugas
    </h1>
            </div>
            <div class="col-sm-6">
              
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
                    <h3 class="card-title">Listado de Fugas</h3>
                    <div class="card-tools">
                        <a href="{{ route('fuga.create') }}" class="btn btn-primary">Nueva Fuga</a>
                    </div>
                </div>
                <div class="card-body">
                @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error:</strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

                    <form action="{{ route('fuga.index') }}" method="get">
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
                    <form action="{{ route('fuga.reporte.pdf') }}" method="GET" class="form-inline mb-3">
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
                                    <th>Recepción</th>
                                    <th>Animal Nacimiento</th>
                                    <th>Fecha</th>
                                    
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($fugas as $fuga)
                                    <tr>
                                        <td>{{ $fuga->id_fuga }}</td>
                                        <td>{{ $fuga->institucion ? $fuga->institucion->nombre : 'Sin institución' }}</td>
                                        <td>{{ $fuga->recepcion ? $fuga->recepcion->nombre : 'N/A' }}</td>
                                        <td>{{ $fuga->nacimiento ? $fuga->nacimiento->nombre : 'N/A' }}</td>
                                        <td>{{ $fuga->fecha }}</td>
                                        
                                        <td>
                                            <a href="#" class="btn btn-info btn-sm" data-toggle="modal" data-target="#detailsModal{{ $fuga->id_fuga }}">
                                                <i class="fas fa-eye"></i> <!-- Ícono para ver detalles -->
                                            </a>
                                            <a href="{{ route('fuga.edit', $fuga->id_fuga) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i> <!-- Ícono de editar -->
                                            </a>
                                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal" onclick="setDeleteAction('{{ route('fuga.destroy', $fuga->id_fuga) }}')">
                                                <i class="fas fa-trash"></i> <!-- Ícono de eliminar -->
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Modal Detalles -->
                                    <div class="modal fade" id="detailsModal{{ $fuga->id_fuga }}" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel{{ $fuga->id_fuga }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="detailsModalLabel{{ $fuga->id_fuga }}">Detalles de la Fuga</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>ID:</strong> {{ $fuga->id_fuga }}</p>
                                                    <p><strong>Institución:</strong> {{ $fuga->institucion ? $fuga->institucion->nombre : 'Sin institución' }}</p>
                                                    <p><strong>Recepción:</strong> {{ $fuga->recepcion ? $fuga->recepcion->nombre : 'N/A' }}</p>
                                                    <p><strong>Animal Nacimiento:</strong> {{ $fuga->nacimiento ? $fuga->nacimiento->nombre : 'N/A' }}</p>
                                                    <p><strong>Fecha:</strong> {{ $fuga->fecha }}</p>
                                                    
                                                    <p><strong>Detalles Adicionales:</strong> {{ $fuga->detalles_adicionales }}</p> <!-- Asegúrate de tener este campo en tu base de datos -->
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
                        {{ $fugas->links() }}
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
                    ¿Estás seguro de que deseas eliminar esta fuga?
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
