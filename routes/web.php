<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\InstitucionController;
use App\Http\Controllers\MunicipioController;
use App\Http\Controllers\RecepcionController;
use App\Http\Controllers\NacimientoController;
use App\Http\Controllers\NacimientosController;
use App\Http\Controllers\DecesoController;
use App\Http\Controllers\FugaController;
use App\Http\Controllers\TransferenciaController;
use App\Http\Controllers\InformeClinicoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ReporteController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});
///////////////////esto restringir alos usuarios normalñes solo el admini puede verlo /////////////////////////////////////////////

// Agrupamos las rutas que solo los administradores pueden ver
Route::group(['middleware' => ['role:admin']], function () {
    Route::resource('usuario/municipio', MunicipioController::class);
    Route::resource('usuario/institucion', InstitucionController::class);
    Route::resource('seguridad/usuario', UsuarioController::class);
});


////////// esto verlo todos los usuarios y admin  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
Route::resource('registro/recepcion', RecepcionController::class);
Route::resource('registro/nacimiento', NacimientosController::class);
Route::resource('registro/deceso', DecesoController::class);
Route::resource('registro/fuga', FugaController::class);
Route::resource('derivacion/transferencia', TransferenciaController::class);
Route::resource('informeclinico', InformeClinicoController::class);

///////trasferencia/////////////////
Route::post('recepcion/{id}/transferir', [RecepcionController::class, 'transferir'])->name('recepcion.transferir');
Route::post('/nacimiento/transferir/{id}', [NacimientosController::class, 'transferir'])->name('nacimiento.transferir');
/////////////////
// Ruta para exportar el PDF de recepción y informe clinico
Route::get('registro/recepcion/{id}/exportPdf', [RecepcionController::class, 'exportPdf'])->name('recepcion.exportPdf');
Route::get('informeclinico/{id}/export-pdf', [InformeClinicoController::class, 'exportPdf'])->name('informeclinico.export.pdf');

//////automaticamente para login rutas laravel /ui//////////////////////////////

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

// Ruta para descargar el reporte PDF
Route::get('/reportes/descargar', [RecepcionController::class, 'descargarReportePDF'])->name('reporte.descargar');

///////////fugasRuta para descargar el reporte en PDF///////////////////////
Route::get('/fuga/reporte/clase', [FugaController::class, 'reportePorClase'])->name('fuga.reporte.clase');
Route::get('/fuga/reporte/pdf', [FugaController::class, 'descargarReportePDF'])->name('fuga.reporte.pdf');
///////////////////nacimiento_Ruta para descargar el reporte en PDF////////////////////////////
Route::get('/nacimiento/reporte', [NacimientosController::class, 'reportePorClase'])->name('nacimiento.reporte');
Route::get('/nacimiento/reporte/descargar', [NacimientosController::class, 'descargarReportePDF'])->name('nacimiento.reporte.descargar');


// Ruta para generar el PDF del reporte de decesos
Route::get('deceso/r eporte', [DecesoController::class, 'reportePorClaseDeceso'])->name('deceso.reporte');
Route::get('deceso/reporte/pdf', [DecesoController::class, 'descargarReporteDecesoPDF'])->name('deceso.reporte.pdf');
/////////////////////transferencia///////////////

// Rutas para el reporte de transferencias por clase
Route::get('/transferencias/reporte', [TransferenciaController::class, 'reportePorClaseTransferencia'])
    ->name('transferencia.reporte');

Route::get('/transferencias/reporte/pdf', [TransferenciaController::class, 'descargarReporteTransferenciaPDF'])
    ->name('transferencia.reporte.pdf');

  

    // Ruta para mostrar el formulario de generación de reporte trimestral 
    Route::get('reporte', [ReporteController::class, 'index'])->name('reporte.index');
    
    // Ruta para generar el reporte
    Route::get('reporte/generar', [ReporteController::class, 'reporte'])->name('reporte.generar');
    Route::get('/reporte/pdf', [ReporteController::class, 'generarReporte'])->name('reporte.pdf');
// Ruta para generar el reporte en PDF
Route::get('/reporte/generar', [ReporteController::class, 'generarReporte'])->name('reporte.generar');

Route::get('/exportar/excel', [ReporteController::class, 'exportarExcelManual'])->name('exportar.excel.manual');
Route::get('/exportar/excel/manual', [ReporteController::class, 'exportarExcelManual'])->name('exportar.excel.manual');
///////////////////////
// Asegúrate de que tienes una ruta que apunte a tu controlador
Route::get('/exportar/excel/manual', [ReporteController::class, 'exportarExcelManual']);
Route::get('exportar-excel/{fechaInicio}/{fechaFin}', [ReporteController::class, 'exportExcel'])->name('export.excel');
Route::post('/reporte/exportar-excel', [ReporteController::class, 'exportarExcel'])->name('reporte.exportarExcel');
