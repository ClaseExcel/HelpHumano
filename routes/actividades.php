<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    //Actividad cliente
    Route::get('capacitaciones/reporte/{id}', [ActividadClienteController::class, 'reporteIndex'])->name('reporte.index');
    Route::get('capacitaciones/reasignar-actividad/{id}', [ActividadClienteController::class, 'reasignarActividad'])->name('reporte.reasignar');
    Route::put('capacitaciones/reporte-edit/{id}', [ActividadClienteController::class, 'reporteEdit'])->name('reporte.update');
    Route::get('capacitaciones/cliente_id/{id}', [ActividadClienteController::class, 'showEmpresa']);
    Route::get('capacitaciones/usuario_id/{id?}', [ActividadClienteController::class, 'showResponsable'])->name('capacitaciones.responsable');
    Route::get('capacitaciones/reporte/usuario_id/{id}', [ActividadClienteController::class, 'showResponsable']);
    Route::get('capacitaciones/plantilla', [ActividadClienteController::class, 'masivoactividades'])->name('capacitaciones.masivoactividades');
    Route::post('capacitaciones/importExcel', [ActividadClienteController::class, 'importExcel'])->name('capacitaciones.importExcel');
    Route::post('capacitaciones/descargarExcel', [ActividadClienteController::class, 'descargarExcel'])->name('capacitaciones.descargarExcel');
    Route::resource('capacitaciones', ActividadClienteController::class)->except(['destroy']);
});
