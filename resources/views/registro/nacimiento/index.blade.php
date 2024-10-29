@extends('layouts.admin')

@section('contenido')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Nacimientos</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Nacimientos</li>
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
                        <h3 class="card-title">Listado de Nacimientos</h3>
                        <div class="card-tools">
                            <a href="{{ route('nacimiento.create') }}" class="btn btn-primary">Nuevo Nacimiento</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('nacimiento.index') }}">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <input type="text" name="texto" class="form-control" placeholder="Buscar..." value="{{ $texto }}">
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-secondary">Buscar</button>
                                </div>
                            </div>
                        </form>

                        @php
    use Carbon\Carbon;
    \Carbon\Carbon::setLocale('es');  // Establecer el idioma a español
@endphp

<form action="{{ route('nacimiento.reporte.descargar') }}" method="GET" class="form-inline mb-3">
    <div class="form-group">
        <label for="mes">Mes:</label>
        <select name="mes" id="mes" class="form-control ml-2">
            @for ($i = 1; $i <= 12; $i++)
                <option value="{{ $i }}">{{ ucfirst(Carbon::create()->month($i)->translatedFormat('F')) }}</option>
            @endfor
        </select>
    </div>
    
    <div class="form-group ml-3">
        <label for="año">Año:</label>
        <input type="number" name="año" id="año" class="form-control ml-2" value="{{ date('Y') }}" min="2000" max="{{ date('Y') }}">
    </div>

    <button type="submit" class="btn btn-success ml-3">
        <i class="fas fa-arrow-up"></i> Descargar Reporte PDF
    </button>
</form>

                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre común</th>
                                        <th>Código</th>
                                        <th>Clase</th>
                                        <th>Sexo</th>
                                        <th>Estado de Transferencia</th> <!-- Nueva columna -->
                                        <th>Fotografía</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($nacimientos as $nacimiento)
                                        <tr>
                                            <td>{{ $nacimiento->id_nacimiento }}</td>
                                            <td>{{ $nacimiento->nombre }}</td>
                                            <td>{{ $nacimiento->codigo }}</td>
                                            <td>{{ $nacimiento->clase }}</td>
                                            <td>{{ $nacimiento->sexo }}</td>
                                            <td>{{ $nacimiento->estado_trasferencia }}</td>
                                            <td>
                                                @if ($nacimiento->fotografia)
                                                    <img src="{{ asset('imagenes/nacimientos/' . $nacimiento->fotografia) }}" alt="{{ $nacimiento->nombre }}" class="img-thumbnail" width="100">
                                                @else
                                                    No disponible
                                                @endif
                                            </td>
                                            <td>
    <a href="{{ route('nacimiento.edit', $nacimiento->id_nacimiento) }}" class="btn btn-warning">
        <i class="fas fa-edit"></i> <!-- Ícono de editar -->
    </a>
    <a href="{{ route('nacimiento.show', $nacimiento->id_nacimiento) }}" class="btn btn-info">
        <i class="fas fa-eye"></i> <!-- Ícono de ver detalles -->
    </a>
    <button class="btn btn-danger" data-toggle="modal" data-target="#modal-delete-{{ $nacimiento->id_nacimiento }}">
        <i class="fas fa-trash"></i> <!-- Ícono de eliminar -->
    </button>
</td>

                                        </tr>
                                        @include('registro.nacimiento.modal', ['nacimiento' => $nacimiento])
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        {{ $nacimientos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
