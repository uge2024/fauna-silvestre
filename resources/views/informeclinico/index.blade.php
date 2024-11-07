@extends('layouts.admin')

@section('contenido')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">
        <i class="fas fa-plus-circle" style="font-size: 40px; color: #2b2d46; margin-right: 15px; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);"></i> Listado de Informes Clínicos
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
                    <h3 class="card-title">Listado de Informes Clínicos</h3>
                    <div class="card-tools">
                        <a href="{{ route('informeclinico.create') }}" class="btn btn-primary">Nuevo Informe Clínico</a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('informeclinico.index') }}" class="mb-3">
                        <div class="input-group">
                            <input type="text" name="texto" class="form-control" placeholder="Buscar..." value="{{ request('texto') }}">
                            <button class="btn btn-secondary" type="submit">Buscar</button>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                   
                                    <th>Institución</th>
                                    <th>Animal Recepción</th>
                                    <th>Animal nacimiento</th>
                                    <th>Fecha</th>
                                  
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($informesClinicos as $informeClinico)
                                    <tr>
                                        <td>{{ $informeClinico->id_informeclinico }}</td>
                                        
                                        <td>{{ $informeClinico->institucion ? $informeClinico->institucion->nombre : 'N/A' }}</td>
                                        <td>{{ $informeClinico->recepcion ? $informeClinico->recepcion->nombre : 'N/A' }}</td>
                                        <td>{{ $informeClinico->nacimiento ? $informeClinico->nacimiento->nombre : 'N/A' }}</td>
                                        <td>{{ $informeClinico->fecha }}</td>
                                       
                                        <td>
    <a href="{{ route('informeclinico.edit', $informeClinico->id_informeclinico) }}" class="btn btn-warning btn-sm">
        <i class="fas fa-edit"></i> <!-- Ícono de editar -->
    </a>
    <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#detailsModal{{ $informeClinico->id_informeclinico }}">
        <i class="fas fa-eye"></i> <!-- Ícono de detalles -->
    </button>
    <a href="{{ route('informeclinico.export.pdf', $informeClinico->id_informeclinico) }}" class="btn btn-success btn-sm">
        <i class="fas fa-arrow-up"></i> <!-- Ícono de exportar PDF -->
    </a>
    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $informeClinico->id_informeclinico }}">
        <i class="fas fa-trash"></i> <!-- Ícono de eliminar -->
    </button>
</td>

                                    </tr>

                                    <!-- Modal Detalles -->
                                    <div class="modal fade" id="detailsModal{{ $informeClinico->id_informeclinico }}" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel{{ $informeClinico->id_informeclinico }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="detailsModalLabel{{ $informeClinico->id_informeclinico }}">Detalles del Informe Clínico</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>ID:</strong> {{ $informeClinico->id_informeclinico }}</p>
                                                    
                                                    <p><strong>Institución:</strong> {{ $informeClinico->institucion ? $informeClinico->institucion->nombre : 'N/A' }}</p>
                                                    <p><strong>Animal Recepción:</strong> {{ $informeClinico->recepcion ? $informeClinico->recepcion->nombre : 'N/A' }}</p>
                                                    <p><strong>Animal Nacimiento:</strong> {{ $informeClinico->nacimiento ? $informeClinico->nacimiento->nombre : 'N/A' }}</p>
                                                    <p><strong>Fecha:</strong> {{ $informeClinico->fecha }}</p>
                                                    <p><strong>Anamnesis:</strong> {{ $informeClinico->anamnesis }}</p>
                                                    <p><strong>Diagnóstico:</strong> {{ $informeClinico->diagnostico }}</p>
                                                    <p><strong>Tratamiento:</strong> {{ $informeClinico->tratamiento }}</p>
                                                    <p><strong>Programa Sanitario:</strong> {{ $informeClinico->programa_sanitario }}</p>
                                                    <p><strong>Veterinario:</strong> {{ $informeClinico->veterinario }}</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Eliminar -->
                                    <div class="modal fade" id="deleteModal{{ $informeClinico->id_informeclinico }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $informeClinico->id_informeclinico }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $informeClinico->id_informeclinico }}">Confirmar Eliminación</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('informeclinico.destroy', $informeClinico->id_informeclinico) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="modal-body">
                                                        ¿Estás seguro de que deseas eliminar este informe clínico?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    
                                @endforeach
                            </tbody>
                        </table>
                        {{ $informesClinicos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
