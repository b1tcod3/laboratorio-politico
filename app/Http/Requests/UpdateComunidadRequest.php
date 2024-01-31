<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateComunidadRequest extends FormRequest
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
            'nombre' => ['required',Rule::unique('comunidads')->where('centro_electoral_id', $this->input('centro_electoral'))->ignore($this->comunidade)],
            'centro_electoral' => ['required','exists:centro_electorals,id']
        ];
    }
}
