@extends('layouts.admin')

@section('contenido')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Editar Municipio</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Editar Municipio</li>
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
                        <h3 class="card-title">Formulario de Edición de Municipio</h3>
                    </div>
                    <form action="{{ route('municipio.update', $municipio->id_municipio) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                        <div class="form-group">
    <label for="departamento">Departamento</label>
    <input type="text" class="form-control" name="departamento" id="departamento" value="Cochabamba" readonly>
    @if ($errors->has('departamento'))
        <div class="alert alert-danger">{{ $errors->first('departamento') }}</div>
    @endif
</div>
                           
                                <div class="form-group">
                                <label for="nombre">Nombre del Municipio</label>
                                <input type="text" class="form-control" name="nombre" id="nombre" value="{{ $municipio->nombre }}" required>
                                @error('nombre')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="codigo">Código</label>
                                <input type="text" class="form-control" name="codigo" id="codigo" value="{{ $municipio->codigo }}" required>
                                @error('codigo')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">Actualizar</button>
                            <a href="{{ route('municipio.index') }}" class="btn btn-danger">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
