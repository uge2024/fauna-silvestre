<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\FugaFormRequest;
use App\Models\Fuga;
use App\Models\Institucion;
use App\Models\Recepcion;
use App\Models\Nacimiento;
use Carbon\Carbon;
use PDF;

class FugaController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth()->user()->hasRole('usuario')) {
                // Redirigir con un mensaje de error
                return redirect()->route('fuga.index')->with('error', 'No tienes permiso para realizar esta acción.');
            }
    
            return $next($request);
        })->only(['edit', 'destroy']);
    }
    

    public function index(Request $request)
    {
        $texto = trim($request->get('texto', ''));
        $fugas = Fuga::with('institucion', 'recepcion', 'nacimiento') // Incluir nacimiento en la carga
            ->where(function ($query) use ($texto) {
                // Eliminar la consulta por codigo_padre
                $query->orWhereHas('institucion', function ($query) use ($texto) {
                    $query->where('nombre', 'LIKE', '%' . $texto . '%');
                })
                ->orWhereHas('recepcion', function ($query) use ($texto) {
                    $query->where('nombre', 'LIKE', '%' . $texto . '%');
                })
                ->orWhereHas('nacimiento', function ($query) use ($texto) {
                    $query->where('nombre', 'LIKE', '%' . $texto . '%');
                });
            })
            ->orderBy('id_fuga', 'desc')
            ->paginate(5);

        return view('registro.fuga.index', compact('fugas', 'texto'));
    }

    public function create()
    {
        $instituciones = Institucion::all();
        $recepciones = Recepcion::all();
        $nacimientos = Nacimiento::all(); // Cargar nacimientos
        return view('registro.fuga.create', compact('instituciones', 'recepciones', 'nacimientos'));
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'id_institucion' => 'required|exists:institucion,id_institucion',
            'id_recepcion' => 'nullable|exists:recepcion,id_recepcion',
            'id_nacimiento' => 'nullable|exists:nacimiento,id_nacimiento',
            'fecha' => 'required|date',
        ]);
    
        // Verificar si el animal ya tiene una fuga registrada en recepcion
        if ($request->id_recepcion && Fuga::where('id_recepcion', $request->id_recepcion)->exists()) {
            return back()->withErrors(['id_recepcion' => 'Este animal ya esta registrada en fuga.']);
        }
    
        // Verificar si el animal ya tiene una fuga registrada en nacimiento
        if ($request->id_nacimiento && Fuga::where('id_nacimiento', $request->id_nacimiento)->exists()) {
            return back()->withErrors(['id_nacimiento' => 'Este animal ya esta registrada en fuga.']);
        }
    
        // Crear el nuevo registro de Fuga
        Fuga::create($validatedData);
    
        return redirect()->route('fuga.index')->with('success', 'Fuga creada correctamente.');
    }
    

    public function edit(Fuga $fuga)
    {
        $instituciones = Institucion::all();
        $recepciones = Recepcion::all();
        $nacimientos = Nacimiento::all(); // Cargar nacimientos
        return view('registro.fuga.edit', compact('fuga', 'instituciones', 'recepciones', 'nacimientos'));
    }

    public function update(FugaFormRequest $request, Fuga $fuga)
    {
        $fuga->update($request->validated());
        return redirect()->route('fuga.index')->with('success', 'Fuga actualizada correctamente.');
    }

    public function destroy(Fuga $fuga)
    {
        $fuga->delete();
        return redirect()->route('fuga.index')->with('success', 'Fuga eliminada correctamente.');
    }

    public function show($id)
    {
        $fuga = Fuga::findOrFail($id);
        return view('fuga.show', compact('fuga'));
    }

    public function reportePorClase()
    {
        // Obtener los IDs de los animales en fugas que son de recepciones
        $fugasDeRecepcion = Fuga::whereNotNull('id_recepcion')
                                ->pluck('id_recepcion');

        // Obtener los IDs de los animales en fugas que son de nacimientos
        $fugasDeNacimiento = Fuga::whereNotNull('id_nacimiento')
                                 ->pluck('id_nacimiento');

        // Obtener las recepciones asociadas a las fugas y agruparlas por clase, sexo y edad
        $recepcionesPorClase = Recepcion::whereIn('id_recepcion', $fugasDeRecepcion)
                                        ->select('clase', 'sexo', 'edad', \DB::raw('count(*) as total'))
                                        ->groupBy('clase', 'sexo', 'edad')
                                        ->get();

        // Obtener los nacimientos asociados a las fugas y agruparlos por clase, sexo y edad
        $nacimientosPorClase = Nacimiento::whereIn('id_nacimiento', $fugasDeNacimiento)
                                         ->select('clase', 'sexo', 'edad', \DB::raw('count(*) as total'))
                                         ->groupBy('clase', 'sexo', 'edad')
                                         ->get();

        // Unir los resultados de recepciones y nacimientos
        $datosPorClase = $recepcionesPorClase->concat($nacimientosPorClase)
                                             ->groupBy(['clase', 'sexo', 'edad'])
                                             ->map(function ($items, $key) {
                                                 return [
                                                     'clase' => $key[0],
                                                     'sexo' => $key[1],
                                                     'edad' => $key[2],
                                                     'total' => $items->sum('total')
                                                 ];
                                             })
                                             ->values();

        // Renderizar la vista con los datos obtenidos
        return view('reportes.fugas_por_clase', compact('datosPorClase'));
    }

    public function descargarReportePDF(Request $request)
    {
        // Obtener el mes y el año desde la solicitud
        $mes = $request->input('mes');
        $año = $request->input('año');

        // Convertir el número de mes en nombre de mes en español
        setlocale(LC_TIME, 'Spanish_Spain.1252'); // Para sistemas Windows
        $nombreMes = strftime('%B', mktime(0, 0, 0, $mes, 1));

        // Obtener los IDs de los animales en fugas que son de recepciones
        $fugasDeRecepcion = Fuga::whereMonth('fecha', $mes)
                                ->whereYear('fecha', $año)
                                ->whereNotNull('id_recepcion')
                                ->pluck('id_recepcion');

        // Obtener los IDs de los animales en fugas que son de nacimientos
        $fugasDeNacimiento = Fuga::whereMonth('fecha', $mes)
                                 ->whereYear('fecha', $año)
                                 ->whereNotNull('id_nacimiento')
                                 ->pluck('id_nacimiento');

        // Obtener las recepciones asociadas a las fugas y agruparlas por clase, sexo y edad
        $recepcionesPorClase = Recepcion::whereIn('id_recepcion', $fugasDeRecepcion)
                                        ->select('clase', 'sexo', 'edad', \DB::raw('count(*) as total'))
                                        ->groupBy('clase', 'sexo', 'edad')
                                        ->get();

        // Obtener los nacimientos asociados a las fugas y agruparlos por clase, sexo y edad
        $nacimientosPorClase = Nacimiento::whereIn('id_nacimiento', $fugasDeNacimiento)
                                         ->select('clase', 'sexo', 'edad', \DB::raw('count(*) as total'))
                                         ->groupBy('clase', 'sexo', 'edad')
                                         ->get();

        // Combinar los resultados de recepciones y nacimientos
        $datosPorClase = $recepcionesPorClase->concat($nacimientosPorClase);

        // Calcular el total de animales fugados en ese mes
        $totalAnimales = $datosPorClase->sum('total');

        // Crear el PDF con la información obtenida
        $pdf = PDF::loadView('reportes.fugas-pdf', compact('datosPorClase', 'totalAnimales', 'nombreMes', 'año'));

        // Descargar el PDF con un nombre específico
        return $pdf->download('reporte_fugas_' . $nombreMes . '_' . $año . '.pdf');
    }
}
