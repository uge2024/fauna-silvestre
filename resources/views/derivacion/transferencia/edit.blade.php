@extends('layouts.admin')

@section('contenido')
<h3>Editar Transferencia</h3>

<form action="{{ route('transferencia.update', $transferencia->id_transferencia) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="id_institucion">Institución Actual</label>
        <select name="id_institucion" id="id_institucion" class="form-control">
            @foreach($instituciones as $institucion)
                <option value="{{ $institucion->id_institucion }}" {{ old('id_institucion', $transferencia->id_institucion) == $institucion->id_institucion ? 'selected' : '' }}>
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
                <option value="{{ $recepcion->id_recepcion }}" {{ old('id_recepcion', $transferencia->id_recepcion) == $recepcion->id_recepcion ? 'selected' : '' }}>
                    {{ $recepcion->nombre }}
                </option>
            @endforeach
        </select>
    </div>
    
    <div class="form-group">
        <label for="id_nacimiento">Animal Registrado de Nacimiento</label>
        <select name="id_nacimiento" id="id_nacimiento" class="form-control">
            <option value="">Seleccione...</option>
            @foreach($nacimientos as $nacimiento)
                <option value="{{ $nacimiento->id_nacimiento }}" {{ old('id_nacimiento', $transferencia->id_nacimiento) == $nacimiento->id_nacimiento ? 'selected' : '' }}>
                    {{ $nacimiento->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="fecha">Fecha</label>
        <input type="date" name="fecha" id="fecha" class="form-control" value="{{ old('fecha', $transferencia->fecha) }}">
    </div>

    <div class="form-group">
        <label for="transporte">Transporte</label>
        <select name="transporte" id="transporte" class="form-control">
            <option value="via_aerea" {{ old('transporte', $transferencia->transporte) == 'via_aerea' ? 'selected' : '' }}>Vía Aérea</option>
            <option value="via_terrestre" {{ old('transporte', $transferencia->transporte) == 'via_terrestre' ? 'selected' : '' }}>Vía Terrestre</option>
        </select>
    </div>

    <div class="form-group">
        <label for="describir_destino">Describir Destino</label>
        <input type="text" name="describir_destino" id="describir_destino" class="form-control" value="{{ old('describir_destino', $transferencia->describir_destino ) }}">
    </div>

    <div class="form-group">
        <label for="motivo_transferencia">Motivo de Transferencia</label>
        <input type="text" name="motivo_transferencia" id="motivo_transferencia" class="form-control" value="{{ old('motivo_transferencia', $transferencia->motivo_transferencia) }}">
    </div>

    <div class="form-group">
        <label for="institucion_destino">Institución Destino</label>
        <select name="institucion_destino" id="institucion_destino" class="form-control">
            @foreach($instituciones as $institucion)
                <option value="{{ $institucion->id_institucion }}" {{ old('institucion_destino', $transferencia->institucion_destino) == $institucion->id_institucion ? 'selected' : '' }}>
                    {{ $institucion->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a href="{{ route('transferencia.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
