@extends('layouts.admin')

@section('contenido')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Editar Nacimiento</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('nacimiento.index') }}">Nacimientos</a></li>
                    <li class="breadcrumb-item active">Editar</li>
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
                        <h3 class="card-title">Formulario de Edición de Nacimiento</h3>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('nacimiento.update', $nacimiento->id_nacimiento) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="id_institucion">Institución</label>
                                <select name="id_institucion" id="id_institucion" class="form-control" required>
                                    <option value="">Seleccionar Institución</option>
                                    @foreach($instituciones as $institucion)
                                        <option value="{{ $institucion->id_institucion }}" {{ old('id_institucion', $nacimiento->id_institucion) == $institucion->id_institucion ? 'selected' : '' }}>{{ $institucion->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
            <label for="id_recepcion">Madre/Padre</label>
            <select name="id_recepcion" id="id_recepcion" class="form-control">
                <option value="">Seleccione una recepción</option>
                @foreach($recepciones as $recepcion)
                    <option value="{{ $recepcion->id_recepcion }}" 
                        {{ old('id_recepcion', $nacimiento->id_recepcion) == $recepcion->id_recepcion ? 'selected' : '' }}>
                        {{ $recepcion->nombre }} <!-- Asegúrate de tener un campo descriptivo aquí -->
                    </option>
                @endforeach
            </select>
            @error('id_recepcion')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
                            <div class="form-group">
                                <label for="fecha">Fecha</label>
                                <input type="date" name="fecha" id="fecha" class="form-control" value="{{ old('fecha', $nacimiento->fecha) }}" required>
                            </div>

                            <div class="form-group">
                                <label for="codigo">Código (se generará automáticamente)</label>
                                <input type="text" name="codigo" id="codigo" class="form-control" value="{{ old('codigo', $nacimiento->codigo) }}" maxlength="50" readonly>
                            </div>

                            <div class="form-group">
                                <label for="clase">clase</label>
                                <select name="clase" id="clase" class="form-control" required>
                                    <option value="">Seleccione una clase</option>
                                    <option value="Mamífero" {{ old('especie', $nacimiento->clase) == 'Mamífero' ? 'selected' : '' }}>Mamífero</option>
                                    <option value="Ave" {{ old('especie', $nacimiento->clase) == 'Ave' ? 'selected' : '' }}>Ave</option>
                                    <option value="Reptil" {{ old('especie', $nacimiento->clase) == 'Reptil' ? 'selected' : '' }}>Reptil</option>
                                    <option value="Anfibio" {{ old('especie', $nacimiento->clase) == 'Anfibio' ? 'selected' : '' }}>Anfibio</option>
                                    <option value="Otros" {{ old('especie', $nacimiento->clase) == 'Otros' ? 'selected' : '' }}>Otros</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="sexo">Sexo</label>
                                <select name="sexo" id="sexo" class="form-control" required>
                                    <option value="">Seleccione el sexo</option>
                                    <option value="Macho" {{ old('sexo', $nacimiento->sexo) == 'Macho' ? 'selected' : '' }}>Macho</option>
                                    <option value="Hembra" {{ old('sexo', $nacimiento->sexo) == 'Hembra' ? 'selected' : '' }}>Hembra</option>
                                    <option value="Desconocido" {{ old('sexo', $nacimiento->sexo) == 'Desconocido' ? 'selected' : '' }}>Desconocido</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $nacimiento->nombre) }}" required maxlength="50">
                            </div>

                            <div class="form-group">
                                <label for="fotografia">Fotografía</label>
                                <input type="file" name="fotografia" id="fotografia" class="form-control">
                            </div>
                            
                            <div class="form-group">
                                <label for="peso">Peso</label>
                                <input type="text" name="peso" id="peso" class="form-control" value="{{ old('peso', $nacimiento->peso) }}" required maxlength="50">
                            </div>

                            <div class="form-group">
                                <label for="edad">Edad</label>
                                <select name="edad" id="edad" class="form-control" required>
                                    <option value="" disabled selected>Seleccione una edad</option>
                                    <option value="Nacido" {{ old('edad', $nacimiento->edad) == 'Nacido' ? 'selected' : '' }}>Nacido</option>
                                    <option value="Neonato" {{ old('edad', $nacimiento->edad) == 'Neonato' ? 'selected' : '' }}>Neonato</option>
                                    <option value="Juvenil" {{ old('edad', $nacimiento->edad) == 'Juvenil' ? 'selected' : '' }}>Juvenil</option>
                                </select>
                            </div>

                            <div class="form-group">
    <label for="estado_trasferencia">Estado de Transferencia</label>
    <select name="estado_trasferencia" id="estado_trasferencia" class="form-control" disabled>
        <option value="pendiente">Pendiente</option>
        <option value="transferido">Transferido</option>
    </select>
</div>


                            <div class="form-group">
                                <label for="señas">Señas (opcional)</label>
                                <input type="text" name="señas" id="señas" class="form-control" value="{{ old('señas', $nacimiento->señas) }}" maxlength="50">
                            </div>

                            

                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <a href="{{ route('nacimiento.index') }}" class="btn btn-secondary">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection


