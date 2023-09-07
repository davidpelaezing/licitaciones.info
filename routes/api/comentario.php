<?php

use App\Http\Controllers\ComentarioController;
use Illuminate\Support\Facades\Route;

Route::controller(ComentarioController::class)->prefix('comentario')->group(function () {
    Route::get('/', 'listar');
    Route::post('/crear', 'crear')->middleware('auth:sanctum');
    Route::put('/actualizar/{comentario}', 'actualizar')->middleware('auth:sanctum');
    Route::get('/consultar/{comentario}', 'consultar');
    Route::put('/cambiar-estado/{comentario}', 'cambiarEstado')->middleware('auth:sanctum');
});
