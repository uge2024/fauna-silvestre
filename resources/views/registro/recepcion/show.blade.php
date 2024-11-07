@extends('layouts.admin')

@section('contenido')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Detalles de Recepción</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('recepcion.index') }}">Recepciones</a></li>
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
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <dl class="row">
                                    <dt class="col-sm-4">ID:</dt>
                                    <dd class="col-sm-8">{{ $recepcion->id_recepcion }}</dd>

                                    <dt class="col-sm-4">InstituciónResponsable del decomiso</dt>
                                    <dd class="col-sm-8">{{ $recepcion->institucionRecibida->nombre }}</dd>

                                    <dt class="col-sm-4">Institución_que recibe:</dt>
                                    <dd class="col-sm-8">{{ $recepcion->institucion->nombre }}</dd>


                                    <dt class="col-sm-4">Persona Responsable del decomiso</dt>
                                    <dd class="col-sm-8">{{ $recepcion->responsable_decomiso }}</dd>

                                    <dt class="col-sm-4">Fecha:</dt>
                                    <dd class="col-sm-8">{{ $recepcion->fecha }}</dd>

                                    <dt class="col-sm-4">Motivo de Recepción:</dt>
                                    <dd class="col-sm-8">{{ $recepcion->motivo_recepcion }}</dd>

                                    <dt class="col-sm-4">Código del Animal:</dt>
                                    <dd class="col-sm-8">{{ $recepcion->codigo_animal }}</dd>

                                    <dt class="col-sm-4">Nombre común:</dt>
                                    <dd class="col-sm-8">{{ $recepcion->nombre }}</dd>

                                    <dt class="col-sm-4">Clase:</dt>
                                    <dd class="col-sm-8">{{ $recepcion->clase }}</dd>

                                    <dt class="col-sm-4">Especie:</dt>
                                    <dd class="col-sm-8">{{ $recepcion->especie }}</dd>

                                    <dt class="col-sm-4">Edad:</dt>
                                    <dd class="col-sm-8">{{ $recepcion->edad }}</dd>

                                    <dt class="col-sm-4">Estado:</dt>
                                    <dd class="col-sm-8">{{ $recepcion->estado }}</dd>

                                    <dt class="col-sm-4">Sexo:</dt>
                                    <dd class="col-sm-8">{{ $recepcion->sexo }}</dd>

                                    <dt class="col-sm-4">Color:</dt>
                                    <dd class="col-sm-8">{{ $recepcion->color }}</dd>

                                    <dt class="col-sm-4">descripcion_color:</dt>
                                    <dd class="col-sm-8">{{ $recepcion->descripcion_color}}</dd>

                                    <dt class="col-sm-4">Comportamiento:</dt>
                                    <dd class="col-sm-8">{{ $recepcion->comportamiento }}</dd>

                                    <dt class="col-sm-4">Sospecha de Enfermedad:</dt>
                                    <dd class="col-sm-8">{{ $recepcion->sospech_enfermedad }}</dd>

                                    <dt class="col-sm-4">Alteraciones o Heridas:</dt>
                                    <dd class="col-sm-8">{{ $recepcion->alteraciones_heridas }}</dd>

                                    <dt class="col-sm-4">Observaciones:</dt>
                                    <dd class="col-sm-8">{{ $recepcion->observaciones }}</dd>

                                    <dt class="col-sm-4">Tiempo en Cautiverio:</dt>
                                    <dd class="col-sm-8">{{ $recepcion->tiempo_cautiverio }}</dd>

                                    <dt class="col-sm-4">Contacto con Otros Animales:</dt>
                                    <dd class="col-sm-8">{{ $recepcion->contacto_animales }}</dd>

                                    <dt class="col-sm-4">Medicación:</dt>
                                    <dd class="col-sm-8">{{ $recepcion->medicacion }}</dd>

                                    <dt class="col-sm-4">Alimentación:</dt>
                                    <dd class="col-sm-8">{{ $recepcion->alimentacion }}</dd>

                                    

                                    <dt class="col-sm-4">Fotografía:</dt>
                                    <dd class="col-sm-8">
                                        @if ($recepcion->fotografia)
                                            <img src="{{ asset('imagenes/recepcion/' . $recepcion->fotografia) }}" alt="{{ $recepcion->nombre }}" class="img-thumbnail" width="200">
                                        @else
                                            No disponible
                                        @endif
                                    </dd>
                                </dl>
                            </div>
                        </div>
                        <a href="{{ route('recepcion.index') }}" class="btn btn-secondary">Volver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
