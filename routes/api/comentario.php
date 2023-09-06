<?php

use App\Http\Controllers\ComentarioController;
use Illuminate\Support\Facades\Route;

Route::controller(ComentarioController::class)->prefix('comentario')->group(function () {
    Route::get('/', 'listar');
    Route::post('/crear', 'crear');
    Route::put('/actualizar/{comentario}', 'actualizar');
    Route::post('/consultar/{comentario}', 'consultar');
    Route::put('/cambiar-estado/{comentario}', 'cambiarEstado');
});
