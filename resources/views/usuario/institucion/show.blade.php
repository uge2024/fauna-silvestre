@extends('layouts.admin')

@section('contenido')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Detalles de Institución</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Detalles de Institución</li>
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
                        <h3 class="card-title">Detalles de Institución</h3>
                    </div>
                    <div class="card-body">
                        <!-- Mostrar detalles de la institución -->
                        <p><strong>Código:</strong> {{ $institucion->codigo }}</p>
                        <p><strong>Nombre:</strong> {{ $institucion->nombre }}</p>
                        <p><strong>Departamento:</strong> {{ $institucion->departamento }}</p>
                        <p><strong>Municipio:</strong> {{ $institucion->municipio ? $institucion->municipio->nombre : 'Sin municipio' }}</p>
                        
                        <p><strong>Zona:</strong> {{ $institucion->zona }}</p>
                        <p><strong>Localización:</strong> {{ $institucion->localizacion }}</p>

                        <!-- Mapa de Google Maps -->
                        <div id="map" style="height: 400px; width: 100%; margin-top: 20px; z-index: 999;"></div>
                        <a href="{{ route('institucion.index') }}" class="btn btn-secondary">Volver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function initMap() {
        var localizacion = '{{ $institucion->localizacion }}';
        var latLng = localizacion.split(',');
        var lat = parseFloat(latLng[0]);
        var lng = parseFloat(latLng[1]);

        var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: lat, lng: lng},
            zoom: 12
        });

        var marker = new google.maps.Marker({
            position: {lat: lat, lng: lng},
            map: map,
            title: 'Ubicación de la Institución'
        });
    }

    window.onload = initMap;
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDYgO5_33Ear1TZ43rcTgmCZX6RF8YPE5o&callback=initMap"></script>
@endsection
