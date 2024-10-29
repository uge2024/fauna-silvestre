@extends('layouts.admin')

@section('contenido')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Nueva Institución</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Nueva Institución</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8"> <!-- Se aumenta el tamaño del formulario -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Formulario de Nueva Institución</h3>
                    </div>
                    <form action="{{ route('institucion.store') }}" method="post" class="form">
                        @csrf
                        <div class="card-body">
                        <div class="form-group">
    <label for="departamento">Departamento</label>
    <input type="text" class="form-control" name="departamento" id="departamento" value="Cochabamba" readonly>
    @if ($errors->has('departamento'))
        <div class="alert alert-danger">{{ $errors->first('departamento') }}</div>
    @endif
</div>

<div class="form-group">
    <label for="id_municipio">Municipio</label>
    <select class="form-control" name="id_municipio" id="id_municipio" required>
    <option value="">Selecciona un municipio</option>
    @foreach($municipios as $municipio)
        <option value="{{ $municipio->id_municipio }}">{{ $municipio->nombre }}</option>
    @endforeach
</select>

</div>

                       

<div class="form-group">
    <label for="zona">Zona donde se encuentra la institucion(opcional)</label>
    <input type="text" class="form-control" name="zona" id="zona" placeholder="Ingresa la zona">
    @if ($errors->has('zona'))
        <div class="alert alert-danger">{{ $errors->first('zona') }}</div>
    @endif
</div>
<div class="form-group">
                                <label for="nombre">Nombre de la institucion</label>
                                <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Ingrese el nombre" required>
                                @if ($errors->has('nombre'))
                                    <div class="alert alert-danger">{{ $errors->first('nombre') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="codigo">Código</label>
                                <input type="text" class="form-control" name="codigo" id="codigo" placeholder="Ingresa el código" required>
                                @if ($errors->has('codigo'))
                                    <div class="alert alert-danger">{{ $errors->first('codigo') }}</div>
                                @endif
                            </div>
                            


                            <div class="form-group">
                                <label for="localizacion">Localización</label>
                                <input type="text" class="form-control" name="localizacion" id="localizacion" placeholder="Ingrese la localización en formato lat,long" required readonly>
                                @if ($errors->has('localizacion'))
                                    <div class="alert alert-danger">{{ $errors->first('localizacion') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="mapa">Ubicación en el Mapa</label>
                                <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#mapModal">
                                    Buscar en el Mapa
                                </button>
                                <div id="map" style="height: 500px; width: 100%;"></div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">Guardar</button>
                            <a href="{{ route('institucion.index') }}" class="btn btn-danger">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="mapModal" tabindex="-1" role="dialog" aria-labelledby="mapModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mapModalLabel">Buscar en el Mapa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input id="pac-input" class="controls form-control mb-3" type="text" placeholder="Buscar lugar">
                <div id="modal-map" style="height: 400px; width: 100%;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    var map, modalMap, markers = [];

    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: -17.3939, lng: -66.1568},
            zoom: 12
        });

        modalMap = new google.maps.Map(document.getElementById('modal-map'), {
            center: {lat: -17.3939, lng: -66.1568},
            zoom: 12
        });

        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        modalMap.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        searchBox.addListener('places_changed', function() {
            var places = searchBox.getPlaces();

            if (places.length == 0) {
                return;
            }

            markers.forEach(function(marker) {
                marker.setMap(null);
            });
            markers = [];

            var bounds = new google.maps.LatLngBounds();
            places.forEach(function(place) {
                if (!place.geometry) {
                    console.log("Returned place contains no geometry");
                    return;
                }

                var marker = new google.maps.Marker({
                    map: modalMap,
                    title: place.name,
                    position: place.geometry.location
                });

                markers.push(marker);

                document.getElementById('localizacion').value = place.geometry.location.lat() + ',' + place.geometry.location.lng();

                if (place.geometry.viewport) {
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }
            });
            modalMap.fitBounds(bounds);
        });

        modalMap.addListener('click', function(event) {
            markers.forEach(function(marker) {
                marker.setMap(null);
            });
            markers = [];

            var marker = new google.maps.Marker({
                position: event.latLng,
                map: modalMap
            });

            markers.push(marker);

            document.getElementById('localizacion').value = event.latLng.lat() + ',' + event.latLng.lng();
        });

        map.addListener('click', function(event) {
            markers.forEach(function(marker) {
                marker.setMap(null);
            });
            markers = [];

            var marker = new google.maps.Marker({
                position: event.latLng,
                map: map
            });

            markers.push(marker);

            document.getElementById('localizacion').value = event.latLng.lat() + ',' + event.latLng.lng();
        });
    }

    window.onload = initMap;
</script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDYgO5_33Ear1TZ43rcTgmCZX6RF8YPE5o&libraries=places&callback=initMap"></script>
@endsection
