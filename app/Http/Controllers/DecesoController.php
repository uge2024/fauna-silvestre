<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DecesoFormRequest;
use App\Models\Deceso;
use App\Models\Institucion;
use App\Models\Recepcion;
use App\Models\Nacimiento;
use Carbon\Carbon;
use PDF;
class DecesoController extends Controller
{
    public function index(Request $request)
    {
        $texto = trim($request->get('texto', ''));
        $decesos = Deceso::with('institucion', 'recepcion', 'nacimiento')
            ->where(function ($query) use ($texto) {
                $query->where('causas', 'LIKE', '%' . $texto . '%')
                      ->orWhere('diagnostico', 'LIKE', '%' . $texto . '%')
                      ->orWhere('tratamiento', 'LIKE', '%' . $texto . '%')
                      ->orWhere('medico_veterinario', 'LIKE', '%' . $texto . '%');
            })
            ->orderBy('id_deceso', 'desc')
            ->paginate(5);

        return view('registro.deceso.index', compact('decesos', 'texto'));
    }

    public function create()
    {
        $instituciones = Institucion::all();
        $recepciones = Recepcion::all();
        $nacimientos = Nacimiento::all();
        return view('registro.deceso.create', compact('instituciones', 'recepciones', 'nacimientos'));
    }

    public function store(Request $request)
{
    // Validate the request
    $validatedData = $request->validate([
        'id_institucion' => 'required|exists:institucion,id_institucion',
        'id_recepcion' => 'nullable|exists:recepcion,id_recepcion',
        'id_nacimiento' => 'nullable|exists:nacimiento,id_nacimiento',
        'fecha' => 'required|date',
        'causas' => 'required|string|max:50',
        'diagnostico' => 'required|string|max:50',
        'tratamiento' => 'required|string|max:50',
        'laboratorio_archivo' => 'nullable|mimes:pdf|max:2048', 
        'medico_veterinario' => 'required|string|max:50',
    ]);

    if ($request->hasFile('laboratorio_archivo')) {
        $file = $request->file('laboratorio_archivo');
        $filename = time() . '-' . $file->getClientOriginalName();
        $file->move(public_path('pdfs'), $filename);
        $validatedData['laboratorio_archivo'] = $filename;
    }
   
    // Create a new Deceso record
    Deceso::create($validatedData);

    return redirect()->route('deceso.index')->with('success', 'Deceso creado exitosamente');
}

    public function edit(Deceso $deceso)
    {
        $instituciones = Institucion::all();
        $recepciones = Recepcion::all();
        $nacimientos = Nacimiento::all();
        return view('registro.deceso.edit', compact('deceso', 'instituciones', 'recepciones', 'nacimientos'));
    }

    public function update(Request $request, Deceso $deceso)
{
    // Validar la solicitud
    $validatedData = $request->validate([
        'id_institucion' => 'required|exists:institucion,id_institucion',
        'id_recepcion' => 'nullable|exists:recepcion,id_recepcion',
        'id_nacimiento' => 'nullable|exists:nacimiento,id_nacimiento',
        'fecha' => 'required|date',
        'causas' => 'required|string|max:50',
        'diagnostico' => 'required|string|max:50',
        'tratamiento' => 'required|string|max:50',
        'medico_veterinario' => 'required|string|max:50',
        'laboratorio_archivo' => 'nullable|mimes:pdf|max:2048',
    ]);

    // Manejar la carga del archivo PDF si existe
    if ($request->hasFile('laboratorio_archivo')) {
        // Eliminar el archivo PDF anterior si existe
        if ($deceso->laboratorio_archivo) {
            $rutaArchivo = public_path("/pdfs/{$deceso->laboratorio_archivo}");
            if (file_exists($rutaArchivo)) {
                unlink($rutaArchivo);
            }
        }

        $file = $request->file('laboratorio_archivo');
        $filename = time() . '-' . $file->getClientOriginalName();
        $file->move(public_path('pdfs'), $filename);
        $validatedData['laboratorio_archivo'] = $filename;
    }

    $deceso->update($validatedData);

    return redirect()->route('deceso.index')->with('success', 'Deceso actualizado correctamente.');
}

    public function destroy(Deceso $deceso)
    {
        if ($deceso->laboratorio_imagen) {
            $rutaImagen = public_path("/imagenes/laboratorio/{$deceso->laboratorio_imagen}");
            if (file_exists($rutaImagen)) {
                unlink($rutaImagen);
            }
        }

        $deceso->delete();
        return redirect()->route('deceso.index')->with('success', 'Deceso eliminado correctamente.');
    }

