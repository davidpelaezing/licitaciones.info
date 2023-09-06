<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActualizarProductoRequest;
use App\Http\Requests\CrearProductoRequest;
use App\Models\Producto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Lista todas los productos
     * @param Request $request
     * @return JsonResponse
     * @author David Peláez
     */
    public function listar(Request $request): JsonResponse
    {
        try {
            $productos = Producto::all();
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
        return response()->json($productos);
    }

    /**
     * Almacena un producto
     * @param Request $request
     * @return JsonResponse
     * @author David Peláez
     */
    public function crear(CrearProductoRequest $request): JsonResponse
    {
        $data = $request->except('tags');
        try {
            $producto = Producto::create($data);
            // sincronizamos los tags con el producto
            $producto->tags()->sync($request->tags);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
        return response()->json($producto, 201);
    }

    /**
     * Actualiza un producto
     * @param Request $request
     * @param Producto $producto
     * @return JsonResponse
     * @author David Peláez
     */
    public function actualizar(ActualizarProductoRequest $request, Producto $producto): JsonResponse
    {
        $data = $request->except('tags');
        try {
            $producto->updated($data);
            // sincronizamos los tags con el producto
            $producto->tags()->sync($request->tags);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
        return response()->json($producto);
    }

    /**
     * muestra un producto
     * @param Request $request
     * @param Producto $producto
     * @return JsonResponse
     * @author David Peláez
     */
    public function consultar(Request $request, Producto $producto): JsonResponse
    {
        return response()->json($producto);
    }

    /**
     * cambia el estado de una producto
     * @param Request $request
     * @param Producto $producto
     * @return JsonResponse
     * @author David Peláez 
     */
    public function cambiarEstado(Request $request, Producto $producto): JsonResponse
    {
        try {
            $producto->cambiarEstado();
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
        return response()->json($producto);
    }
}
