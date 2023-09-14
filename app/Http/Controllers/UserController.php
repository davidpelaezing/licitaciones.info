<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActualizarUserRequest;
use App\Http\Requests\CrearUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Lista todas los usuarios
     * @param Request $request
     * @return JsonResponse
     * @author David Peláez
     */
    public function listar(Request $request): JsonResponse
    {
        try {
            $data = $request->page ? User::paginate(10) : User::get();
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
        return response()->json($data);
    }

    /**
     * Almacena un User
     * @param Request $request
     * @return JsonResponse
     * @author David Peláez
     */
    public function crear(CrearUserRequest $request): JsonResponse
    {
        try {
            $user = User::create($request->validated());
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
        return response()->json($user, 201);
    }

    /**
     * Actualiza un User
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     * @author David Peláez
     */
    public function actualizar(ActualizarUserRequest $request, User $user): JsonResponse
    {
        try {
            $user->update($request->validated());
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
        return response()->json($user);
    }

    /**
     * muestra un User
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     * @author David Peláez
     */
    public function consultar(Request $request, User $user): JsonResponse
    {
        return response()->json($user);
    }

    /**
     * cambia el estado de un User
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     * @author David Peláez 
     */
    public function cambiarEstado(Request $request, User $user): JsonResponse
    {
        try {
            $user->cambiarEstado();
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
        return response()->json($user);
    }
}
