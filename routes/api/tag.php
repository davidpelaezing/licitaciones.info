<?php

use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

Route::controller(TagController::class)->prefix('tag')->group(function () {
    Route::get('/', 'listar');
    Route::post('/crear', 'crear')->middleware('auth:sanctum', 'admin');
    Route::put('/actualizar/{tag}', 'actualizar')->middleware('auth:sanctum', 'admin');
    Route::get('/consultar/{tag}', 'consultar');
    Route::put('/cambiar-estado/{tag}', 'cambiarEstado')->middleware('auth:sanctum', 'admin');
});
