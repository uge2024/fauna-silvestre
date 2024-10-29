@extends('layouts.admin')

@section('contenido')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Detalles del Municipio</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('municipio.index') }}">Municipios</a></li>
                    <li class="breadcrumb-item active">Detalles</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Detalles del Municipio</h3>
                    </div>
                    <div class="card-body">
                        <!-- Mostrar detalles del municipio -->
                        <p><strong>ID:</strong> {{ $municipio->id_municipio }}</p>
                        <p><strong>Departamento:</strong> {{ $municipio->departamento }}</p>
                        <p><strong>Nombre:</strong> {{ $municipio->nombre }}</p>
                        <p><strong>Código:</strong> {{ $municipio->codigo }}</p>

                        
                        <a href="{{ route('municipio.index') }}" class="btn btn-secondary">Volver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
