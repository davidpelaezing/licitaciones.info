<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

require __DIR__ . '/api/auth.php';
require __DIR__ . '/api/categoria.php';
require __DIR__ . '/api/comentario.php';
require __DIR__ . '/api/producto.php';
require __DIR__ . '/api/tag.php';
require __DIR__ . '/api/user.php';
require __DIR__ . '/api/orden.php';
require __DIR__ . '/api/factura.php';
