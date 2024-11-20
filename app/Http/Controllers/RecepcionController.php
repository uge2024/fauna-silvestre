<?php

namespace App\Http\Controllers;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Models\Recepcion;
use App\Models\Institucion;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use App\Http\Requests\RecepcionFormRequest;
use Illuminate\Support\Facades\Redirect;
use Barryvdh\DomPDF\Facade\Pdf;

class RecepcionController extends Controller
{
    public function __construct()
{
    $this->middleware(function ($request, $next) {
        if (auth()->user()->hasRole('usuario')) {
            // Redirigir con un mensaje de error
            return redirect()->route('recepcion.index')->with('error', 'No tienes permiso para realizar esta acción.');
        }

        return $next($request);
    })->only(['edit', 'destroy']);
}

    public function index(Request $request)
    {
        $texto = trim($request->get('texto', ''));
        $recepciones = Recepcion::with( 'institucion')
            ->where(function ($query) use ($texto) {
                $query->where('motivo_recepcion', 'LIKE', '%' . $texto . '%')
                      ->orWhere('nombre', 'LIKE', '%' . $texto . '%')
                      ->orWhere('codigo_animal', 'LIKE', '%' . $texto . '%')
                      ->orWhere('clase', 'LIKE', '%' . $texto . '%')
                      ->orWhere('especie', 'LIKE', '%' . $texto . '%');
                     
            })
            ->orderBy('id_recepcion', 'desc')
            ->paginate(5);

        return view('registro.recepcion.index', compact('recepciones', 'texto'));
    }

    public function create()
    {
        $instituciones = Institucion::all();
      
        return view('registro.recepcion.create', compact('instituciones'));
    }

    public function store(RecepcionFormRequest $request)
    {
        try {
            $validatedData = $request->validated();
    
            // Crear una nueva instancia del modelo Recepcion con los datos validados
            $recepcion = new Recepcion($validatedData);
            
            $recepcion->id_institucion_recibida = $request->input('id_institucion_recibida');
            // Procesar la carga de la fotografía si está presente
            if ($request->hasFile('fotografia')) {
                $fotografia = $request->file('fotografia');
                $nombreImagen = time() . '_' . $fotografia->getClientOriginalName();
                $ruta = public_path("/imagenes/recepcion/");
                $fotografia->move($ruta, $nombreImagen);
                $recepcion->fotografia = $nombreImagen;
            }
    
            // Asignar el estado de transferencia
            $recepcion->estado_trasferencia = 'no transferido';
    
            // Obtener la institución desde la base de datos
            $institucion = Institucion::find($request->input('id_institucion_recibida'));
    
            // Generar el código de animal con las siglas de la institución
            $recepcion->codigo_animal = $this->generateCodigoAnimal($institucion);
    
            // Guardar el registro en la base de datos
            $recepcion->save();
    
            // Redirigir a la vista index con un mensaje de éxito
            return redirect()->route('recepcion.index')->with('success', 'Recepción creada correctamente.');
        } catch (\Exception $e) {
            // Manejar cualquier excepción que pueda ocurrir durante el proceso
            return back()->withErrors(['error' => 'Error al crear la recepción: ' . $e->getMessage()]);
        }
    }

private function generateCodigoAnimal($institucion)
{
    // Obtener las primeras letras de la institución
    $prefix = strtoupper(substr($institucion->nombre, 0, 3));

    // Obtener el último código creado con ese prefijo
    $lastCodigo = Recepcion::where('codigo_animal', 'LIKE', "{$prefix}%")
                           ->orderBy('id_recepcion', 'desc')
                           ->value('codigo_animal');

    if ($lastCodigo) {
        // Extraer la parte numérica del último código
        $lastNumber = intval(substr($lastCodigo, strlen($prefix)));
        // Incrementar en 1
        $newNumber = $lastNumber + 1;
    } else {
        // Si no hay códigos previos, comenzar con 1
        $newNumber = 1;
    }

    // Formatear el nuevo número con ceros a la izquierda
    $newCodigo = $prefix . str_pad($newNumber, 5, '0', STR_PAD_LEFT);

    return $newCodigo;
}

    public function edit($id)
    {
        $recepcion = Recepcion::findOrFail($id);
        
        $instituciones = Institucion::all();
    
        return view('registro.recepcion.edit', compact('recepcion', 'instituciones'));
    }
    
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            
            'id_institucion' => 'required|integer',
            'id_institucion_recibida' => 'required|integer',
            'fecha' => 'required|date',
            'motivo_recepcion' => 'required|string|max:300',
            'codigo_animal' => 'required|string|max:50',
            'nombre' => 'required|string|max:50',
            'clase' => 'required|string|max:50',
            'especie' => 'required|string|max:50',
            'fotografia' => 'nullable|image',
            'edad' => 'required|string|max:50',
            'estado' => 'required|string|max:50',
            'sexo' => 'required|string|max:50',
            'color' => 'required|string|max:50',
            'descripcion_color' => 'nullable|string|max:300',
            'comportamiento' => 'nullable|string|max:300',
            'sospech_enfermedad' => 'nullable|string|max:300',
            'alteraciones_heridas' => 'nullable|string|max:300',
            'observaciones' => 'nullable|string|max:300',
            'tiempo_cautiverio' => 'nullable|string|max:300',
            'contacto_animales' => 'nullable|string|max:300',
            'medicacion' => 'nullable|string|max:300',
            'alimentacion' => 'nullable|string|max:300',
            'estado_trasferencia' => 'sometimes|string', // if it's optional or automatically set
       'responsable_decomiso' => 'required|string',
        ]);
    
        $recepcion = Recepcion::findOrFail($id);
        $recepcion->fill($validatedData);
    
        if ($request->hasFile('fotografia')) {
            $fotografia = $request->file('fotografia');
            $nombreImagen = time() . '_' . $fotografia->getClientOriginalName();
            $ruta = public_path("/imagenes/recepcion/");
            $fotografia->move($ruta, $nombreImagen);
            $recepcion->fotografia = $nombreImagen;
        }
    
        $recepcion->save();
    
        return redirect()->route('recepcion.index')->with('success', 'Recepción actualizada correctamente.');
    }
    
 public function destroy($id)
{
    try {
        $recepcion = Recepcion::findOrFail($id);

        if (File::exists(public_path('/imagenes/recepcion/'.$recepcion->fotografia))) {
            File::delete(public_path('/imagenes/recepcion/'.$recepcion->fotografia));
        }

        $recepcion->delete();
        return redirect()->route('recepcion.index')->with('success', 'Recepción eliminada con éxito.');
    } catch (\Exception $e) {
        return back()->withErrors(['error' => 'Error al eliminar la recepción: ' . $e->getMessage()]);
    }
}
public function show($id)
{
    // Cargar la relación 'institucionRecibida' para acceder a la institución responsable del decomiso
    $recepcion = Recepcion::with('institucionRecibida')->findOrFail($id);

    return view('registro.recepcion.show', compact('recepcion'));
}

