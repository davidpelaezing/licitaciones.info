<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActualizarTagRequest;
use App\Http\Requests\CrearTagRequest;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Lista todas los tags
     * @param Request $request
     * @return JsonResponse
     * @author David Peláez
     */
    public function listar(Request $request): JsonResponse
    {
        try {
            $tags = Tag::all();
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
        return response()->json($tags);
    }

    /**
     * Almacena un tag
     * @param Request $request
     * @return JsonResponse
     * @author David Peláez
     */
    public function crear(CrearTagRequest $request): JsonResponse
    {
        try {
            $tag = Tag::create($request->validated());
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
        return response()->json($tag, 201);
    }

    /**
     * Actualiza un tag
     * @param Request $request
     * @param Tag $tag
     * @return JsonResponse
     * @author David Peláez
     */
    public function actualizar(ActualizarTagRequest $request, Tag $tag): JsonResponse
    {
        try {
            $tag->update($request->validated());
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
        return response()->json($tag);
    }

    /**
     * muestra un tag
     * @param Request $request
     * @param Tag $tag
     * @return JsonResponse
     * @author David Peláez
     */
    public function consultar(Request $request, Tag $tag): JsonResponse
    {
        return response()->json($tag);
    }

    /**
     * cambia el estado de un tag
     * @param Request $request
     * @param Tag $tag
     * @return JsonResponse
     * @author David Peláez 
     */
    public function cambiarEstado(Request $request, Tag $tag): JsonResponse
    {
        try {
            $tag->cambiarEstado();
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
        return response()->json($tag);
    }
}
