@extends('layouts.admin')

@section('contenido')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">editar Usuario</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Nuevo USUARIO</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">editar usuario</h3>
                    </div>
                    <form action="{{ route('usuario.update', $usuario->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="name">Nombre</label>
        <input type="text" class="form-control" value ="{{ $usuario->name }}" name="name" id="name" placeholder="Ingrese el nombre" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control"  value ="{{ $usuario->email }}" name="email" id="email" placeholder="Ingrese el email" required>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control"  name="password" id="password" placeholder="Ingrese el password">
    </div>
    
    <div class="form-group">
    <label for="role">Rol</label>
    <select class="form-control" name="role" id="role" required>
        @foreach($roles as $role)
            <option value="{{ $role->name }}" {{ $usuario->hasRole($role->name) ? 'selected' : '' }}>
                {{ ucfirst($role->name) }}
            </option>
        @endforeach
    </select>
</div>

    <div class="card-footer">
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('usuario.index') }}" class="btn btn-danger">Cancelar</a>
    </div>
</form>


                </div>
            </div>
        </div>
    </div>
</section>
@endsection
