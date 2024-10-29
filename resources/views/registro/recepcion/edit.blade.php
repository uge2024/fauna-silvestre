@extends('layouts.admin')

@section('contenido')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Editar Recepción</h1>
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

                    <form action="{{ route('recepcion.update', $recepcion->id_recepcion) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id_institucion">Institución</label>
                                    <select name="id_institucion" class="form-control" required>
                                        @foreach ($instituciones as $institucion)
                                            <option value="{{ $institucion->id_institucion }}" {{ $recepcion->id_institucion == $institucion->id_institucion ? 'selected' : '' }}>
                                                {{ $institucion->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                <label for="fecha">Fecha</label>
                                <input type="date" name="fecha" id="fecha" class="form-control" 
       value="{{ old('fecha', isset($recepcion->fecha) ? \Carbon\Carbon::parse($recepcion->fecha)->format('Y-m-d') : '') }}" required>
  </div>
                                <div class="form-group">
                                    <label for="motivo_recepcion">Motivo de Recepción</label>
                                    <select name="motivo_recepcion" class="form-control" required>
                                        <option value="">Seleccione un motivo</option>
                                        <option value="Rescate" {{ $recepcion->motivo_recepcion == 'Rescate' ? 'selected' : '' }}>Rescate</option>
                                        <option value="Confiscación" {{ $recepcion->motivo_recepcion == 'Confiscación' ? 'selected' : '' }}>Confiscación</option>
                                        <option value="Entrega Voluntaria" {{ $recepcion->motivo_recepcion == 'Entrega Voluntaria' ? 'selected' : '' }}>Entrega Voluntaria</option>
                                        <option value="Traslado" {{ $recepcion->motivo_recepcion == 'Traslado' ? 'selected' : '' }}>Traslado</option>
                                        <option value="Otro" {{ $recepcion->motivo_recepcion == 'Otro' ? 'selected' : '' }}>Otro</option>
                                    </select>
                                </div>
                                

                                <div class="form-group">
                                <label for="codigo_animal">Código (se generará automáticamente)</label>
                                <input type="text" name="codigo_animal" id="codigo_animal" class="form-control" value="{{ old('codigo_animal', $recepcion->codigo_animal) }}" maxlength="50" readonly>
                            </div>

                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" name="nombre" class="form-control" value="{{ $recepcion->nombre }}" maxlength="50" required>
                                </div>
                                <div class="form-group">
                                    <label for="clase">Clase</label>
                                    <select name="clase" id="clase" class="form-control" required>
                                        <option value="">Seleccione una clase</option>
                                        <option value="Mamífero" {{ $recepcion->clase == 'Mamífero' ? 'selected' : '' }}>Mamífero</option>
                                        <option value="Ave" {{ $recepcion->clase == 'Ave' ? 'selected' : '' }}>Ave</option>
                                        <option value="Reptil" {{ $recepcion->clase == 'Reptil' ? 'selected' : '' }}>Reptil</option>
                                        <option value="Anfibio" {{ $recepcion->clase == 'Anfibio' ? 'selected' : '' }}>Anfibio</option>
                                        <option value="Pez" {{ $recepcion->clase == 'Pez' ? 'selected' : '' }}>Pez</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="especie">Especie</label>
                                    <input type="text" name="especie" class="form-control" value="{{ $recepcion->especie }}" maxlength="50" required>
                                </div>
                                <div class="form-group">
    <label for="fotografia">Fotografía</label>
    <input type="file" name="fotografia" class="form-control-file">
    @if($recepcion->fotografia)
        <div class="mt-2">
            <img src="{{ asset('imagenes/recepcion/'.$recepcion->fotografia) }}" alt="Fotografía del animal" width="150">
        </div>
        <small class="form-text text-muted">Si no desea cambiar la imagen, deje este campo sin seleccionar.</small>
    @endif
</div>

                                <div class="form-group">
                                    <label for="edad">Edad</label>
                                    <select name="edad" class="form-control" required>
                                        <option value="">Seleccione una edad</option>
                                        <option value="Neonato" {{ $recepcion->edad == 'Neonato' ? 'selected' : '' }}>Neonato</option>
                                        
                                        <option value="Sub Adulto" {{ $recepcion->edad == 'Sub Adulto' ? 'selected' : '' }}>Sub Adulto</option>
                                        <option value="Juvenil" {{ $recepcion->edad == 'Juvenil' ? 'selected' : '' }}>Juvenil</option>
                                        <option value="Adulto" {{ $recepcion->edad == 'Adulto' ? 'selected' : '' }}>Adulto</option>
                                        <option value="Anciano" {{ $recepcion->edad == 'Anciano' ? 'selected' : '' }}>Anciano</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="estado">Estado general</label>
                                    <select name="estado" class="form-control" required>
                                        <option value="Estable" {{ $recepcion->estado == 'Estable' ? 'selected' : '' }}>Estable</option>
                                        <option value="Aparentemente normal" {{ $recepcion->estado == 'Aparentemente normal' ? 'selected' : '' }}>Aparentemente normal</option>
                                        <option value="Herido" {{ $recepcion->estado == 'Herido' ? 'selected' : '' }}>Herido</option>
                                        <option value="Enfermo" {{ $recepcion->estado == 'Enfermo' ? 'selected' : '' }}>Enfermo</option>
                                        <option value="Muerto" {{ $recepcion->estado == 'Muerto' ? 'selected' : '' }}>Muerto</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sexo">Sexo</label>
                                    <select name="sexo" class="form-control" required>
                                        <option value="">Seleccione el sexo</option>
                                        <option value="Macho" {{ $recepcion->sexo == 'Macho' ? 'selected' : '' }}>Macho</option>
                                        <option value="Hembra" {{ $recepcion->sexo == 'Hembra' ? 'selected' : '' }}>Hembra</option>
                                        <option value="Desconocido" {{ $recepcion->sexo == 'Desconocido' ? 'selected' : '' }}>Desconocido</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="color">Color</label>
                                    <input type="color" name="color" class="form-control" value="{{ $recepcion->color }}" maxlength="50" required>
                                </div>
                                <div class="form-group">
                                    <label for="descripcion_color">descripcion_color</label>
                                    <input type="text" name="descripcion_color" class="form-control" value="{{ $recepcion->descripcion_color }}" maxlength="300">
                                </div>

                                <div class="form-group">
                                    <label for="comportamiento">Comportamiento</label>
                                    <select name="comportamiento" class="form-control" required>
                                        <option value="">Seleccione una opción</option>
                                        <option value="Tranquilo" {{ $recepcion->comportamiento == 'Tranquilo' ? 'selected' : '' }}>Tranquilo</option>
                                        <option value="Hiperactivo" {{ $recepcion->comportamiento == 'Hiperactivo' ? 'selected' : '' }}>Hiperactivo</option>
                                        <option value="Agresivo" {{ $recepcion->comportamiento == 'Agresivo' ? 'selected' : '' }}>Agresivo</option>
                                        <option value="Decaido" {{ $recepcion->comportamiento == 'Decaido' ? 'selected' : '' }}>Decaido</option>
                                        <option value="Otro" {{ $recepcion->comportamiento == 'Otro' ? 'selected' : '' }}>Otro</option>
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
                                    <label for="sospech_enfermedad">Sospecha de Enfermedad</label>
                                    <input type="text" name="sospech_enfermedad" class="form-control" value="{{ $recepcion->sospech_enfermedad }}" maxlength="300">
                                </div>
                                <div class="form-group">
                                    <label for="alteraciones_heridas">Alteraciones o Heridas</label>
                                    <input type="text" name="alteraciones_heridas" class="form-control" value="{{ $recepcion->alteraciones_heridas }}" maxlength="300">
                                </div>
                                <div class="form-group">
                                    <label for="observaciones">Observaciones</label>
                                    <input type="text" name="observaciones" class="form-control" value="{{ $recepcion->observaciones }}" maxlength="300">
                                </div>
                                <div class="form-group">
                                    <label for="tiempo_cautiverio">Tiempo en Cautiverio</label>
                                    <input type="text" name="tiempo_cautiverio" class="form-control" value="{{ $recepcion->tiempo_cautiverio }}" maxlength="300">
                                </div>
                                <div class="form-group">
                                    <label for="contacto_animales">Contacto con Otros Animales</label>
                                    <select name="contacto_animales" class="form-control" required>
                                        <option value="">Seleccione una opción</option>
                                        <option value="Perros" {{ $recepcion->contacto_animales == 'Perros' ? 'selected' : '' }}>Perros</option>
                                        <option value="Gatos" {{ $recepcion->contacto_animales == 'Gatos' ? 'selected' : '' }}>Gatos</option>
                                        <option value="Aves de Traspatio" {{ $recepcion->contacto_animales == 'Aves de Traspatio' ? 'selected' : '' }}>Aves de Traspatio</option>
                                        <option value="Grandes y pequeños rumiantes" {{ $recepcion->contacto_animales == 'Grandes y pequeños rumiantes' ? 'selected' : '' }}>Grandes y pequeños rumiantes</option>
                                        <option value="Equinos" {{ $recepcion->contacto_animales == 'Equinos' ? 'selected' : '' }}>Equinos</option>
                                        <option value="Animales Introducidos (Exóticos)" {{ $recepcion->contacto_animales == 'Animales Introducidos (Exóticos)' ? 'selected' : '' }}>Animales Introducidos (Exóticos)</option>
                                        <option value="solo" {{ $recepcion->contacto_animales == 'solo' ? 'selected' : '' }}>solo</option>
                                        <option value="otro" {{ $recepcion->contacto_animales == 'otro' ? 'selected' : '' }}>otro</option>
                                    
                                    
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="medicacion">Medicación</label>
                                    <input type="text" name="medicacion" class="form-control" value="{{ $recepcion->medicacion }}" maxlength="300">
                                </div>
                                <div class="form-group">
                                    <label for="alimentacion">Alimentación</label>
                                    <input type="text" name="alimentacion" class="form-control" value="{{ $recepcion->alimentacion }}" maxlength="300">
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
