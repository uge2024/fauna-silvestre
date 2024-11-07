@extends('layouts.admin')

@section('contenido')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">
            <i class="fas fa-users" style="font-size: 40px; color: #2b2d46; margin-right: 15px; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);"></i>

Listado de usuarios
</h1>

            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Usuario</li>
                </ol>
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
                        <h3 class="card-title">Listado de usuarios</h3>
                        <div class="card-tools">
                            <a href="{{ route('usuario.create') }}" class="btn btn-primary">Nuevo usuario</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('usuario.index') }}">
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
                                        <th class="text-danger">Nombre</th>
                                        <th class="text-danger">Email</th>
            
                                        <th class="text-danger">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($usuarios as $usu)
                                    <tr>
                                        <td>{{ $usu->id }}</td>
                                        <td>{{ $usu->name }}</td> <!-- Cambiado a 'name' -->
                                        <td>{{ $usu->email }}</td>
                                      
                                        <td>
                                            <a href="{{ route('usuario.edit', $usu->id) }}" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                            <a href="{{ route('usuario.show', $usu->id) }}" class="btn btn-info"><i class="fas fa-eye"></i></a> <!-- Botón de Detalles -->
                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{ $usu->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button> <!-- Botón de Eliminar -->
                                        </td>

                                        <!-- Modal -->
                                        <div class="modal fade" id="deleteModal{{ $usu->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $usu->id }}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel{{ $usu->id }}">Confirmar Eliminación</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        ¿Estás seguro de que deseas eliminar al usuario {{ $usu->name }}?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                        <form action="{{ route('usuario.destroy', $usu->id) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Eliminar</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        {{ $usuarios->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection 