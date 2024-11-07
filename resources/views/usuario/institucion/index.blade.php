@extends('layouts.admin')

@section('contenido')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">
    <i class="fas fa-university" style="font-size: 40px; color: #2b2d46; margin-right: 15px; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);"></i> Instituciones
</h1>


            </div>
            <div class="col-sm-6">
              
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Listado de Instituciones</h3>
                        <div class="card-tools">
                            <a href="{{ route('institucion.create') }}" class="btn btn-primary">Nueva Institución</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('institucion.index') }}">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <input type="text" name="texto" class="form-control" placeholder="Buscar..." value="{{ request('texto') }}">
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-secondary">Buscar</button>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                    <th class="text-danger">ID</th>
                                    <th class="text-danger">Código</th>
                                    <th class="text-danger">Nombre</th>
                                    
                                    <th class="text-danger">Zona</th>
                                    <th class="text-danger">Localización</th>
                                    <th class="text-danger">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($instituciones as $institucion)
                                        <tr>
                                            <td>{{ $institucion->id_institucion }}</td>
                                            <td>{{ $institucion->codigo }}</td>
                                            <td>{{ $institucion->nombre }}</td>
                                         
                                            <td>{{ $institucion->zona }}</td>
                                            <td>{{ $institucion->localizacion }}</td>
                                            <td>
    <a href="{{ route('institucion.edit', $institucion->id_institucion) }}" class="btn btn-warning">
        <i class="fas fa-edit"></i> <!-- Ícono de editar -->
    </a>
    <a href="{{ route('institucion.show', $institucion->id_institucion) }}" class="btn btn-info">
        <i class="fas fa-eye"></i> <!-- Ícono de ver detalles -->
    </a>
    <button class="btn btn-danger" data-toggle="modal" data-target="#modal-delete-{{ $institucion->id_institucion }}">
        <i class="fas fa-trash"></i> <!-- Ícono de eliminar -->
    </button>
</td>


                                        </tr>
                                        @include('usuario.institucion.modal', ['institucion' => $institucion])
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        {{ $instituciones->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
