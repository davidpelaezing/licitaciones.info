<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActualizarProductoRequest;
use App\Http\Requests\CrearProductoRequest;
use App\Models\Producto;
use App\Traits\ImagenTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    use ImagenTrait;

    /**
     * Lista todas los productos
     * @param Request $request
     * @return JsonResponse
     * @author David Peláez
     */
    public function listar(Request $request): JsonResponse
    {
        try {
            $productos = Producto::with('categoria', 'tags:id,nombre')
                ->whereCategoria($request->categoria_id)
                ->orderPrecio($request->order);
            $data = $request->page ? $productos->paginate(10) : $productos->get();
            return response()->json($data);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * Almacena un producto
     * @param Request $request
     * @return JsonResponse
     * @author David Peláez
     */
    public function crear(CrearProductoRequest $request): JsonResponse
    {
        $data = $request->except('tags', 'imagen');
        try {
            $producto = Producto::create($data);

            // sincronizamos los tags con el producto
            $producto->tags()->sync($request->tags);

            // si se ha enviado una imagen la almacenamos y guardamos la ruta
            if ($request->hasFile('imagen')) {
                $ruta = $this->subirImagen('productos', $request->file('imagen'));
                $producto->actualizarImagen($ruta);
            }
            return response()->json($producto, 201);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
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
        $data = $request->except('tags', 'imagen');
        try {
            $producto->update($data);

            // sincronizamos los tags con el producto
            $producto->tags()->sync($request->tags);

            // si se ha enviado una imagen la almacenamos y guardamos la ruta, no sin antes eliminar la enterior si es que la tiene
            if ($request->hasFile('imagen')) {

                if ($producto->imagen_url) {
                    $this->eliminarImagen($producto->imagen_url);
                }

                $ruta = $this->subirImagen('productos', $request->file('imagen'));
                $producto->actualizarImagen($ruta);
            }
            return response()->json($producto);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * muestra un producto
     * @param Request $request
     * @param Producto $producto
     * @return JsonResponse
     * @author David Peláez
     */
    public function consultar(Request $request, $id): JsonResponse
    {
        $producto = Producto::where('id', $id)
            ->with(
                [
                    'categoria',
                    'tags',
                    'comentarios' => function ($query) {
                        $query->with('user')->latest()->limit(5); // Obtener los últimos 5 comentarios
                    }
                ]
            )
            ->first();
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
            return response()->json($producto);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }
}
