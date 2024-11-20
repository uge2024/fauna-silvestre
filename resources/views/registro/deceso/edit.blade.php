@extends('layouts.admin')

@section('contenido')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Editar Deceso</h1>
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
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('deceso.update', $deceso->id_deceso) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                
                                <div class="form-group">
                                    <label for="id_institucion">Institución</label>
                                    <select name="id_institucion" class="form-control" required>
                                        @foreach ($instituciones as $institucion)
                                            <option value="{{ $institucion->id_institucion }}" {{ $institucion->id_institucion == $deceso->id_institucion ? 'selected' : '' }}>{{ $institucion->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
    <label for="id_recepcion">Animal Registrado por Recepción:</label>
    <select name="id_recepcion" id="id_recepcion" class="form-control">
        <option value="">Selecciona una recepción (opcional)</option>
        @foreach ($recepciones as $recepcion)
            <option value="{{ $recepcion->id_recepcion }}" {{ old('id_recepcion', $deceso->id_recepcion ?? '') == $recepcion->id_recepcion ? 'selected' : '' }}>
                {{ $recepcion->codigo_animal}}
            </option>
        @endforeach
    </select>
    @error('id_recepcion')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="id_nacimiento">Animal Registrado de Nacimiento::</label>
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
                                    <label for="fecha">Fecha</label>
                                    <input type="date" name="fecha" class="form-control" value="{{ $deceso->fecha }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="causas">Causas</label>
                                    <input type="text" name="causas" class="form-control" value="{{ $deceso->causas }}" maxlength="50" required>
                                </div>
                                <div class="form-group">
                                    <label for="diagnostico">Diagnóstico</label>
                                    <input type="text" name="diagnostico" class="form-control" value="{{ $deceso->diagnostico }}" maxlength="50" required>
                                </div>
                                <div class="form-group">
                                    <label for="tratamiento">Tratamiento</label>
                                    <input type="text" name="tratamiento" class="form-control" value="{{ $deceso->tratamiento }}" maxlength="50" required>
                                </div>
                                <div class="form-group">
                                    <label for="medico_veterinario">Médico Veterinario</label>
                                    <input type="text" name="medico_veterinario" class="form-control" value="{{ $deceso->medico_veterinario }}" maxlength="50" required>
                                </div>
                                <div class="form-group">
        <label for="laboratorio_archivo">Subir Archivo PDF</label>
        <input type="file" class="form-control" id="laboratorio_archivo" name="laboratorio_archivo">
    </div>
    @if ($deceso->laboratorio_archivo)
        <div class="form-group">
            <label>Archivo PDF Actual:</label>
            <a href="{{ asset('pdfs/' . $deceso->laboratorio_archivo) }}" target="_blank">Ver Archivo</a>
        </div>
    @endif

                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <a href="{{ route('deceso.index') }}" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
