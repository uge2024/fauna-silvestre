@extends('layouts.admin')

@section('contenido')
<div class="container">
<h3>Detalles de la Transferencia</h3>
<p>ID: {{ $transferencia->id_transferencia }}</p>

<p>Institución Responsable: {{ $transferencia->institucion->nombre }}</p>
<p>Recepción: {{ $transferencia->recepcion ? $transferencia->recepcion->nombre : 'N/A' }}</p>
<p>Nacimiento: {{ $transferencia->nacimiento ? $transferencia->nacimiento->nombre : 'N/A' }}</p>
<p>Fecha: {{ $transferencia->fecha }}</p>
<p>Transporte: {{ $transferencia->transporte }}</p>
<p>Motivo de Transferencia: {{ $transferencia->motivo_transferencia }}</p>
<p>describir_destino: {{ $transferencia->describir_destino }}</p>
<p>Institución Destino: {{ $transferencia->institucionDestino->nombre }}</p>

            <a href="{{ route('transferencia.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>
</div>
@endsection