public function exportPdf($id)
{
    $recepcion = Recepcion::findOrFail($id);

    // Convertir contacto_animales en un array si es una cadena separada por comas
    $contacto_animales = explode(',', $recepcion->contacto_animales);

    // Construir un array con los datos necesarios
    $data = [
        
        'institucion_nombre' => $recepcion->institucion->nombre,
        'fecha' => $recepcion->fecha,
        'motivo_recepcion' => $recepcion->motivo_recepcion,
        'codigo_animal' => $recepcion->codigo_animal,
        'nombre' => $recepcion->nombre,
        'clase' => $recepcion->clase,
        'especie' => $recepcion->especie,
        'fotografia' => $recepcion->fotografia,
        'edad' => $recepcion->edad,
        'estado' => $recepcion->estado,
        'sexo' => $recepcion->sexo,
        'color' => $recepcion->color,
        'comportamiento' => $recepcion->comportamiento,
        'sospech_enfermedad' => $recepcion->sospech_enfermedad,
        'alteraciones_heridas' => $recepcion->alteraciones_heridas,
        'observaciones' => $recepcion->observaciones,
        'tiempo_cautiverio' => $recepcion->tiempo_cautiverio,
        'contacto_animales' => $contacto_animales, // Asegúrate de que sea un array
        'medicacion' => $recepcion->medicacion,
        'alimentacion' => $recepcion->alimentacion,
    ];

    // Cargar la vista y pasar los datos
    $pdf = Pdf::loadView('registro.recepcion.pdf', $data);

    // Descargar el PDF
    return $pdf->download('recepcion_' . $id . '.pdf');
}


public function transferir($id)
    {
        try {
            $recepcion = Recepcion::findOrFail($id);
            $recepcion->estado_trasferencia = 'transferido';
            $recepcion->save();
            
            return redirect()->route('recepcion.index')->with('success', 'Recepción transferida correctamente.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al transferir la recepción: ' . $e->getMessage()]);
        }
    }
    
    
  

    public function reporteMensual(Request $request)
    {
        $mes = $request->input('mes');
    
        if ($mes) {
            try {
                $fechaInicio = Carbon::createFromFormat('Y-m', $mes)->startOfMonth();
                $fechaFin = Carbon::createFromFormat('Y-m', $mes)->endOfMonth();
    
                $recepciones = Recepcion::whereBetween('fecha', [$fechaInicio, $fechaFin])->get();
    
                // Puedes redirigir a una vista que muestre los datos o generar un PDF
                return view('registro.recepcion.reporte', compact('recepciones'));
            } catch (\Exception $e) {
                return back()->withErrors(['error' => 'Error al generar el reporte: ' . $e->getMessage()]);
            }
        } else {
            return back()->withErrors(['error' => 'Debe seleccionar un mes válido.']);
        }
    }
  




/////////////////////////////////
public function reportePorClase()
    {
        // Obtener las recepciones agrupadas por clase
        $recepcionesPorClase = Recepcion::select('clase','sexo', 'edad', \DB::raw('count(*) as total'))
                                ->groupBy('clase','sexo', 'edad')
                                ->get();

        // Renderizar la vista con los datos obtenidos
        return view('reportes.pdf', compact('recepcionesPorClase'));
    }

    
    public function descargarReportePDF(Request $request)
{
    // Obtener el mes y el año desde la solicitud
    $mes = $request->input('mes');
    $año = $request->input('año');

    // Convertir el número de mes en nombre de mes en español
    setlocale(LC_TIME, 'Spanish_Spain.1252'); // Para sistemas Windows

    $nombreMes = strftime('%B', mktime(0, 0, 0, $mes, 1));

    // Filtrar las recepciones por el mes y año seleccionados y ordenar por clase
    $recepcionesPorClase = Recepcion::select('clase', 'sexo', 'edad', \DB::raw('count(*) as total'))
                            ->whereMonth('fecha', $mes)
                            ->whereYear('fecha', $año)
                            ->groupBy('clase', 'sexo', 'edad')
                            ->orderBy('clase')
                            ->get();

    // Calcular el total de animales ingresados en ese mes
    $totalAnimales = $recepcionesPorClase->sum('total');

    // Crear el PDF con la información obtenida
    $pdf = PDF::loadView('reportes.pdf', compact('recepcionesPorClase', 'totalAnimales', 'nombreMes', 'año'));

    // Descargar el PDF con un nombre específico
    return $pdf->download('reporte_por_clase_' . $nombreMes . '_' . $año . '.pdf');
}

    
}