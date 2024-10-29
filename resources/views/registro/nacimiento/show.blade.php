@extends('layouts.admin')

@section('contenido')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Detalles del Nacimiento</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('nacimiento.index') }}">Nacimientos</a></li>
                    <li class="breadcrumb-item active">Detalles</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Detalles del Nacimiento</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Institución:</strong> {{ $nacimiento->institucion->nombre }}</p>
                                <p><strong>Madre/Padre:</strong> {{ $nacimiento->recepcion ? $nacimiento->recepcion->nombre : 'No disponible' }}</p>
                                <p><strong>Fecha:</strong> {{ $nacimiento->fecha }}</p>
                                <p><strong>Código:</strong> {{ $nacimiento->codigo }}</p>
                                <p><strong>Clase:</strong> {{ $nacimiento->clase }}</p>
                                <p><strong>Sexo:</strong> {{ $nacimiento->sexo }}</p>
                                <p><strong>Nombre común:</strong> {{ $nacimiento->nombre }}</p>
                                <p><strong>Peso:</strong> {{ $nacimiento->peso }}</p>
                                <p><strong>Edad:</strong> {{ $nacimiento->edad }}</p>
                                <p><strong>Señas o características:</strong> {{ $nacimiento->señas }}</p>
                            </div>
                            <div class="col-md-6">
                                @if($nacimiento->fotografia)
                                    <img src="{{ asset('imagenes/nacimientos/' . $nacimiento->fotografia) }}" class="img-fluid" alt="Fotografía">
                                @else
                                    <p>No hay fotografía disponible.</p>
                                @endif
                            </div>
                        </div>
                        <a href="{{ route('nacimiento.index') }}" class="btn btn-secondary">Regresar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
