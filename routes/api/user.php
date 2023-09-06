<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(UserController::class)->prefix('user')->group(function () {
    Route::get('/', 'listar');
    Route::post('/crear', 'crear');
    Route::put('/actualizar/{user}', 'actualizar');
    Route::post('/consultar/{user}', 'consultar');
    Route::put('/cambiar-estado/{user}', 'cambiarEstado');
});
