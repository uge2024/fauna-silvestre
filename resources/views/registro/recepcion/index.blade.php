@extends('layouts.admin')

@section('contenido')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
        <h1 class="m-0">
                    <i class="fas fa-clipboard-list" style="font-size: 40px; color: #2b2d46; margin-right: 15px; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);"></i> Recepciones
                </h1>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                   
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
                        <h3 class="card-title">Listado de Recepciones</h3>
                        <div class="card-tools">
                            <a href="{{ route('recepcion.create') }}" class="btn btn-primary">Nueva Recepción</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('recepcion.index') }}">
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

<form action="{{ route('reporte.descargar') }}" method="GET" class="form-inline mb-3">
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
                                        <th>Institución Responsable de Decomiso</th>
                                        <th>Institucion Que_Recibe</th>
                                       
                                        <th>Fecha</th>
                                        <th>Código Animal</th>
                                        <th>Nombre Común</th>
                                        <th>Estado de Transferencia</th> <!-- Nueva columna -->
                                        <th>Fotografía</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recepciones as $recepcion)
                                        <tr>
                                        <td>{{ $recepcion->id_recepcion }}</td>
                                        <td>{{ $recepcion->institucionRecibida->nombre ?? 'No asignada' }}</td> <!-- Nueva columna -->
            <td>{{ $recepcion->institucion->nombre }}</td>
            <td>{{ $recepcion->fecha }}</td>
            <td>{{ $recepcion->codigo_animal }}</td>
            <td>{{ $recepcion->nombre }}</td>
            <td>{{ $recepcion->estado_trasferencia }}</td>
            <td>
                                                @if ($recepcion->fotografia)
                                                    <img src="{{ asset('imagenes/recepcion/' . $recepcion->fotografia) }}" alt="{{ $recepcion->nombre }}" class="img-thumbnail" width="100">
                                                @endif
                                            </td>
                                            <td>
                                          
                       
    <!-- Botón para ver detalles -->
    <a href="{{ route('recepcion.show', $recepcion->id_recepcion) }}" class="btn btn-info">
        <i class="fas fa-eye"></i>
    </a>

    <!-- Botón para editar -->
    <a href="{{ route('recepcion.edit', $recepcion->id_recepcion) }}" class="btn btn-warning">
        <i class="fas fa-edit"></i>
    </a>

    <!-- Botón para exportar PDF -->
    <a href="{{ route('recepcion.exportPdf', ['id' => $recepcion->id_recepcion]) }}" class="btn btn-danger">
        <i class="fas fa-file-pdf fa-2x"></i>
    </a>

    


    <button class="btn btn-danger" data-toggle="modal" data-target="#modal-delete-{{ $recepcion->id_recepcion }}">
        <i class="fas fa-trash"></i>
    </button>
</td>

                                        </tr>
                                        @include('registro.recepcion.modal', ['recepcion' => $recepcion])
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        {{ $recepciones->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
