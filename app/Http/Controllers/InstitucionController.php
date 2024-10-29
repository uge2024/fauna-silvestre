<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Institucion;
use App\Models\Municipio;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\InstitucionFornRequest;

class InstitucionController extends Controller
{
    /**
     * Constructor de la clase
     */
    public function __construct()
    {
        // Puedes agregar cualquier middleware aquí si es necesario
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = trim($request->get('searchText'));
        $instituciones = Institucion::where('departamento', 'LIKE', '%' . $query . '%')
            ->orWhere('nombre', 'LIKE', '%' . $query . '%')
            ->orderBy('id_institucion', 'desc')
            ->paginate(5);

        return view('usuario.institucion.index', ["instituciones" => $instituciones, "texto" => $query]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $municipios = Municipio::all(); // Obtiene todos los municipios
        return view("usuario.institucion.create", compact('municipios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InstitucionFornRequest $request)
    {
        $institucion = new Institucion();
        $institucion->id_municipio = $request->input('id_municipio');
        $institucion->codigo = $request->input('codigo');
        $institucion->nombre = $request->input('nombre');
        $institucion->departamento = $request->input('departamento');
        $institucion->zona = $request->input('zona');
        $institucion->localizacion = $request->input('localizacion');
    
        if ($institucion->save()) {
            return Redirect::to('usuario/institucion')->with('success', 'Institución creada exitosamente.');
        } else {
            return Redirect::back()->with('error', 'Error al crear la institución.');
        }
    }
    
    public function update(InstitucionFornRequest $request, $id)
    {
        $institucion = Institucion::findOrFail($id);
        $institucion->id_municipio = $request->input('id_municipio');
        $institucion->codigo = $request->input('codigo');
        $institucion->nombre = $request->input('nombre');
        $institucion->departamento = $request->input('departamento');
        $institucion->zona = $request->input('zona');
        $institucion->localizacion = $request->input('localizacion');
    
        if ($institucion->update()) {
            return Redirect::to('usuario/institucion')->with('success', 'Institución actualizada exitosamente.');
        } else {
            return Redirect::back()->with('error', 'Error al actualizar la institución.');
        }
    }
    
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $institucion = Institucion::findOrFail($id);
        $localizacion = json_decode($institucion->localizacion, true);

        $latitude = $localizacion['lat'] ?? null;
        $longitude = $localizacion['lng'] ?? null;

        return view("usuario.institucion.show", [
            "institucion" => $institucion,
            "latitude" => $latitude,
            "longitude" => $longitude
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $institucion = Institucion::findOrFail($id);
        $municipios = Municipio::all(); // Obtiene todos los municipios
        return view("usuario.institucion.edit", compact('institucion', 'municipios'));
    }

    /**
     * Update the specified resource in storage.
     */
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $institucion = Institucion::findOrFail($id);

        if ($institucion->delete()) {
            return Redirect::to('usuario/institucion')->with('success', 'Institución eliminada correctamente.');
        } else {
            return Redirect::back()->with('error', 'Error al eliminar la institución.');
        }
    }
}
