@extends('layouts.admin')

@section('contenido')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Detalles del Usuario</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Usuario</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Información del Usuario</h3>
                    </div>
                    <div class="card-body">
                        <p><strong>Nombre:</strong> {{ $usuario->name }}</p>
                        <p><strong>Email:</strong> {{ $usuario->email }}</p>
                        <p><strong>role:</strong> {{ $usuario->role }}</p>
                        <!-- Puedes agregar más campos aquí según tu modelo de usuario -->
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('usuario.index') }}" class="btn btn-primary">Volver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
