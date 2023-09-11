<?php

use App\Http\Controllers\CategoriaController;
use Illuminate\Support\Facades\Route;

Route::controller(CategoriaController::class)->prefix('categoria')->group(function () {
    Route::get('/', 'listar')->middleware('auth:sanctum');
    Route::post('/crear', 'crear')->middleware('auth:sanctum');
    Route::get('/consultar/{categoria}', 'consultar')->middleware('auth:sanctum');
});
