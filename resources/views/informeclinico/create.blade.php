@extends('layouts.admin')

@section('contenido')
<!-- Incluir jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Incluir jQuery UI -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Nuevo Informe Clínico</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('informeclinico.index') }}">Informes Clínicos</a></li>
                    <li class="breadcrumb-item active">Nuevo</li>
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
                    <h3 class="card-title">Formulario de Nuevo Informe Clínico</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('informeclinico.store') }}" method="POST">
                        @csrf
                        
                        <div class="form-group">
                                    <label for="id_institucion">Institución</label>
                                    <select name="id_institucion" class="form-control" required>
                                        @foreach ($instituciones as $institucion)
                                            <option value="{{ $institucion->id_institucion }}">{{ $institucion->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>


                        <!-- Campo con Select2 habilitado para búsqueda -->
                        
                        <div class="form-group">
                            <label for="id_recepcion">Animal  de Recepción:</label>
                            <input type="text" name="animal_recepcion" id="animal_recepcion" class="form-control" placeholder="Escribe el nombre del animal">
                            <input type="hidden" name="id_recepcion" id="id_recepcion">
                            @error('id_recepcion')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>  

                <!-- Campo de texto con Autocomplete para Nacimiento -->
                <div class="form-group">
                            <label for="id_nacimiento">animal de Nacimiento:</label>
                            <input type="text" name="nombre_nacimiento" id="nombre_nacimiento" class="form-control" placeholder="Escribe el nombre del nacimiento">
                            <input type="hidden" name="id_nacimiento" id="id_nacimiento">
                            @error('id_nacimiento')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
    <label for="fecha">Fecha ficha clinica</label>
    <input type="date" name="fecha" class="form-control" value="{{ old('fecha', now()->format('Y-m-d')) }}" required>
</div>
                        <div class="form-group">
                            <label for="anamnesis">Anamnesis:</label>
                            <textarea name="anamnesis" id="anamnesis" class="form-control" rows="3">{{ old('anamnesis') }}</textarea>
                            @error('anamnesis')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="diagnostico">Diagnóstico:</label>
                            <textarea name="diagnostico" id="diagnostico" class="form-control" rows="3">{{ old('diagnostico') }}</textarea>
                            @error('diagnostico')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tratamiento">Tratamiento:</label>
                            <textarea name="tratamiento" id="tratamiento" class="form-control" rows="3">{{ old('tratamiento') }}</textarea>
                            @error('tratamiento')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="programa_sanitario">Programa Sanitario:</label>
                            <input type="text" name="programa_sanitario" id="programa_sanitario" class="form-control" value="{{ old('programa_sanitario') }}">
                            @error('programa_sanitario')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="veterinario">Veterinario:</label>
                            <input type="text" name="veterinario" id="veterinario" class="form-control" value="{{ old('veterinario') }}">
                            @error('veterinario')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <a href="{{ route('informeclinico.index') }}" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>


<script>
$(document).ready(function() {
    var recepciones = @json($recepciones);

    $('#animal_recepcion').autocomplete({
        source: function(request, response) {
            var results = $.map(recepciones, function(recepcion) {
                if (recepcion.nombre.toLowerCase().indexOf(request.term.toLowerCase()) !== -1) {
                    return {
                        label: recepcion.nombre,
                        value: recepcion.nombre,
                        id: recepcion.id_recepcion
                    };
                }
            });
            response(results);
        },
        select: function(event, ui) {
            $('#id_recepcion').val(ui.item.id);
        }
    });
});
</script>
<script>
$(document).ready(function() {
    var recepciones = @json($recepciones);
    var nacimientos = @json($nacimientos);

    $('#animal_recepcion').autocomplete({
        source: function(request, response) {
            var results = $.map(recepciones, function(recepcion) {
                if (recepcion.nombre.toLowerCase().indexOf(request.term.toLowerCase()) !== -1) {
                    return {
                        label: recepcion.nombre,
                        value: recepcion.nombre,
                        id: recepcion.id_recepcion
                    };
                }
            });
            response(results);
        },
        select: function(event, ui) {
            $('#id_recepcion').val(ui.item.id);
        }
    });

    $('#nombre_nacimiento').autocomplete({
        source: function(request, response) {
            var results = $.map(nacimientos, function(nacimiento) {
                if (nacimiento.nombre.toLowerCase().indexOf(request.term.toLowerCase()) !== -1) {
                    return {
                        label: nacimiento.nombre,
                        value: nacimiento.nombre,
                        id: nacimiento.id_nacimiento
                    };
                }
            });
            response(results);
        },
        select: function(event, ui) {
            $('#id_nacimiento').val(ui.item.id);
        }
    });
});
</script>

@endsection
