<?php

namespace App\Http\Controllers;
use App\Models\Recepcion;
use App\Models\Fuga;
use App\Models\Deceso;
use App\Models\Nacimiento;
use App\Models\Transferencia;
use Illuminate\Http\Request;
use DB; // Usamos DB para consultas directas
use Carbon\Carbon;
use PDF;

class ReporteController extends Controller
{
    // Método para mostrar el formulario de generación del reporte
    public function index()
    {
        return view('reporte.index');
    }

    // Método para generar el reporte
    public function generarReporte(Request $request)
    {
        // Lógica para generar el reporte
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
    
        // Consulta para obtener los datos de RECEPCION
        $recepcionDatos = DB::table('recepcion')
            ->leftJoin('fuga', 'recepcion.id_recepcion', '=', 'fuga.id_recepcion')
            ->leftJoin('deceso', 'recepcion.id_recepcion', '=', 'deceso.id_recepcion')
            ->leftJoin('nacimiento', 'recepcion.id_recepcion', '=', 'nacimiento.id_nacimiento')
            ->leftJoin('transferencia', 'recepcion.id_recepcion', '=', 'transferencia.id_recepcion')
            ->whereBetween('recepcion.fecha', [$fechaInicio, $fechaFin])
            ->select(
                'recepcion.clase',
                DB::raw('COUNT(recepcion.id_recepcion) as total_recepcion'),  // Contamos los registros de recepción
                DB::raw('COUNT(fuga.id_fuga) as total_fuga'),  // Contamos los registros de fuga
                DB::raw('COUNT(deceso.id_deceso) as total_deceso'),  // Contamos los registros de deceso
                DB::raw('0 as total_nacimiento'),  // Aquí agregamos un campo para total_nacimiento con valor 0
                DB::raw('COUNT(transferencia.id_transferencia) as total_transferencia')  // Contamos los registros de transferencia
            )
            ->groupBy('recepcion.clase');  // Agrupamos por clase
    
        // Consulta para obtener los datos de NACIMIENTO
        $nacimientoDatos = DB::table('nacimiento')
            ->leftJoin('fuga', 'nacimiento.id_nacimiento', '=', 'fuga.id_nacimiento')
            ->leftJoin('deceso', 'nacimiento.id_nacimiento', '=', 'deceso.id_nacimiento')
            ->leftJoin('transferencia', 'nacimiento.id_nacimiento', '=', 'transferencia.id_nacimiento')
            ->whereBetween('nacimiento.fecha', [$fechaInicio, $fechaFin])
            ->select(
                'nacimiento.clase',
                DB::raw('0 as total_recepcion'),  // Aquí agregamos un campo para total_recepcion con valor 0
                DB::raw('COUNT(fuga.id_fuga) as total_fuga'),  // Contamos los registros de fuga
                DB::raw('COUNT(deceso.id_deceso) as total_deceso'),  // Contamos los registros de deceso
                DB::raw('COUNT(nacimiento.id_nacimiento) as total_nacimiento'),  // Contamos los registros de nacimiento
                DB::raw('COUNT(transferencia.id_transferencia) as total_transferencia')  // Contamos los registros de transferencia
            )
            ->groupBy('nacimiento.clase');  // Agrupamos por clase
    
        // Combinamos los resultados de las dos consultas
        $datos = $recepcionDatos->unionAll($nacimientoDatos)->get();
    
        // Calcular los totales generales para cada categoría (Subtotal)
        $totalGeneralRecepcion = $datos->sum('total_recepcion');
        $totalGeneralFuga = $datos->sum('total_fuga');
        $totalGeneralDeceso = $datos->sum('total_deceso');
        $totalGeneralNacimiento = $datos->sum('total_nacimiento');
        $totalGeneralTransferencia = $datos->sum('total_transferencia');
    
        // Calcular el total general de todas las categorías sumadas (Total General)
        $totalGeneralTodo = $totalGeneralRecepcion + $totalGeneralFuga + $totalGeneralDeceso + $totalGeneralNacimiento + $totalGeneralTransferencia;
    
        // Generar el PDF con los datos y totales
        $pdf = PDF::loadView('reporte.flujos_poblacionales_pdf', [
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin,
            'datos' => $datos,
            'totalGeneralRecepcion' => $totalGeneralRecepcion,
            'totalGeneralFuga' => $totalGeneralFuga,
            'totalGeneralDeceso' => $totalGeneralDeceso,
            'totalGeneralNacimiento' => $totalGeneralNacimiento,
            'totalGeneralTransferencia' => $totalGeneralTransferencia,
            'totalGeneralTodo' => $totalGeneralTodo  // Pasamos el total general de todas las categorías
        ]);
    
        // Descargar el archivo PDF
        return $pdf->download('reporte_flujos_poblacionales.pdf');
    }
   
