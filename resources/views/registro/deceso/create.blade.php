@extends('layouts.admin')

@section('contenido')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Nuevo Deceso</h1>
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
                    <form action="{{ route('deceso.store') }}" method="post" enctype="multipart/form-data">
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
                                    <label for="id_recepcion">Animal de Recepción:</label>
                                    <select name="id_recepcion" id="id_recepcion" class="form-control">
                                        <option value="">Selecciona una recepción (opcional)</option>
                                        @foreach ($recepciones as $recepcion)
                                            <option value="{{ $recepcion->id_recepcion }}" {{ old('id_recepcion') == $recepcion->id_recepcion ? 'selected' : '' }}>
                                                {{ $recepcion->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_recepcion')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="id_nacimiento">animal de Nacimiento:</label>
                                    <select name="id_nacimiento" id="id_nacimiento" class="form-control">
                                        <option value="">Selecciona un nacimiento (opcional)</option>
                                        @foreach ($nacimientos as $nacimiento)
                                            <option value="{{ $nacimiento->id_nacimiento }}" {{ old('id_nacimiento') == $nacimiento->id_nacimiento ? 'selected' : '' }}>
                                                {{ $nacimiento->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_nacimiento')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
    <label for="fecha">Fecha de Deceso</label>
    <input type="date" name="fecha" class="form-control" value="{{ old('fecha', now()->format('Y-m-d')) }}" required>
</div>
                                <div class="form-group">
                                    <label for="causas">Causas</label>
                                    <input type="text" name="causas" class="form-control" maxlength="50" required>
                                </div>

                                <div class="form-group">
                                    <label for="diagnostico">Diagnóstico</label>
                                    <input type="text" name="diagnostico" class="form-control" maxlength="50" required>
                                </div>

                                <div class="form-group">
                                    <label for="tratamiento">Tratamiento</label>
                                    <input type="text" name="tratamiento" class="form-control" maxlength="50" required>
                                </div>

                                <div class="form-group">
                                    <label for="medico_veterinario">Médico Veterinario</label>
                                    <input type="text" name="medico_veterinario" class="form-control" maxlength="50" required>
                                </div>

                                <div class="form-group">
        <label for="laboratorio_archivo">Subir  laboratorio  en Archivo PDF</label>
        <input type="file" class="form-control" id="laboratorio_archivo" name="laboratorio_archivo">
    </div>
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


   

<script>
    function setDeleteAction(action) {
        document.getElementById('deleteForm').action = action;
    }
</script>
@endsection
