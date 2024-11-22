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
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
            ->leftJoin('nacimiento', 'recepcion.id_recepcion', '=', 'nacimiento.id_recepcion')
            ->leftJoin('transferencia', 'recepcion.id_recepcion', '=', 'transferencia.id_recepcion')
            ->whereBetween('recepcion.fecha', [$fechaInicio, $fechaFin])
            ->select(
                'recepcion.clase',
                DB::raw('COUNT(DISTINCT recepcion.id_recepcion) as total_recepcion'),
                DB::raw('COUNT(DISTINCT fuga.id_fuga) as total_fuga'),
                DB::raw('COUNT(DISTINCT deceso.id_deceso) as total_deceso'),
                DB::raw('0 as total_nacimiento'), // Campo con valor 0 para nacimientos en la tabla de recepción
                DB::raw('COUNT(DISTINCT transferencia.id_transferencia) as total_transferencia')
            )
            ->groupBy('recepcion.clase');

        // Consulta para obtener los datos de NACIMIENTO
        $nacimientoDatos = DB::table('nacimiento')
            ->leftJoin('fuga', 'nacimiento.id_nacimiento', '=', 'fuga.id_nacimiento')
            ->leftJoin('deceso', 'nacimiento.id_nacimiento', '=', 'deceso.id_nacimiento')
            ->leftJoin('transferencia', 'nacimiento.id_nacimiento', '=', 'transferencia.id_nacimiento')
            ->whereBetween('nacimiento.fecha', [$fechaInicio, $fechaFin])
            ->select(
                'nacimiento.clase',
                DB::raw('0 as total_recepcion'), // Campo con valor 0 para recepciones en la tabla de nacimiento
                DB::raw('COUNT(DISTINCT fuga.id_fuga) as total_fuga'),
                DB::raw('COUNT(DISTINCT deceso.id_deceso) as total_deceso'),
                DB::raw('COUNT(DISTINCT nacimiento.id_nacimiento) as total_nacimiento'),
                DB::raw('COUNT(DISTINCT transferencia.id_transferencia) as total_transferencia')
            )
            ->groupBy('nacimiento.clase');

        // Unir ambas consultas para obtener todos los datos
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
            'totalGeneralTodo' => $totalGeneralTodo // Pasamos el total general de todas las categorías
        ]);

        // Descargar el archivo PDF
        return $pdf->download('reporte_flujos_poblacionales.pdf');
    }

 // Método para exportar el reporte a Excel
 public function exportarExcel(Request $request)
 {
     $fechaInicio = $request->input('fecha_inicio');
     $fechaFin = $request->input('fecha_fin');
 
     // Consulta para obtener los datos de RECEPCION
     $recepcionDatos = DB::table('recepcion')
         ->leftJoin('fuga', 'recepcion.id_recepcion', '=', 'fuga.id_recepcion')
         ->leftJoin('deceso', 'recepcion.id_recepcion', '=', 'deceso.id_recepcion')
         ->leftJoin('nacimiento', 'recepcion.id_recepcion', '=', 'nacimiento.id_recepcion')
         ->leftJoin('transferencia', 'recepcion.id_recepcion', '=', 'transferencia.id_recepcion')
         ->whereBetween('recepcion.fecha', [$fechaInicio, $fechaFin])
         ->select(
             'recepcion.clase',
             DB::raw('COUNT(DISTINCT recepcion.id_recepcion) as total_recepcion'),
             DB::raw('COUNT(DISTINCT fuga.id_fuga) as total_fuga'),
             DB::raw('COUNT(DISTINCT deceso.id_deceso) as total_deceso'),
             DB::raw('0 as total_nacimiento'), // Campo con valor 0 para nacimientos en la tabla de recepción
             DB::raw('COUNT(DISTINCT transferencia.id_transferencia) as total_transferencia')
         )
         ->groupBy('recepcion.clase');
 
     // Consulta para obtener los datos de NACIMIENTO
     $nacimientoDatos = DB::table('nacimiento')
         ->leftJoin('fuga', 'nacimiento.id_nacimiento', '=', 'fuga.id_nacimiento')
         ->leftJoin('deceso', 'nacimiento.id_nacimiento', '=', 'deceso.id_nacimiento')
         ->leftJoin('transferencia', 'nacimiento.id_nacimiento', '=', 'transferencia.id_nacimiento')
         ->whereBetween('nacimiento.fecha', [$fechaInicio, $fechaFin])
         ->select(
             'nacimiento.clase',
             DB::raw('0 as total_recepcion'), // Campo con valor 0 para recepciones en la tabla de nacimiento
             DB::raw('COUNT(DISTINCT fuga.id_fuga) as total_fuga'),
             DB::raw('COUNT(DISTINCT deceso.id_deceso) as total_deceso'),
             DB::raw('COUNT(DISTINCT nacimiento.id_nacimiento) as total_nacimiento'),
             DB::raw('COUNT(DISTINCT transferencia.id_transferencia) as total_transferencia')
         )
         ->groupBy('nacimiento.clase');
 
     // Unir ambas consultas para obtener todos los datos
     $datos = $recepcionDatos->unionAll($nacimientoDatos)->get();
 
     // Crear el archivo Excel
     $spreadsheet = new Spreadsheet();
     $sheet = $spreadsheet->getActiveSheet();
 
     // Estilo para los encabezados
     $styleArrayHeader = [
         'font' => [
             'bold' => true,
             'size' => 12,
             'color' => ['argb' => 'FFFFFF'], // Color blanco para texto
         ],
         'alignment' => [
             'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
         ],
         'borders' => [
             'allBorders' => [
                 'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
             ],
         ],
         'fill' => [
             'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
             'startColor' => ['argb' => '4F81BD'], // Fondo azul
         ],
     ];
 
     // Estilo para las celdas de datos
     $styleArrayData = [
         'font' => [
             'size' => 10,
         ],
         'alignment' => [
             'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
         ],
         'borders' => [
             'allBorders' => [
                 'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
             ],
         ],
     ];
 
     // Estilo para los totales generales (color amarillo)
     $styleArrayTotalYellow = [
         'font' => [
             'bold' => true,
             'size' => 12,
             'color' => ['argb' => '000000'], // Color blanco para texto
         ],
         'alignment' => [
             'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
         ],
         'borders' => [
             'allBorders' => [
                 'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
             ],
         ],
         'fill' => [
             'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
             'startColor' => ['argb' => 'FFFF00'], // Fondo amarillo
         ],
     ];
 
     // Escribir el título en la primera fila
     $sheet->setCellValue('A1', 'Reporte Fauna Silvestre');
     $sheet->mergeCells('A1:F1');
     $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
     $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
 
     // Escribir las fechas de inicio y fin en las filas siguientes
     $sheet->setCellValue('A2', 'Fecha de Inicio: ' . $fechaInicio);
     $sheet->setCellValue('A3', 'Fecha de Fin: ' . $fechaFin);
 
     // Ajustar el estilo para las fechas
     $sheet->getStyle('A2')->getFont()->setItalic(true);
     $sheet->getStyle('A3')->getFont()->setItalic(true);
 
     // Encabezados con estilos
     $sheet->setCellValue('A4', 'Clase');
     $sheet->setCellValue('B4', 'Total Recepción');
     $sheet->setCellValue('C4', 'Total Fuga');
     $sheet->setCellValue('D4', 'Total Deceso');
     $sheet->setCellValue('E4', 'Total Nacimiento');
     $sheet->setCellValue('F4', 'Total Transferencia');
 
     // Aplicar estilo a los encabezados
     $sheet->getStyle('A4:F4')->applyFromArray($styleArrayHeader);
 
     // Ajustar el ancho de las columnas
     foreach (range('A', 'F') as $columnID) {
         $sheet->getColumnDimension($columnID)->setAutoSize(true);  // Ajusta automáticamente el ancho
     }
 
     // Agregar los datos
     $row = 5; // Comienza en la fila 5
     $totalRecepcion = 0;
     $totalFuga = 0;
     $totalDeceso = 0;
     $totalNacimiento = 0;
     $totalTransferencia = 0;
 
     foreach ($datos as $dato) {
         $sheet->setCellValue('A' . $row, $dato->clase);
         $sheet->setCellValue('B' . $row, $dato->total_recepcion);
         $sheet->setCellValue('C' . $row, $dato->total_fuga);
         $sheet->setCellValue('D' . $row, $dato->total_deceso);
         $sheet->setCellValue('E' . $row, $dato->total_nacimiento);
         $sheet->setCellValue('F' . $row, $dato->total_transferencia);
 
         // Establecer el estilo a las celdas de datos
         $sheet->getStyle('A' . $row . ':F' . $row)->applyFromArray($styleArrayData);
 
         $totalRecepcion += $dato->total_recepcion;
         $totalFuga += $dato->total_fuga;
         $totalDeceso += $dato->total_deceso;
         $totalNacimiento += $dato->total_nacimiento;
         $totalTransferencia += $dato->total_transferencia;
 
         $row++;
     }
 
     // Escribir los totales generales al final
     $sheet->setCellValue('A' . $row, 'Total General');
     $sheet->setCellValue('B' . $row, $totalRecepcion);
     $sheet->setCellValue('C' . $row, $totalFuga);
     $sheet->setCellValue('D' . $row, $totalDeceso);
     $sheet->setCellValue('E' . $row, $totalNacimiento);
     $sheet->setCellValue('F' . $row, $totalTransferencia);
 
     // Establecer el estilo para los totales generales
     $sheet->getStyle('A' . $row . ':F' . $row)->applyFromArray($styleArrayTotalYellow); // Cuadro de color amarillo
 
     // Después de la tabla, agregar la suma de todos los totales
     $totalTodos = $totalRecepcion + $totalFuga + $totalDeceso + $totalNacimiento + $totalTransferencia;
 
     // Agregar la suma total al final de la tabla
     // Agregar la suma total al final de la tabla con estilo amarillo
$sheet->setCellValue('A' . ($row + 1), 'Total de Todos');
$sheet->setCellValue('B' . ($row + 1), $totalTodos);


// Aplicar estilo amarillo a las celdas
$sheet->getStyle('A' . ($row + 1) . ':B' . ($row + 1))->applyFromArray($styleArrayTotalYellow);

 
     // Descargar el archivo Excel
     $writer = new Xlsx($spreadsheet);
     $filename = 'reporte_fauna_silvestre.xlsx';
     return response()->stream(
         function () use ($writer) {
             $writer->save('php://output');
         },
         200,
         [
             'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
             'Content-Disposition' => 'attachment;filename="' . $filename . '"',
             'Cache-Control' => 'max-age=0',
         ]
     );
 }
} 