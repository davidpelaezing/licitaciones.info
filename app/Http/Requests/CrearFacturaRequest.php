<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearFacturaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nombre_completo' => 'required|string|max:255',
            'documento' => 'required|string|max:255',
            'tarjeta_credito' => 'required|string|max:255',
            'CVC' => 'required|string|max:255',
            'fecha_vencimiento_tarjeta' => 'required|date',
        ];
    }

    /**
     * Genera Exepcion en caso de haber errores de validacion, y envia una respuesta tipo JsonResponse
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
