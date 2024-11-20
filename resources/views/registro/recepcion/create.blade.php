@extends('layouts.admin')

@section('contenido')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Nueva Recepción</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Recepciones</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="section">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <!-- Mostrar errores de validación -->
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('recepcion.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                               
                            <div class="form-group">
    <label for="id_institucion_recibida">INSTITUCIÓN  RESPONABLE DE RESCATE/DECOMISO</label>
    <select name="id_institucion_recibida" class="form-control" required>
        @foreach ($instituciones as $institucion)
            <option value="{{ $institucion->id_institucion }}">
                {{ $institucion->nombre }}
            </option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="responsable_decomiso">Persona Responsable del Decomiso</label>
    <input type="text" name="responsable_decomiso" id="responsable_decomiso" class="form-control" required>
</div>


                                <div class="form-group">
                                    <label for="id_institucion">INSTITUCIÓN  QUE RECIBE </label>
                                    <select name="id_institucion" class="form-control" required>
                                        @foreach ($instituciones as $institucion)
                                            <option value="{{ $institucion->id_institucion }}">
                                                {{ $institucion->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="form-group">
    <label for="fecha">Fecha registro</label>
    <input type="date" name="fecha" class="form-control" value="{{ old('fecha', now()->format('Y-m-d')) }}" required>
</div>
                                <div class="form-group">
    <label for="motivo_recepcion">Motivo de Recepción</label>
    <select name="motivo_recepcion" class="form-control" required>
        <option value="">Seleccione un motivo</option>
        <option value="Rescate">Rescate</option>
        <option value="Confiscación">Decomiso</option>
        <option value="Traslado">Traslado</option>

    </select>
</div>
                                
<div class="form-group">
    <label for="codigo_animal">Código del Animal (se generará automáticamente)</label>
    <input type="text" name="codigo_animal"id="codigo_animal" class="form-control" value="{{ old('codigo_animal') }}" maxlength="50"readonly>
</div>



                                <div class="form-group">
                                    <label for="nombre">Nombre común</label>
                                    <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" maxlength="50" required>
                                </div>
                                <div class="form-group">
                                <label for="clase">Clase</label>
                                <select name="clase" id="clase" class="form-control" required>
                                    <option value="">Seleccione una clase</option>
                                    <option value="Mamífero">Mamífero</option>
                                    <option value="Ave">Ave</option>
                                    <option value="Reptil">Reptil</option>
                                    <option value="Anfibio">Anfibio</option>
                                    <option value="Pez">Pez</option>
                                   
                                </select>
                            </div>
                            
                                <div class="form-group">
                                <label for="especie">Especie</label>
                                <input type="text"name="especie" class="form-control" value="{{ old('especie') }}" maxlength="50" required>
                                    
                            </div>

                           
                            <div class="form-group">
    <label for="fotografia">Fotografía</label>
    <input type="file" name="fotografia" class="form-control-file" id="fotografia" onchange="previewImage(event)">
</div>

<!-- Contenedor para la previsualización de la imagen -->
<div id="imagePreview" style="width: 4rem; height: 4rem; overflow: hidden; border: 1px solid #ccc; border-radius: 5px;">
    <img id="preview" src="#" alt="Vista previa" style="width: 100%; height: 100%; object-fit: cover; display: none;">
</div>

<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('preview');
            output.src = reader.result;
            output.style.display = 'block';  // Mostrar la imagen
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

                                <div class="form-group">
    <label for="edad">Edad</label>
    <select name="edad" class="form-control" required>
        <option value="">Seleccione una edad</option>
        <option value="Juvenil">Neonato</option>
        <option value="Juvenil">Juvenil</option>
        <option value="Sub Adulto">Sub Adulto</option>
        <option value="Adulto">Adulto</option>
        <option value="Anciano">Anciano</option>
    </select>
</div>
                            
    <div class="form-group">
        <label for="estado">Estado general</label>
        <select name="estado" class="form-control" required>
        <option value="">Seleccione un estado</option>
            <option value="Estable" {{ old('estado') == 'Estable' ? 'selected' : '' }}>Estable</option>
            <option value="Aparentemente normal" {{ old('estado') == 'Aparentemente normal' ? 'selected' : '' }}>Aparentemente normal</option>
            <option value="Herido" {{ old('estado') == 'Herido' ? 'selected' : '' }}>Herido</option>
            <option value="Enfermo" {{ old('estado') == 'Enfermo' ? 'selected' : '' }}>Enfermo</option>
            <option value="Muerto" {{ old('estado') == 'Muerto' ? 'selected' : '' }}>Muerto</option>
        </select>
    </div>
    </div>
    <div class="col-md-6">

                                <div class="form-group">
    <label for="sexo">Sexo</label>
    <select name="sexo" class="form-control" required>
        <option value="">Seleccione el sexo</option>
        <option value="Macho">Macho</option>
        <option value="Hembra">Hembra</option>
        <option value="Desconocido">Desconocido</option>

    </select>
</div>
<div class="form-group">
    <label for="color">Color</label>
    <input type="color" name="color" id="color" class="form-control" value="{{ old('color') }}" required>
</div>


    <div class="form-group">
    <label for="descripcion_color">Descripción del Color(opcional)</label>
    <input type="text" name="descripcion_color" class="form-control" value="{{ old('descripcion_color') }}" maxlength="300">
</div>
                                <div class="form-group">
    <label for="comportamiento">Comportamiento</label>
    <select name="comportamiento" class="form-control" required>
        <option value="">Seleccione una opción</option>
        <option value="Tranquilo">Tranquilo</option>
        <option value="Hiperactivo">Hiperactivo</option>
        <option value="Agresivo">Agresivo</option>
        <option value="Decaido">Decaido</option>

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
    <label for="contacto_animales">Contacto con Otros Animales</label>
    <select name="contacto_animales" class="form-control" required>
        <option value="">Seleccione una opción</option>
        <option value="Perros">Perros</option>
        <option value="Gatos">Gatos</option>
        <option value="Aves de Traspatio">Aves de Traspatio</option>
        <option value="Grandes y pequeños rumiantes">Grandes y pequeños rumiantes</option>
        <option value="Equinos">Equinos</option>
        <option value="Animales Introducidos (Exóticos)">Animales Introducidos (Exóticos)</option>
        <option value="solo">solo</option>
        <option value="otro">otro</option>
    </select>
</div>

<div class="form-group">
    <label for="sospech_enfermedad">Sospecha de Enfermedad(opcional)</label>
    <input type="text" name="sospech_enfermedad" class="form-control" value="{{ old('sospech_enfermedad') }}" maxlength="300">
</div>
<div class="form-group">
    <label for="alteraciones_heridas">Alteraciones o Heridas(opcional)</label>
    <input type="text" name="alteraciones_heridas" class="form-control" value="{{ old('alteraciones_heridas') }}" maxlength="300">
</div>
<div class="form-group">
    <label for="observaciones">Observaciones(opcional)</label>
    <input type="text" name="observaciones" class="form-control" value="{{ old('observaciones') }}" maxlength="300">
</div>
<div class="form-group">
    <label for="tiempo_cautiverio">Tiempo en Cautiverio(opcional)</label>
    <input type="text" name="tiempo_cautiverio" class="form-control" value="{{ old('tiempo_cautiverio') }}" maxlength="300">
</div>
<div class="form-group">
    <label for="medicacion">Medicación(opcional)</label>
    <input type="text" name="medicacion" class="form-control" value="{{ old('medicacion') }}" maxlength="300">
</div>
<div class="form-group">
    <label for="alimentacion">Alimentación(opcional)</label>
    <input type="text" name="alimentacion" class="form-control" value="{{ old('alimentacion') }}" maxlength="300">
</div>

                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <a href="{{ route('recepcion.index') }}" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