    public function show($id)
    {
        $deceso = Deceso::findOrFail($id);
        return view('deceso.show', compact('deceso'));
    }
    public function reportePorClaseDeceso()
    {
        // Obtener los IDs de los decesos que son de recepciones
        $decesosDeRecepcion = Deceso::whereNotNull('id_recepcion')
                                    ->pluck('id_recepcion'); 
    
        // Obtener los IDs de los decesos que son de nacimientos
        $decesosDeNacimiento = Deceso::whereNotNull('id_nacimiento')
                                     ->pluck('id_nacimiento');
    
        // Obtener las recepciones asociadas a los decesos y agruparlas por clase, sexo y edad
        $recepcionesPorClase = Recepcion::whereIn('id_recepcion', $decesosDeRecepcion)
                                        ->select('clase', 'sexo', 'edad', \DB::raw('count(*) as total'))
                                        ->groupBy('clase', 'sexo', 'edad')
                                        ->get();
    
        // Obtener los nacimientos asociados a los decesos y agruparlos por clase, sexo y edad
        $nacimientosPorClase = Nacimiento::whereIn('id_nacimiento', $decesosDeNacimiento)
                                         ->select('clase', 'sexo', 'edad', \DB::raw('count(*) as total'))
                                         ->groupBy('clase', 'sexo', 'edad')
                                         ->get();
    
        // Unir los resultados de recepciones y nacimientos
        $datosPorClase = $recepcionesPorClase->concat($nacimientosPorClase);
    
        // Calcular el total de animales fallecidos
        $totalAnimales = $datosPorClase->sum('total');
    
        // Renderizar la vista con los datos obtenidos
        return view('reportes.decesos_por_clase', compact('datosPorClase', 'totalAnimales'));
    }
    
    public function descargarReporteDecesoPDF(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'mes' => 'required|integer|between:1,12',
            'año' => 'required|integer|min:2000|max:' . date('Y'),
        ]);
    
        // Obtener el mes y el año desde la solicitud
        $mes = $request->input('mes');
        $año = $request->input('año');
    
        // Convertir el número de mes en nombre de mes en español
        setlocale(LC_TIME, 'Spanish_Spain.1252'); // Para sistemas Windows
    
        $nombreMes = strftime('%B', mktime(0, 0, 0, $mes, 1));
    
        // Obtener los IDs de los decesos que son de recepciones
        $decesosDeRecepcion = Deceso::whereMonth('fecha', $mes)
                                    ->whereYear('fecha', $año)
                                    ->whereNotNull('id_recepcion')
                                    ->pluck('id_recepcion');
    
        // Obtener los IDs de los decesos que son de nacimientos
        $decesosDeNacimiento = Deceso::whereMonth('fecha', $mes)
                                     ->whereYear('fecha', $año)
                                     ->whereNotNull('id_nacimiento')
                                     ->pluck('id_nacimiento');
    
        // Obtener las recepciones asociadas a los decesos y agruparlas por clase, sexo y edad
        $recepcionesPorClase = Recepcion::whereIn('id_recepcion', $decesosDeRecepcion)
                                        ->select('clase', 'sexo', 'edad', \DB::raw('count(*) as total'))
                                        ->groupBy('clase', 'sexo', 'edad')
                                        ->get();
    
        // Obtener los nacimientos asociados a los decesos y agruparlos por clase, sexo y edad
        $nacimientosPorClase = Nacimiento::whereIn('id_nacimiento', $decesosDeNacimiento)
                                         ->select('clase', 'sexo', 'edad', \DB::raw('count(*) as total'))
                                         ->groupBy('clase', 'sexo', 'edad')
                                         ->get();
    
        // Combinar los resultados de recepciones y nacimientos
        $datosPorClase = $recepcionesPorClase->concat($nacimientosPorClase);
    
        // Calcular el total de animales fallecidos en ese mes
        $totalAnimales = $datosPorClase->sum('total');
    
        // Crear el PDF con la información obtenida
        $pdf = PDF::loadView('reportes.decesos-pdf', compact('datosPorClase', 'totalAnimales', 'nombreMes', 'año'));
    
        // Descargar el PDF con un nombre de archivo personalizado
        return $pdf->download('Reporte_de_Decesos_' . $nombreMes . '_' . $año . '.pdf');
    }
    
public function generarReportePDF(Request $request)
{
    // Validar los datos del formulario
    $request->validate([
        'mes' => 'required|integer|between:1,12',
        'año' => 'required|integer|min:2000|max:' . date('Y'),
    ]);

    // Obtener los datos necesarios según el mes y año
    $mes = $request->mes;
    $año = $request->año;

    // Consultar la base de datos para obtener los decesos
    $decesos = Deceso::whereYear('fecha', $año)
                    ->whereMonth('fecha', $mes)
                    ->get();

    // Generar el PDF utilizando una vista
    $pdf = PDF::loadView('reportes.decesos_reporte', compact('decesos', 'mes', 'año'));

    // Descargar el PDF
    return $pdf->download("reporte_decesos_{$mes}_{$año}.pdf");
}
}