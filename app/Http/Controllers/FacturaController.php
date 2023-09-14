<?php

namespace App\Http\Controllers;

use App\Events\NuevaFacturaRegistradaEvent;
use App\Http\Requests\ActualizarFacturaRequest;
use App\Http\Requests\CrearFacturaRequest;
use App\Models\DetalleFactura;
use App\Models\Factura;
use App\Models\Orden;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Rap2hpoutre\FastExcel\FastExcel;

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
            $facturas = Factura::withCount('detalles')->with([
                'user',
                'detalles' => function ($query) {
                    return $query->with('producto');
                },
                'orden' => function ($query) {
                    return $query->with('estado');
                }
            ]);

            // si no es un administrador solo puede ver sus facturas
            if (!Auth::user()->admin) {
                $facturas->where('user_id', Auth::id());
            }

            $data = $request->page ? $facturas->paginate(10) : $facturas->get();
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
        return response()->json($data);
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
            $data['user_id'] = $request->user_id ? $request->user_id : Auth::id();
            $data['orden_id'] = $orden->id;

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
            /** disparamos el evento */
            event(new NuevaFacturaRegistradaEvent());
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json($th->getMessage(), 400);
        }
        DB::commit();
        return response()->json($factura, 201);
    }

    /**
     * Actualiza una factura
     * @param Request $request
     * @return JsonResponse
     * @author David Peláez 
     */
    public function actualizar(ActualizarFacturaRequest $request, Factura $factura): JsonResponse
    {
        try {
            $factura->update($request->validated());
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
        return response()->json($factura, 200);
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

    /**
     * Exporta los datos en un excel
     * @param Request $request
     * @return xls
     * @author David Peláez
     */
    public function exportar(Request $request)
    {
        //$consulta = Artisan::call('producto:exports');
        //return response()->json($consulta);
        $consulta = DB::table('detalle_facturas')
            ->join('productos', 'detalle_facturas.producto_id', '=', 'productos.id')
            ->select('detalle_facturas.producto_id', 'productos.nombre', DB::raw('SUM(detalle_facturas.cantidad) as total_cantidad'))
            ->groupBy('detalle_facturas.producto_id', 'productos.nombre')
            ->get();
        return (new FastExcel($consulta))->download('productos.xlsx');
    }
}
