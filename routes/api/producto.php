<?php

use App\Http\Controllers\ProductoController;
use Illuminate\Support\Facades\Route;

Route::controller(ProductoController::class)->prefix('producto')->group(function () {
    Route::get('/', 'listar');
    Route::post('/crear', 'crear')->middleware('auth:sanctum', 'admin');
    Route::post('/actualizar/{producto}', 'actualizar')->middleware('auth:sanctum', 'admin');
    Route::get('/consultar/{producto}', 'consultar');
    Route::put('/cambiar-estado/{producto}', 'cambiarEstado')->middleware('auth:sanctum', 'admin');
});
