<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransferenciaFormRequest;
use App\Models\Transferencia;
use App\Models\Deceso;
use App\Models\Fuga;
use App\Models\Institucion;
use App\Models\Recepcion;
use App\Models\Nacimiento;
use Illuminate\Http\Request; 
use Carbon\Carbon;
use PDF;
class TransferenciaController extends Controller
{
    public function index(Request $request)
    {
        $texto = $request->get('texto');
        $transferencias = Transferencia::where('motivo_transferencia', 'like', '%' . $texto . '%')
            ->orderBy('id_transferencia', 'desc')
            ->paginate(5);

        return view('derivacion.transferencia.index', compact('transferencias', 'texto'));
    }

    public function create()
    {
        
        $instituciones = Institucion::all();
        $recepciones = Recepcion::all();  // Obtener todas las recepciones
        $nacimientos = Nacimiento::all(); // Obtener todos los nacimientos

        return view('derivacion.transferencia.create', compact( 'instituciones', 'recepciones', 'nacimientos'));
    }


    public function store(TransferenciaFormRequest $request)
{
    // Agregar logging para los datos de entrada
    \Log::info('Registro de Transferencia: ', $request->all());

    // Inicializar variables para las validaciones
    $errores = [];

    // Verificar si el animal ya ha sido transferido por id_nacimiento
    if ($request->id_nacimiento) {
        $transferenciaExistenteNacimiento = Transferencia::where('id_nacimiento', $request->id_nacimiento)->exists();
        $animalEnDecesoNacimiento = Deceso::where('id_nacimiento', $request->id_nacimiento)->exists();
        $animalEnFugaNacimiento = Fuga::where('id_nacimiento', $request->id_nacimiento)->exists();

        // Comprobar condiciones para id_nacimiento
        if ($transferenciaExistenteNacimiento) {
            $errores[] = 'Este animal (ID: ' . $request->id_nacimiento . ') ya ha sido transferido una vez.';
        }

        if ($animalEnDecesoNacimiento) {
            $errores[] = 'Este animal (ID: ' . $request->id_nacimiento . ') no puede ser transferido porque está registrado en deceso.';
        }

        if ($animalEnFugaNacimiento) {
            $errores[] = 'Este animal (ID: ' . $request->id_nacimiento . ') no puede ser transferido porque está registrado en fuga.';
        }
    }

    // Verificar si el animal ya ha sido transferido por id_recepcion
    if ($request->id_recepcion) {
        $transferenciaExistenteRecepcion = Transferencia::where('id_recepcion', $request->id_recepcion)->exists();
        $recepcionEnDeceso = Deceso::where('id_recepcion', $request->id_recepcion)->exists();
        $recepcionEnFuga = Fuga::where('id_recepcion', $request->id_recepcion)->exists();

        // Comprobar condiciones para id_recepcion
        if ($transferenciaExistenteRecepcion) {
            $errores[] = 'La recepción (ID: ' . $request->id_recepcion . ') ya ha sido transferida.';
        }

        if ($recepcionEnDeceso) {
            $errores[] = 'La recepción (ID: ' . $request->id_recepcion . ') no puede ser transferida porque está registrada en deceso.';
        }

        if ($recepcionEnFuga) {
            $errores[] = 'La recepción (ID: ' . $request->id_recepcion . ') no puede ser transferida porque está registrada en fuga.';
        }
    }

    // Si hay errores, redirigir con mensajes de error
    if (!empty($errores)) {
        return back()->withErrors(['error' => implode(' ', $errores)]);
    }

    // Crear la nueva transferencia
    $transferencia = new Transferencia();
    $transferencia->id_institucion = $request->id_institucion;
    $transferencia->id_recepcion = $request->id_recepcion;
    $transferencia->id_nacimiento = $request->id_nacimiento;
    $transferencia->fecha = $request->fecha;
    $transferencia->transporte = $request->transporte;
    $transferencia->describir_destino = $request->describir_destino;
    $transferencia->motivo_transferencia = $request->motivo_transferencia;
    $transferencia->institucion_destino = $request->institucion_destino;
    $transferencia->save();

    // Cambiar el estado de recepción y nacimiento si existen
    if ($request->id_recepcion) {
        $recepcion = Recepcion::find($request->id_recepcion);
        if ($recepcion) {
            $recepcion->estado_trasferencia = 'transferido';
            $recepcion->save();
        }
    }

    if ($request->id_nacimiento) {
        $nacimiento = Nacimiento::find($request->id_nacimiento);
        if ($nacimiento) {
            $nacimiento->estado_trasferencia = 'transferido';
            $nacimiento->save();
        }
    }

    return redirect()->route('transferencia.index')->with('success', 'Transferencia creada con éxito');
}


    
 
    public function update(TransferenciaFormRequest $request, $id)
    {
        $transferencia = Transferencia::findOrFail($id);
        
        $transferencia->id_institucion = $request->id_institucion;
        $transferencia->id_recepcion = $request->id_recepcion ?: null;
        $transferencia->id_nacimiento = $request->id_nacimiento ?: null;
        $transferencia->fecha = $request->fecha;
        $transferencia->transporte = $request->transporte;
        $transferencia->describir_destino = $request->describir_destino; // Cambiado a minúsculas
        $transferencia->motivo_transferencia = $request->motivo_transferencia;
        $transferencia->institucion_destino = $request->institucion_destino;
        $transferencia->save();
    
        return redirect()->route('transferencia.index')->with('success', 'Transferencia actualizada exitosamente');
    }
    

