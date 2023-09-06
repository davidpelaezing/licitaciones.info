<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait HelperTrait
{

    /**
     * Asigna el campo user_id a un array, en caso de no enviar id se asigna el del usuario autenticado
     * @param array $data
     * @param int $user_id <optional>
     * @return array
     * @author David Peláez
     */
    public function agregarCampoUserId($data, $user_id = null): array
    {
        $data['user_id'] = $user_id ?? Auth::id();
        return $data;
    }
}
