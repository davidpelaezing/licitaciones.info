<?php

namespace App\Http\Controllers;

use App\Http\Requests\CambiarEstadoOrdenRequest;
use App\Models\Orden;
use Error;
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
        try {
            $this->validar($orden);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), $th->getCode());
        }
        return response()->json($orden);
    }

    /**
     * cambia el estado de una orden
     * @param Request $request
     * @param Orden $orden
     * @return JsonResponse
     * @author David Peláez 
     */
    public function cambiarEstado(CambiarEstadoOrdenRequest $request, Orden $orden): JsonResponse
    {
        try {
            $this->validar($orden);
            $orden->cambiarEstado($request->estado_id);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
        return response()->json($orden);
    }

    /**
     * valida que pertenezca a el usuario
     * @param $orden
     * @return void
     * @author David Peláez
     */
    private function validar($orden): void
    {
        if (!$orden->mePertenece()) {
            throw new Error('Inautorizado.', 401);
        }
    }
}
