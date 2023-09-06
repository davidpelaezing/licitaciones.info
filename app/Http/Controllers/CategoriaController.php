<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActualizarCategoriaRequest;
use App\Http\Requests\CrearCategoriaRequest;
use App\Models\Categoria;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Lista todas las categorias
     * @param Request $request
     * @return JsonResponse
     * @author David Peláez
     */
    public function listar(Request $request): JsonResponse
    {
        try {
            $categorias = Categoria::all();
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
        return response()->json($categorias);
    }

    /**
     * Almacena una categoria
     * @param Request $request
     * @return JsonResponse
     * @author David Peláez
     */
    public function crear(CrearCategoriaRequest $request): JsonResponse
    {
        try {
            $categoria = Categoria::create($request->validated());
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
        return response()->json($categoria, 201);
    }

    /**
     * Actualiza una categoria
     * @param Request $request
     * @param Categoria $categoria
     * @return JsonResponse
     * @author David Peláez
     */
    public function actualizar(ActualizarCategoriaRequest $request, Categoria $categoria): JsonResponse
    {
        try {
            $categoria->update($request->validated());
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
        return response()->json($categoria);
    }

    /**
     * muestra una categoria
     * @param Request $request
     * @param Categoria $categoria
     * @return JsonResponse
     * @author David Peláez
     */
    public function consultar(Request $request, Categoria $categoria): JsonResponse
    {
        return response()->json($categoria);
    }

    /**
     * cambia el estado de una categoria
     * @param Request $request
     * @param Categoria $categoria
     * @return JsonResponse
     * @author David Peláez 
     */
    public function cambiarEstado(Request $request, Categoria $categoria): JsonResponse
    {
        try {
            $categoria->cambiarEstado();
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
        return response()->json($categoria);
    }
}
