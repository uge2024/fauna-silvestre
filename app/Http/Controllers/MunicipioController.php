<?php

namespace App\Http\Controllers;

use App\Http\Requests\MunicipioFormRequest;
use App\Models\Municipio;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role; // Esto no es necesario aquí, pero puedes necesitarlo
class MunicipioController extends Controller
{
    public function index(Request $request)
    {
        $texto = $request->input('texto');
        $municipios = Municipio::where('nombre', 'like', "%$texto%")
            ->orWhere('departamento', 'like', "%$texto%")
            ->orderBy('id_municipio', 'desc')
            ->paginate(5);
        return view('usuario.municipio.index', compact('municipios', 'texto'));
    }

    public function create()
    {
        return view('usuario.municipio.create');
    }

    public function store(MunicipioFormRequest $request)
    {
        Municipio::create($request->validated());
        return redirect()->route('municipio.index')->with('success', 'Municipio creado exitosamente.');
    }

    public function edit($id)
    {
        $municipio = Municipio::findOrFail($id);
        return view('usuario.municipio.edit', compact('municipio'));
    }

    public function update(MunicipioFormRequest $request, $id)
    {
        $municipio = Municipio::findOrFail($id);
        $municipio->update($request->validated());
        return redirect()->route('municipio.index')->with('success', 'Municipio actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $municipio = Municipio::findOrFail($id);
        $municipio->delete();
        return redirect()->route('municipio.index')->with('success', 'Municipio eliminado exitosamente.');
    }
    public function show($id)
    {
        $municipio = Municipio::findOrFail($id);
        return view('usuario.municipio.show', compact('municipio'));
    }
}
