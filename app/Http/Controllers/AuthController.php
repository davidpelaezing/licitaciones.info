<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginAuthRequest;
use App\Http\Requests\RegistrarAuthRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AuthController extends Controller
{
    /**
     * Registra un usuario
     * @param Request $request
     * @return JsonResponse
     * @author David Peláez
     */
    public function registrar(RegistrarAuthRequest $request): JsonResponse
    {
        try {
            $usuario = User::create([
                'nombre' => $request->nombre,
                'email' => $request->email,
                'password' => $request->password
            ]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }

        return response()->json([
            'data' => $usuario,
        ], 201);
    }

    /**
     * Inicia la sesion de un usuario
     * @param Request $request
     * @return JsonResponse
     * @author David Peláez
     */
    public function login(LoginAuthRequest $request): JsonResponse
    {
        try {
            // Buscamos el usuario
            $usuario = User::where('email', $request->email)->firstOrFail();
            $usuario->update([
                'actividad' => Carbon::now()
            ]);
            // Validamos que el usuario este activo
            if (!$usuario->estado) {
                return response()->json('Cuenta Ban', 401);
            }
            // validamos que las credenciales sean correctas
            if (!Auth::attempt($request->only('email', 'password'))) {
                return response()->json('Inautorizado', 401);
            }

            // Generamos un token de autenticacion
            $token = $usuario->createToken('auth_token')->plainTextToken;
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }

        return response()->json([
            'data' => $usuario,
            'access_token' => $token,
            'type_token' => 'Bearer',
            'csrf_token' => csrf_token()
        ]);
    }

    /**
     * cierra la sesion del usuario (Elimina todos sus tokens)
     * @param Request $request
     * @return JsonResponse
     * @author David Peláez
     */
    public function logout(Request $request): JsonResponse
    {
        Auth::user()->tokens()->delete();
        return response()->json(["msg" => "Se ha cerrado la sesión"]);
    }
}
