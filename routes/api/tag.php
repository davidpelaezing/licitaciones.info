<?php

use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

Route::controller(TagController::class)->prefix('tag')->group(function () {
    Route::get('/', 'listar');
    Route::post('/crear', 'crear');
    Route::put('/actualizar/{tag}', 'actualizar');
    Route::post('/consultar/{tag}', 'consultar');
    Route::put('/cambiar-estado/{tag}', 'cambiarEstado');
});
