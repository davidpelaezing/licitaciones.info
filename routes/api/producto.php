<?php

use App\Http\Controllers\ProductoController;
use Illuminate\Support\Facades\Route;

Route::controller(ProductoController::class)->prefix('producto')->group(function () {
    Route::get('/', 'listar');
    Route::post('/crear', 'crear');
    Route::put('/actualizar/{producto}', 'actualizar');
    Route::post('/consultar/{producto}', 'consultar');
    Route::put('/cambiar-estado/{producto}', 'cambiarEstado');
});
