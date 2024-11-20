@extends('layouts.admin')

@section('contenido')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Editar Informe Clínico</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('informeclinico.index') }}">Informes Clínicos</a></li>
                    <li class="breadcrumb-item active">Editar</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="section">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Formulario de Edición de Informe Clínico</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('informeclinico.update', $informeclinico->id_informeclinico) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label for="id_institucion">Institución:</label>
                            <select name="id_institucion" id="id_institucion" class="form-control">
                                <option value="">Selecciona una institución</option>
                                @foreach ($instituciones as $institucion)
                                    <option value="{{ $institucion->id_institucion }}" {{ $institucion->id_institucion == $informeclinico->id_institucion ? 'selected' : '' }}>{{ $institucion->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
        <label for="id_recepcion">Animal Registrado por Recepción</label>
        <select name="id_recepcion" id="id_recepcion" class="form-control">
            <option value="">Seleccione...</option>
            @foreach($recepciones as $recepcion)
                <option value="{{ $recepcion->id_recepcion }}" {{ old('id_recepcion', $informeclinico->id_recepcion) == $recepcion->id_recepcion ? 'selected' : '' }}>
                    {{ $recepcion->codigo_animal }}
                </option>
            @endforeach
        </select>
    </div>
    
    <div class="form-group">
        <label for="id_nacimiento">Animal Registrado de Nacimiento</label>
        <select name="id_nacimiento" id="id_nacimiento" class="form-control">
            <option value="">Seleccione...</option>
            @foreach($nacimientos as $nacimiento)
                <option value="{{ $nacimiento->id_nacimiento }}" {{ old('id_nacimiento', $informeclinico->id_nacimiento) == $nacimiento->id_nacimiento ? 'selected' : '' }}>
                    {{ $nacimiento->codigo }}
                </option>
            @endforeach
        </select>
    </div>
                        <div class="form-group">
                            <label for="fecha">Fecha:</label>
                            <input type="date" name="fecha" id="fecha" class="form-control" value="{{ $informeclinico->fecha }}">
                        </div>
                        <div class="form-group">
                            <label for="anamnesis">anamnesis:</label>
                            <textarea name="anamnesis" id="anamnesis" class="form-control" rows="3">{{ $informeclinico->anamnesis }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="diagnostico">Diagnóstico:</label>
                            <textarea name="diagnostico" id="diagnostico" class="form-control" rows="3">{{ $informeclinico->diagnostico }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="tratamiento">Tratamiento:</label>
                            <textarea name="tratamiento" id="tratamiento" class="form-control" rows="3">{{ $informeclinico->tratamiento }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="programa_sanitario">Programa Sanitario:</label>
                            <input type="text" name="programa_sanitario" id="programa_sanitario" class="form-control" value="{{ $informeclinico->programa_sanitario }}">
                        </div>
                        <div class="form-group">
                            <label for="veterinario">Medico_Veterinario:</label>
                            <input type="text" name="veterinario" id="veterinario" class="form-control" value="{{ $informeclinico->veterinario }}">
                        </div>

                        <button type="submit" class="btn btn-primary">Actualizar</button>
                        <a href="{{ route('informeclinico.index') }}" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