    public function exportarExcelManual(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
    
        // Obtener los datos combinados de Recepción y Nacimiento
        $recepcionDatos = DB::table('recepcion')
            ->leftJoin('fuga', 'recepcion.id_recepcion', '=', 'fuga.id_recepcion')
            ->leftJoin('deceso', 'recepcion.id_recepcion', '=', 'deceso.id_recepcion')
            ->leftJoin('nacimiento', 'recepcion.id_recepcion', '=', 'nacimiento.id_nacimiento')
            ->leftJoin('transferencia', 'recepcion.id_recepcion', '=', 'transferencia.id_recepcion')
            ->whereBetween('recepcion.fecha', [$fechaInicio, $fechaFin])
            ->select(
                'recepcion.clase',
                DB::raw('COUNT(recepcion.id_recepcion) as total_recepcion'),
                DB::raw('COUNT(fuga.id_fuga) as total_fuga'),
                DB::raw('COUNT(deceso.id_deceso) as total_deceso'),
                DB::raw('0 as total_nacimiento'),
                DB::raw('COUNT(transferencia.id_transferencia) as total_transferencia')
            )
            ->groupBy('recepcion.clase');
    
        $nacimientoDatos = DB::table('nacimiento')
            ->leftJoin('fuga', 'nacimiento.id_nacimiento', '=', 'fuga.id_nacimiento')
            ->leftJoin('deceso', 'nacimiento.id_nacimiento', '=', 'deceso.id_nacimiento')
            ->leftJoin('transferencia', 'nacimiento.id_nacimiento', '=', 'transferencia.id_nacimiento')
            ->whereBetween('nacimiento.fecha', [$fechaInicio, $fechaFin])
            ->select(
                'nacimiento.clase',
                DB::raw('0 as total_recepcion'),
                DB::raw('COUNT(fuga.id_fuga) as total_fuga'),
                DB::raw('COUNT(deceso.id_deceso) as total_deceso'),
                DB::raw('COUNT(nacimiento.id_nacimiento) as total_nacimiento'),
                DB::raw('COUNT(transferencia.id_transferencia) as total_transferencia')
            )
            ->groupBy('nacimiento.clase');
    
        // Combinar los datos
        $datos = $recepcionDatos->unionAll($nacimientoDatos)->get();
    
        // Generar el archivo Excel
        $excelData = [];
        $excelData[] = ['Clase', 'Total Recepción', 'Total Fuga', 'Total Deceso', 'Total Nacimiento', 'Total Transferencia'];
    
        // Agregar los datos de la tabla
        foreach ($datos as $dato) {
            $excelData[] = [
                $dato->clase,
                $dato->total_recepcion,
                $dato->total_fuga,
                $dato->total_deceso,
                $dato->total_nacimiento,
                $dato->total_transferencia
            ];
        }
    
        // Nombre del archivo
        $filename = 'reporte_flujos_poblacionales_' . Carbon::now()->format('Y-m-d_H-i-s') . '.xlsx';
    
        // Crear el archivo Excel manualmente (sin bibliotecas adicionales)
        $excelFile = fopen('php://output', 'w');
        ob_start();
        foreach ($excelData as $row) {
            fputcsv($excelFile, $row, "\t");
        }
        fclose($excelFile);
    
        // Enviar el archivo al navegador
        return response(ob_get_clean())
            ->header('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}    