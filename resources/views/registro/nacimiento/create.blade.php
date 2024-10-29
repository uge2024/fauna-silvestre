@extends('layouts.admin')

@section('contenido')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Crear Nacimiento</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('nacimiento.index') }}">Nacimientos</a></li>
                    <li class="breadcrumb-item active">Crear</li>
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
                        <h3 class="card-title">Formulario de Creación de Nacimiento</h3>
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

                        <form action="{{ route('nacimiento.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="form-group">
                                    <label for="id_institucion">Institución</label>
                                    <select name="id_institucion" class="form-control" required>
                                        @foreach ($instituciones as $institucion)
                                            <option value="{{ $institucion->id_institucion }}">{{ $institucion->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
    <label for="id_recepcion">Madre/Padre</label>
    <select name="id_recepcion" id="id_recepcion" class="form-control">
        <option value="">Seleccione La madre o padre del animal nacido</option>
        @foreach($recepciones as $recepcion)
            <option value="{{ $recepcion->id_recepcion }}" {{ old('id_recepcion') == $recepcion->id_recepcion ? 'selected' : '' }}>
                {{ $recepcion->nombre }} <!-- Asegúrate de tener un campo descriptivo aquí -->
            </option>
        @endforeach
    </select>
</div>
                            <div class="form-group">
    <label for="fecha">Fecha registro de nacimiento</label>
    <input type="date" name="fecha" class="form-control" value="{{ old('fecha', now()->format('Y-m-d')) }}" required>
</div>
                            <div class="form-group">
    <label for="codigo">Código (se generará automáticamente)</label>
    <input type="text" name="codigo" id="codigo" class="form-control" value="{{ old('codigo') }}" maxlength="50" readonly>
</div>

                            <div class="form-group">
    <label for="clase">clase</label>
    <select name="clase" id="clase" class="form-control" required>
        <option value="">Seleccione una clase</option>
        <option value="Mamífero" {{ old('especie') == 'Mamífero' ? 'selected' : '' }}>Mamífero</option>
        <option value="Ave" {{ old('especie') == 'Ave' ? 'selected' : '' }}>Ave</option>
        <option value="Reptil" {{ old('especie') == 'Reptil' ? 'selected' : '' }}>Reptil</option>
        <option value="Anfibio" {{ old('especie') == 'Anfibio' ? 'selected' : '' }}>Anfibio</option>
        <option value="Otros" {{ old('especie') == 'Otros' ? 'selected' : '' }}>Otros</option>
    </select>
</div>

<div class="form-group">
    <label for="sexo">Sexo</label>
    <select name="sexo" id="sexo" class="form-control" required>
        <option value="">Seleccione el sexo</option>
        <option value="Macho" {{ old('sexo') == 'Macho' ? 'selected' : '' }}>Macho</option>
        <option value="Hembra" {{ old('sexo') == 'Hembra' ? 'selected' : '' }}>Hembra</option>
        <option value="Desconocido" {{ old('sexo') == 'Desconocido' ? 'selected' : '' }}>Desconocido</option>
    </select>
</div>

                            <div class="form-group">
                                <label for="nombre">Nombre común</label>
                                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}" required maxlength="50">
                            </div>
                            <div class="form-group">
                                <label for="fotografia">Fotografía</label>
                                <input type="file" name="fotografia" id="fotografia" class="form-control">
                            </div>
                            
                            <div class="form-group">
                                <label for="peso">Peso</label>
                                <input type="text" name="peso" id="peso" class="form-control" value="{{ old('peso') }}" required maxlength="50">
                            </div>
                            <div class="form-group">
    <label for="edad">Edad</label>
    <select name="edad" id="edad" class="form-control" required>
        <option value="" disabled selected>Seleccione una edad</option>
        <option value="Nacido" {{ old('edad') == 'Nacido' ? 'selected' : '' }}>Nacido </option>
        <option value="Neonato" {{ old('edad') == 'Neonato' ? 'selected' : '' }}>Neonato </option>
        <option value="Juvenil" {{ old('edad') == 'Juvenil' ? 'selected' : '' }}>Juvenil </option>
     
    </select>
</div>
<div class="form-group">
    <label for="estado_trasferencia">Estado de Transferencia (se generará automáticamente)</label>
    <select name="estado_trasferencia" id="estado_trasferencia" class="form-control" disabled>
        <option value="pendiente" {{ old('estado_trasferencia') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
        <option value="transferido" {{ old('estado_trasferencia') == 'transferido' ? 'selected' : '' }}>Transferido</option>
    </select>
    <input type="hidden" name="estado_trasferencia" value="pendiente">
</div>



                            <div class="form-group">
                                <label for="señas">Señas o caracteristicas(opcional)</label>
                                <input type="text" name="señas" id="señas" class="form-control" value="{{ old('señas') }}"  maxlength="50">
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
