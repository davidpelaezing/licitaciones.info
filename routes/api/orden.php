<?php

use App\Http\Controllers\DetalleOrdenController;
use App\Http\Controllers\OrdenController;
use Illuminate\Support\Facades\Route;

Route::prefix('orden')->middleware('auth:sanctum')->group(function () {
    Route::controller(OrdenController::class)->group(function () {
        Route::get('/', 'listar');
        Route::put('/cambiar-estado/{orden}', 'cambiarEstado');
        Route::get('/consultar/{orden}', 'consultar');
    });

    Route::controller(DetalleOrdenController::class)->group(function () {
        Route::post('/agregar-producto', 'crear');
        Route::put('/actualizar-producto/{detalle}', 'actualizar');
        Route::delete('/eliminar-producto/{detalle}', 'eliminar');
    });
});
