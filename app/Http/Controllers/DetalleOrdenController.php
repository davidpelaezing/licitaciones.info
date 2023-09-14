<?php

namespace App\Http\Controllers;

use App\Events\NuevoProductoAgregadoEvent;
use App\Http\Requests\ActualizarDetalleOrdenRequest;
use App\Http\Requests\CrearDetalleOrdenRequest;
use App\Models\DetalleOrden;
use App\Models\Orden;
use Error;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DetalleOrdenController extends Controller
{
    /**
     * crea/agrega un nuevo producto a una orden, ergo crea un detalle de orden
     * @param Request $request
     * @return JsonResponse
     * @author David Peláez
     */
    public function crear(CrearDetalleOrdenRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            // Obtenemos la orden activa del usuario, de no tener creamos una
            $orden = Orden::firstOrCreate(
                ['user_id' => Auth::id(), 'estado_id' => 1],
                ['estado_id' => 1]
            );

            // agregamos el id de la orden a la data
            $data = $request->validated();
            $data['orden_id'] = $orden->id;

            $detalle = DetalleOrden::create($data);
            event(new NuevoProductoAgregadoEvent());
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json($th->getMessage(), 400);
        }
        DB::commit();
        return response()->json($detalle, 201);
    }

    /**
     * actualiza un detalle
     * @param Request $request
     * @param DetalleOrden $detalle
     * @return JsonResponse
     */
    public function actualizar(ActualizarDetalleOrdenRequest $request, DetalleOrden $detalle): JsonResponse
    {
        try {
            $this->validar($detalle);
            $detalle->update($request->validated());
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), $th->getCode());
        }
        return response()->json($detalle, 200);
    }

    /**
     * actualiza un detalle
     * @param Request $request
     * @param DetalleOrden $detalle
     * @return JsonResponse
     * @author David Peláez
     */
    public function eliminar(Request $request, DetalleOrden $detalle): JsonResponse
    {
        try {
            $this->validar($detalle);
            $detalle->delete();
            if (!count($detalle->orden->detalles)) {
                $detalle->orden->cambiarEstado(3);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), $th->getCode());
        }
        return response()->json($detalle, 200);
    }

    /**
     * Valid que el detalle le pertenezca al usuario
     * Valids que la orden este activa
     * @param DetalleOrden $detalle
     * @return void
     * @author David Peláez
     */
    private function validar($detalle): void
    {
        // Validamos que el detalle le pertenezca al usuario
        if (!$detalle->orden->mePertenece()) {
            throw new Error('Inautorizado.', 401);
        }

        // Validamos que la orden este activa
        if (!$detalle->orden->isActivo()) {
            throw new Error('Orden inactiva', 422);
        }
    }
}
