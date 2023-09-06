<?php

use App\Http\Controllers\CategoriaController;
use Illuminate\Support\Facades\Route;

Route::controller(CategoriaController::class)->prefix('categoria')->group(function () {
    Route::get('/', 'listar');
    Route::post('/crear', 'crear')->middleware('auth:sanctum', 'admin');
    Route::put('/actualizar/{categoria}', 'actualizar')->middleware('auth:sanctum', 'admin');
    Route::get('/consultar/{categoria}', 'consultar');
    Route::put('/cambiar-estado/{categoria}', 'cambiarEstado')->middleware('auth:sanctum', 'admin');
});
