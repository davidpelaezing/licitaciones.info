<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(UserController::class)->prefix('user')->middleware('auth:sanctum')->group(function () {
    Route::get('/', 'listar');
    Route::post('/crear', 'crear')->middleware('admin');
    Route::put('/actualizar/{user}', 'actualizar')->middleware('admin');
    Route::get('/consultar/{user}', 'consultar');
    Route::put('/cambiar-estado/{user}', 'cambiarEstado')->middleware('admin');
});
