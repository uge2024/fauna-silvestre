<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\InformeClinicoFormRequest;
use App\Models\InformeClinico;

use App\Models\Institucion;
use App\Models\Recepcion;
use App\Models\Nacimiento;

use Barryvdh\DomPDF\Facade\Pdf;

class InformeClinicoController extends Controller
{
    public function index(Request $request)
    {
        $informesClinicos = InformeClinico::with( 'institucion', 'recepcion', 'nacimiento')
            ->orderBy('id_informeclinico', 'desc')
            ->paginate(5);

        return view('informeclinico.index', compact('informesClinicos'));
    }

    public function create()
    {
        // Obtén los datos necesarios desde la base de datos
       
        $instituciones = Institucion::all();
        $recepciones = Recepcion::all();
        $nacimientos = Nacimiento::all();
        
        // Pasa las variables a la vista
        return view('informeclinico.create', compact( 'instituciones', 'recepciones', 'nacimientos'));
    }

    public function store(InformeClinicoFormRequest $request)
    {
        // Validar la solicitud a través del FormRequest
        
        // Crear el informe clínico
        InformeClinico::create([
            
            'id_institucion' => $request->id_institucion,
            'id_recepcion' => $request->id_recepcion ?? null, // Manejar valor nulo
            'id_nacimiento' => $request->id_nacimiento ?? null, // Manejar valor nulo
            'fecha' => $request->fecha,
            'anamnesis' => $request->anamnesis,
            'diagnostico' => $request->diagnostico,
            'tratamiento' => $request->tratamiento,
            'programa_sanitario' => $request->programa_sanitario,
            'veterinario' => $request->veterinario,
        ]);

        return redirect()->route('informeclinico.index')->with('success', 'Informe clínico creado con éxito');
    }

    public function edit($id)
    {
        $informeclinico = InformeClinico::findOrFail($id);
        
        $instituciones = Institucion::all();
        $recepciones = Recepcion::all();
        $nacimientos = Nacimiento::all();
        
        return view('informeclinico.edit', compact('informeclinico',  'instituciones', 'recepciones', 'nacimientos'));
    }

    public function update(InformeClinicoFormRequest $request, $id)
    {
        $informeclinico = InformeClinico::findOrFail($id);
        $informeclinico->update([
           
            'id_institucion' => $request->id_institucion,
            'id_recepcion' => $request->id_recepcion ?? null, // Manejar valor nulo
            'id_nacimiento' => $request->id_nacimiento ?? null, // Manejar valor nulo
            'fecha' => $request->fecha,
            'anamnesis' => $request->anamnesis,
            'diagnostico' => $request->diagnostico,
            'tratamiento' => $request->tratamiento,
            'programa_sanitario' => $request->programa_sanitario,
            'veterinario' => $request->veterinario,
        ]);
        
        return redirect()->route('informeclinico.index')->with('success', 'Informe Clínico actualizado correctamente.');
    }

    public function destroy($id)
    {
        $informeclinico = InformeClinico::findOrFail($id);
        $informeclinico->delete();
        
        return redirect()->route('informeclinico.index')->with('success', 'Informe Clínico eliminado correctamente.');
    }
   

public function exportPdf($id)
{
    $informe = InformeClinico::find($id);

    $pdf = Pdf::loadView('informeclinico.pdf', compact('informe'));
    return $pdf->download('informe_clinico.pdf');
}

}
