<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Nacimiento;
use App\Models\Institucion;
use App\Models\Recepcion;

use Illuminate\Support\Facades\Storage;
use App\Http\Requests\NacimientosFormRequest;
use Barryvdh\DomPDF\Facade\Pdf;
class NacimientosController extends Controller
{
    public function index(Request $request)
    {
        $texto = trim($request->get('texto', ''));
        $nacimientos = Nacimiento::with('institucion')
            ->where(function ($query) use ($texto) {
                $query->where('nombre', 'LIKE', '%' . $texto . '%')
                      ->orWhere('codigo', 'LIKE', '%' . $texto . '%')
                      ->orWhere('clase', 'LIKE', '%' . $texto . '%');
            })
            ->orderBy('id_nacimiento', 'desc')
            ->paginate(5);

        return view('registro.nacimiento.index', compact('nacimientos', 'texto'));
    }

    public function create()
    {
        $instituciones = Institucion::all();
        $recepciones = Recepcion::all(); // Asegúrate de tener el modelo y la consulta adecuada
    
        return view('registro.nacimiento.create', compact('instituciones', 'recepciones'));
    }
    


    public function edit($id)
    {
        $nacimiento = Nacimiento::findOrFail($id);
        $instituciones = Institucion::all();
        $recepciones = Recepcion::all();
        return view('registro.nacimiento.edit', compact('nacimiento', 'instituciones','recepciones'));
    }
    public function update(NacimientosFormRequest $request, $id)
    {
        try {
            $validatedData = $request->validated();
            $nacimiento = Nacimiento::findOrFail($id);
            $nacimiento->fill($validatedData);
    
            // Actualiza el id_recepcion
            if ($request->filled('id_recepcion')) {
                $nacimiento->id_recepcion = $request->input('id_recepcion');
            }
    
            // Procesar la carga de la fotografía si está presente
            if ($request->hasFile('fotografia')) {
                $fotografia = $request->file('fotografia');
                $nombreImagen = time() . '_' . $fotografia->getClientOriginalName();
                $ruta = public_path("/imagenes/nacimientos/");
                $fotografia->move($ruta, $nombreImagen);
                $nacimiento->fotografia = $nombreImagen;
            }
    
            $nacimiento->estado_trasferencia = $request->input('estado_trasferencia', $nacimiento->estado_trasferencia);
            $nacimiento->save();
            
            return redirect()->route('nacimiento.index')->with('success', 'Nacimiento actualizado correctamente.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al actualizar el nacimiento: ' . $e->getMessage()]);
        }
    }
    

    public function destroy($id)
    {
        try {
            $nacimiento = Nacimiento::findOrFail($id);

            if (Storage::exists('public/imagenes/nacimientos/' . $nacimiento->fotografia)) {
                Storage::delete('public/imagenes/nacimientos/' . $nacimiento->fotografia);
            }

            $nacimiento->delete();
            return redirect()->route('nacimiento.index')->with('success', 'Nacimiento eliminado con éxito.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al eliminar el nacimiento: ' . $e->getMessage()]);
        }
    }
    public function show($id)
{
    $nacimiento = Nacimiento::findOrFail($id);
    return view('registro.nacimiento.show', compact('nacimiento'));
}
public function transferir($id)
{
    try {
        $nacimiento = Nacimiento::findOrFail($id);
        $nacimiento->estado_trasferencia = 'transferido';
        $nacimiento->save();
        
        return redirect()->route('nacimiento.index')->with('success', 'Nacimiento transferido correctamente.');
    } catch (\Exception $e) {
        return back()->withErrors(['error' => 'Error al transferir el nacimiento: ' . $e->getMessage()]);
    }
}


public function store(NacimientosFormRequest $request)
{
    try {
        $validatedData = $request->validated();

        // Crear una nueva instancia del modelo Nacimiento con los datos validados
        $nacimiento = new Nacimiento($validatedData);

        // Captura el id_recepcion
        if ($request->filled('id_recepcion')) {
            $nacimiento->id_recepcion = $request->input('id_recepcion');
        }

        // Procesar la carga de la fotografía si está presente
        if ($request->hasFile('fotografia')) {
            $fotografia = $request->file('fotografia');
            $nombreImagen = time() . '_' . $fotografia->getClientOriginalName();
            $ruta = public_path("/imagenes/nacimientos/");
            $fotografia->move($ruta, $nombreImagen);
            $nacimiento->fotografia = $nombreImagen;
        }

        // Asignar el estado de transferencia
        $nacimiento->estado_trasferencia = 'no transferido';

        // Obtener la institución desde la base de datos
        $institucion = Institucion::find($request->input('id_institucion'));

        // Generar el código de animal con las siglas de la institución
        $nacimiento->codigo = $this->generateCodigoAnimal($institucion);
        if ($request->filled('codigo_padres')) {
            $nacimiento->codigo_padres = $request->input('codigo_padres');
        }
        
        // Guardar el registro en la base de datos
        $nacimiento->save();

        // Redirigir a la vista index con un mensaje de éxito
        return redirect()->route('nacimiento.index')->with('success', 'Nacimiento creado correctamente.');
    } catch (\Exception $e) {
        return back()->withErrors(['error' => 'Error al crear el nacimiento: ' . $e->getMessage()]);
    }
}




private function generateCodigoAnimal($institucion)
{
    // Obtener las primeras letras de la institución
    $prefix = strtoupper(substr($institucion->nombre, 0, 3));

    // Obtener el último código creado con ese prefijo
    $lastCodigo = Nacimiento::where('codigo', 'LIKE', "{$prefix}%")
                            ->orderBy('id_nacimiento', 'desc')
                            ->value('codigo');

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

public function reportePorClase()
{
    // Obtener los nacimientos agrupados por clase, sexo y edad
    $nacimientosPorClase = Nacimiento::select('clase', 'sexo', 'edad', \DB::raw('count(*) as total'))
                                    ->groupBy('clase', 'sexo', 'edad')
                                    ->get();

    // Renderizar la vista con los datos obtenidos
    return view('reportes.nacimientos_por_clase', compact('nacimientosPorClase'));
}

public function descargarReportePDF(Request $request)
{
    // Obtener el mes y el año desde la solicitud
    $mes = $request->input('mes');
    $año = $request->input('año');

    // Convertir el número de mes en nombre de mes en español
    setlocale(LC_TIME, 'Spanish_Spain.1252'); // Para sistemas Windows
    $nombreMes = strftime('%B', mktime(0, 0, 0, $mes, 1));

    // Filtrar los nacimientos por el mes y año seleccionados y ordenar por clase
    $nacimientosPorClase = Nacimiento::select('clase', 'sexo', 'edad', \DB::raw('count(*) as total'))
                                    ->whereMonth('fecha', $mes)
                                    ->whereYear('fecha', $año)
                                    ->groupBy('clase', 'sexo', 'edad')
                                    ->orderBy('clase')
                                    ->get();

    // Calcular el total de nacimientos en ese mes
    $totalNacimientos = $nacimientosPorClase->sum('total');

    // Crear el PDF con la información obtenida
    $pdf = PDF::loadView('reportes.nacimientos_por_clase_pdf', compact('nacimientosPorClase', 'totalNacimientos', 'nombreMes', 'año'));

    // Descargar el PDF con un nombre específico
    return $pdf->download('reporte_nacimientos_clase_' . $nombreMes . '_' . $año . '.pdf');
}

}