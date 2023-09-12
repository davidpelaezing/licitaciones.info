<?php

namespace App\Http\Controllers;

use App\Http\Requests\CrearFacturaRequest;
use App\Models\DetalleFactura;
use App\Models\Factura;
use App\Models\Orden;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FacturaController extends Controller
{
    /**
     * Lista todas las facturas
     * @param Request $request
     * @return JsonResponse
     * @author David Peláez
     */
    public function listar(Request $request): JsonResponse
    {
        try {
            $facturas = Factura::all();
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
        return response()->json($facturas);
    }

    /**
     * Almacena una factura
     * @param Request $request
     * @return JsonResponse
     * @author David Peláez
     */
    public function crear(CrearFacturaRequest $request): JsonResponse
    {
        try {
            // Iniciamos transaccion (Por que habra varias insersiones )
            DB::beginTransaction();
            // recuperamos la orden
            $orden = Orden::where('user_id', Auth::id())
                ->where('estado_id', 1)
                ->firstOrFail();

            // preparamos la data para la factura
            $data = $request->validated();
            $data['user_id'] = $orden->user_id;
            $data['orden_id'] = $orden->orden_id;

            DB::beginTransaction();
            // creamos la factura
            $factura = Factura::create($data);

            //creamos los detalles de la factura
            foreach ($orden->detalles as $detalle) {
                DetalleFactura::create([
                    'factura_id' => $factura->id,
                    'producto_id' => $detalle->producto_id,
                    'cantidad' => $detalle->cantidad,
                    'precio_unitario' => $detalle->producto->precio,
                    'total' => $detalle->cantidad * $detalle->producto->precio,
                ]);
            }

            // cambiamos el estado de la orden
            $orden->cambiarEstado(2);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json($th->getMessage(), 400);
        }
        DB::commit();
        return response()->json($factura, 201);
    }

    /**
     * muestra una factura
     * @param Request $request
     * @param Factura $factura
     * @return JsonResponse
     * @author David Peláez
     */
    public function consultar(Request $request, Factura $factura): JsonResponse
    {
        return response()->json($factura);
    }
}
