<?php

namespace App\Http\Controllers;

use App\Models\Orden;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrdenController extends Controller
{
    /**
     * Lista todas los ordenes
     * @param Request $request
     * @return JsonResponse
     * @author David Peláez
     */
    public function listar(Request $request): JsonResponse
    {
        try {
            $ordenes = Orden::all();
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
        return response()->json($ordenes);
    }

    /**
     * muestra una orden
     * @param Request $request
     * @param Orden $orden
     * @return JsonResponse
     * @author David Peláez
     */
    public function consultar(Request $request, Orden $orden): JsonResponse
    {
        return response()->json($orden);
    }

    /**
     * cambia el estado de una orden
     * @param Request $request
     * @param Orden $orden
     * @return JsonResponse
     * @author David Peláez 
     */
    public function cambiarEstado(Request $request, Orden $orden): JsonResponse
    {
        try {
            $orden->cambiarEstado();
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
        return response()->json($orden);
    }
}
