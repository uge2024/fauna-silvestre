@extends('layouts.admin')

@section('contenido')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Municipios</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Municipios</li>
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
                        <h3 class="card-title">Listado de Municipios</h3>
                        <div class="card-tools">
                            <a href="{{ route('municipio.create') }}" class="btn btn-primary">Nuevo Municipio</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('municipio.index') }}">
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
                                    <th class="text-danger">Departamento</th>
                                        <th class="text-danger">Nombre</th> <!-- Encabezado en rojo -->
                                        <th class="text-danger">Código</th>
                                        <th class="text-danger">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($municipios as $municipio)
                                        <tr>
                                            <td>{{ $municipio->id_municipio }}</td>
                                            <td>{{ $municipio->departamento }}</td>
                                            <td>{{ $municipio->nombre }}</td> <!-- Nombre en negro -->
                                            <td>{{ $municipio->codigo }}</td>
                                            <td>
                                                <a href="{{ route('municipio.show', $municipio->id_municipio) }}" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                                <a href="{{ route('municipio.edit', $municipio->id_municipio) }}" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                                <button class="btn btn-danger" data-toggle="modal" data-target="#modal-delete-{{ $municipio->id_municipio }}"><i class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                        @include('usuario.municipio.modal', ['municipio' => $municipio])
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        {{ $municipios->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