    public function show($id_transferencia)
{
    $transferencia = Transferencia::findOrFail($id_transferencia);
    return view('derivacion.transferencia.show', compact('transferencia'));
}


    public function edit($id_transferencia)
    {
        $transferencia = Transferencia::findOrFail($id_transferencia);
        
        $instituciones = Institucion::all();
        $recepciones = Recepcion::all();
        $nacimientos = Nacimiento::all();

        return view('derivacion.transferencia.edit', compact('transferencia',  'instituciones', 'recepciones', 'nacimientos'));
    }

    public function destroy($id)
{
    $transferencia = Transferencia::find($id);

    if ($transferencia) {
        $transferencia->delete();
        return redirect()->route('transferencia.index')->with('success', 'Transferencia eliminada con éxito.');
    } else {
        return redirect()->route('transferencia.index')->with('error', 'Transferencia no encontrada.');
    }
}



public function reportePorClaseTransferencia()
{
    // Obtener los IDs de las transferencias que son de recepciones
    $transferenciasDeRecepcion = Transferencia::whereNotNull('id_recepcion')
                                              ->pluck('id_recepcion');

    // Obtener los IDs de las transferencias que son de nacimientos
    $transferenciasDeNacimiento = Transferencia::whereNotNull('id_nacimiento')
                                               ->pluck('id_nacimiento');

    // Obtener las recepciones asociadas a las transferencias y agruparlas por clase, sexo y edad
    $recepcionesPorClase = Recepcion::whereIn('id_recepcion', $transferenciasDeRecepcion)
                                    ->select('clase', 'sexo', 'edad', \DB::raw('count(*) as total'))
                                    ->groupBy('clase', 'sexo', 'edad')
                                    ->get();

    // Obtener los nacimientos asociados a las transferencias y agruparlos por clase, sexo y edad
    $nacimientosPorClase = Nacimiento::whereIn('id_nacimiento', $transferenciasDeNacimiento)
                                     ->select('clase', 'sexo', 'edad', \DB::raw('count(*) as total'))
                                     ->groupBy('clase', 'sexo', 'edad')
                                     ->get();

    // Unir los resultados de recepciones y nacimientos
    $datosPorClase = $recepcionesPorClase->concat($nacimientosPorClase);

    // Calcular el total de animales transferidos
    $totalAnimales = $datosPorClase->sum('total');

    // Renderizar la vista con los datos obtenidos
    return view('reportes.transferencias_por_clase', compact('datosPorClase', 'totalAnimales'));
}
public function descargarReporteTransferenciaPDF(Request $request)
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

    // Obtener los IDs de las transferencias que son de recepciones
    $transferenciasDeRecepcion = Transferencia::whereMonth('fecha', $mes)
                                              ->whereYear('fecha', $año)
                                              ->whereNotNull('id_recepcion')
                                              ->pluck('id_recepcion');

    // Obtener los IDs de las transferencias que son de nacimientos
    $transferenciasDeNacimiento = Transferencia::whereMonth('fecha', $mes)
                                               ->whereYear('fecha', $año)
                                               ->whereNotNull('id_nacimiento')
                                               ->pluck('id_nacimiento');

    // Obtener las recepciones asociadas a las transferencias y agruparlas por clase, sexo y edad
    $recepcionesPorClase = Recepcion::whereIn('id_recepcion', $transferenciasDeRecepcion)
                                    ->select('clase', 'sexo', 'edad', \DB::raw('count(*) as total'))
                                    ->groupBy('clase', 'sexo', 'edad')
                                    ->get();

    // Obtener los nacimientos asociados a las transferencias y agruparlos por clase, sexo y edad
    $nacimientosPorClase = Nacimiento::whereIn('id_nacimiento', $transferenciasDeNacimiento)
                                     ->select('clase', 'sexo', 'edad', \DB::raw('count(*) as total'))
                                     ->groupBy('clase', 'sexo', 'edad')
                                     ->get();

    // Combinar los resultados de recepciones y nacimientos
    $datosPorClase = $recepcionesPorClase->concat($nacimientosPorClase);

    // Calcular el total de animales transferidos en ese mes
    $totalAnimales = $datosPorClase->sum('total');

    // Crear el PDF con la información obtenida
    $pdf = PDF::loadView('reportes.transferencias-pdf', compact('datosPorClase', 'totalAnimales', 'nombreMes', 'año'));

    // Descargar el PDF con un nombre de archivo personalizado
    return $pdf->download('Reporte_de_Transferencias_' . $nombreMes . '_' . $año . '.pdf');
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

    // Consultar la base de datos para obtener las transferencias
    $transferencias = Transferencia::whereYear('fecha', $año)
                                   ->whereMonth('fecha', $mes)
                                   ->get();

    // Generar el PDF utilizando una vista
    $pdf = PDF::loadView('reportes.transferencias_reporte', compact('transferencias', 'mes', 'año'));

    // Descargar el PDF
    return $pdf->download("reporte_transferencias_{$mes}_{$año}.pdf");
}
}