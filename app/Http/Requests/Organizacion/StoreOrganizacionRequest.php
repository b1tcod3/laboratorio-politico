<?php

namespace App\Http\Requests\Organizacion;

use App\Enums\TipoOrganizacionEnum;
use ErlandMuchasaj\LaravelFileUploader\FileUploader; 
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Rule;


class StoreOrganizacionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('is_admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {   

        $extensions = implode(',', FileUploader::images());

        return [
            'nombre' => ['required','min:5','unique:organizaciones'],
            'acronimo' => ['required','min:2'],
            'logo' => ['required',File::image()->max( 2 * 1000),
             'mimes:' . $extensions,
            ],
            'tipo' => ['required',Rule::In(TipoOrganizacionEnum::values())]
            ];
    }
}
