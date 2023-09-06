<?php

use App\Http\Controllers\CategoriaController;
use Illuminate\Support\Facades\Route;

Route::controller(CategoriaController::class)->prefix('categoria')->group(function () {
    Route::get('/', 'listar');
    Route::post('/crear', 'crear');
    Route::put('/actualizar/{categoria}', 'actualizar');
    Route::post('/consultar/{categoria}', 'consultar');
    Route::put('/cambiar-estado/{categoria}', 'cambiarEstado');
});
