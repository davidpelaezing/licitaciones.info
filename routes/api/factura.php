<?php

use App\Http\Controllers\FacturaController;
use Illuminate\Support\Facades\Route;

Route::controller(FacturaController::class)->prefix('factura')->group(function () {
    Route::get('/', 'listar')->middleware('auth:sanctum');
    Route::post('/crear', 'crear')->middleware('auth:sanctum');
    Route::get('/consultar/{factura}', 'consultar')->middleware('auth:sanctum');
    Route::put('/actualizar/{factura}', 'actualizar')->middleware('auth:sanctum', 'admin');
    Route::get('/exportar', 'exportar')->middleware('auth:sanctum', 'admin');
});
