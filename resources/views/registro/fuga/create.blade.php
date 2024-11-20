@extends('layouts.admin')

@section('contenido')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Nueva Fuga</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Fugas</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="section">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('fuga.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                               
                                <div class="form-group">
                                    <label for="id_institucion">Institución</label>
                                    <select name="id_institucion" class="form-control" required>
                                        @foreach ($instituciones as $institucion)
                                            <option value="{{ $institucion->id_institucion }}">{{ $institucion->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
    <label for="id_recepcion">Animal Registrado por Recepción:</label>
    <select name="id_recepcion" id="id_recepcion" class="form-control">
        <option value="">Selecciona una recepción (opcional)</option>
        @foreach ($recepciones as $recepcion)
            <option value="{{ $recepcion->id_recepcion }}" {{ old('id_recepcion', $deceso->id_recepcion ?? '') == $recepcion->id_recepcion ? 'selected' : '' }}>
                {{ $recepcion->codigo_animal }}
            </option>
        @endforeach
    </select>
    @error('id_recepcion')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="id_nacimiento">Animal Registrado de Nacimiento:</label>
    <select name="id_nacimiento" id="id_nacimiento" class="form-control">
        <option value="">Selecciona un nacimiento (opcional)</option>
        @foreach ($nacimientos as $nacimiento)
            <option value="{{ $nacimiento->id_nacimiento }}" {{ old('id_nacimiento', $deceso->id_nacimiento ?? '') == $nacimiento->id_nacimiento ? 'selected' : '' }}>
                {{ $nacimiento->codigo }}
            </option>
        @endforeach
    </select>
    @error('id_nacimiento')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>


<div class="form-group">
    <label for="fecha">Fecha de fuga</label>
    <input type="date" name="fecha" class="form-control" value="{{ old('fecha', now()->format('Y-m-d')) }}" required>
</div>
                               
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <a href="{{ route('fuga.index') }}" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
