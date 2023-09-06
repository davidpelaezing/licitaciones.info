<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActualizarComentarioRequest;
use App\Http\Requests\CrearComentarioRequest;
use App\Models\Comentario;
use App\Traits\HelperTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    use HelperTrait;

    /**
     * Lista todas los comentarios
     * @param Request $request
     * @return JsonResponse
     * @author David Peláez
     */
    public function listar(Request $request): JsonResponse
    {
        try {
            $comentarios = Comentario::all();
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
        return response()->json($comentarios);
    }

    /**
     * Almacena un comentario
     * @param Request $request
     * @return JsonResponse
     * @author David Peláez
     */
    public function crear(CrearComentarioRequest $request): JsonResponse
    {
        try {
            $data = $this->agregarCampoUserId($request->validated());
            $comentario = Comentario::create($data);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
        return response()->json($comentario, 201);
    }

    /**
     * Actualiza un comentario
     * @param Request $request
     * @param Comentario $comentario
     * @return JsonResponse
     * @author David Peláez
     */
    public function actualizar(ActualizarComentarioRequest $request, Comentario $comentario): JsonResponse
    {
        try {
            $comentario->updated($request->validated());
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
        return response()->json($comentario);
    }

    /**
     * muestra un comentario
     * @param Request $request
     * @param comentario $comentario
     * @return JsonResponse
     * @author David Peláez
     */
    public function consultar(Request $request, Comentario $comentario): JsonResponse
    {
        return response()->json($comentario);
    }

    /**
     * cambia el estado de una comentario
     * @param Request $request
     * @param Comentario $comentario
     * @return JsonResponse
     * @author David Peláez 
     */
    public function cambiarEstado(Request $request, Comentario $comentario): JsonResponse
    {
        try {
            $comentario->cambiarEstado();
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
        return response()->json($comentario);
    }
}
