@extends('layouts.admin')

@section('contenido')
<h3>Nueva Transferencia</h3>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{ route('transferencia.store') }}" method="POST">
    @csrf
    
    <div class="form-group">
        <label for="id_institucion">Institución Responsable</label>
        <select name="id_institucion" id="id_institucion" class="form-control">
            @foreach($instituciones as $institucion)
                <option value="{{ $institucion->id_institucion }}" {{ old('id_institucion') == $institucion->id_institucion ? 'selected' : '' }}>
                    {{ $institucion->nombre }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="id_recepcion">Animal Registrado por Recepción</label>
        <select name="id_recepcion" id="id_recepcion" class="form-control">
            <option value="">Seleccione...</option>
            @foreach($recepciones as $recepcion)
                <option value="{{ $recepcion->id_recepcion }}" {{ old('id_recepcion') == $recepcion->id_recepcion ? 'selected' : '' }}>
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
                <option value="{{ $nacimiento->id_nacimiento }}" {{ old('id_nacimiento') == $nacimiento->id_nacimiento ? 'selected' : '' }}>
                    {{ $nacimiento->codigo }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
    <label for="fecha">Fecha de transferencia</label>
    <input type="date" name="fecha" class="form-control" value="{{ old('fecha', now()->format('Y-m-d')) }}" required>
</div>
    <div class="form-group">
    <label for="transporte">Transporte</label>
    <select name="transporte" id="transporte" class="form-control">
        <option value="via_aerea" {{ old('transporte') == 'via_aerea' ? 'selected' : '' }}>Vía Aérea</option>
        <option value="via_terrestre" {{ old('transporte') == 'via_terrestre' ? 'selected' : '' }}>Vía Terrestre</option>
    </select>
</div>

    <div class="form-group">
        <label for="motivo_transferencia">Motivo de Transferencia</label>
        <input type="text" name="motivo_transferencia" id="motivo_transferencia" class="form-control" value="{{ old('motivo_transferencia') }}">
    </div>
    <div class="form-group">
    <label for="describir_destino">Describir Destino</label>
    <input type="text" name="describir_destino" id="describir_destino" class="form-control" value="{{ old('describir_destino', $transferencia->describir_destino ?? '') }}">
</div>

  
    <div class="form-group">
    <label for="institucion_destino">Institución Destino</label>
    <select name="institucion_destino" id="institucion_destino" class="form-control">
        @foreach($instituciones as $institucion)
            <option value="{{ $institucion->id_institucion }}" {{ old('institucion_destino') == $institucion->id_institucion ? 'selected' : '' }}>
                {{ $institucion->nombre }}
            </option>
        @endforeach
    </select>
</div>

    <button type="submit" class="btn btn-success">Guardar</button>
    <a href="{{ route('transferencia.index') }}" class="btn btn-secondary">Cancelar</a>
</form>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var idRecepcion = document.getElementById('id_recepcion');
        var idNacimiento = document.getElementById('id_nacimiento');

        function toggleFields() {
            if (idRecepcion.value) {
                idNacimiento.value = '';
                idNacimiento.disabled = true;
            } else if (idNacimiento.value) {
                idRecepcion.value = '';
                idRecepcion.disabled = true;
            } else {
                idRecepcion.disabled = false;
                idNacimiento.disabled = false;
            }
        }

        idRecepcion.addEventListener('change', toggleFields);
        idNacimiento.addEventListener('change', toggleFields);

        // Trigger the function on page load to set initial state
        toggleFields();
    });
</script>
@endsection
@endsection
