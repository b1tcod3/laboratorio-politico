<?php
namespace App\Http\Requests\Cargo;

use App\Enums\NivelCargoEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCargoRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre'          => ['required', 'min:3'],
            'area'            => ['nullable'],
            'redirect'        => ['required'],
            'organizacion_id' => ['required', 'exists:organizaciones,id'],
            'nivel'           => ['required', Rule::In(NivelCargoEnum::values())],
        ];
    }
}
