<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateVotoCalleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'calle'=> ['required','exists:calles,id'],
            'telefono_movil' => ['nullable','numeric','digits:11'
            ],
            'telefono_movil_aux' => ['nullable','numeric','digits:11'
            ],
            'email' => ['nullable','email'],
            'es_jefe_familia' => ['required','boolean'],
            'email' => ['nullable','email'],
            'cedula_jefe_familia' => ['nullable',Rule::exists('voto_calles','persona_id')->where(function (Builder $query) {
            return $query->where('es_jefe_familia', 1);
        }),],
            'tipo_voto' => ['nullable','numeric'],
        ];
    }
}
