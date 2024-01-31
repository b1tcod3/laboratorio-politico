<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEstructuraPsuvRequest extends FormRequest
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

        $rules_extend = $this->extendRules();

        $rules = [
            'cedula' => ['required','exists:personas,id','unique:estructura_psuvs,persona_id'
            ],
            'telefono_movil' => ['nullable','numeric','digits:11'
            ],
            'telefono_movil_aux' => ['nullable','numeric','digits:11'
            ],
            'email' => ['nullable','email'],
            'cargo' => ['required','exists:cargos,id'],
        ];

        $rules = array_merge($rules,$rules_extend);

        return $rules;
    }

    private function extendRules(){

        //chequear cargo para determinar validation
        $cargo = \App\Models\Cargo::find($this->cargo);

        $rules = [];

        if($cargo->nivel->name == 'EPM' ){
            $rules['municipio'] = ['required','exists:municipios,id'];
        }
        if($cargo->nivel->name == 'EPP' ){
            $rules['parroquia'] = ['required','exists:parroquias,id'];
        }
        if($cargo->nivel->name == 'UBCH' ){
            $rules['centro_electoral'] = ['required','exists:centro_electorals,id',Rule::unique('estructura_psuvs','centro_electoral_id')->where('cargo_id', $this->input('cargo'))->ignore('persona_id',$this->cedula),];
        }

        if($cargo->nivel->name == 'COMUNIDAD' ){
            $rules['comunidad'] = ['required','exists:comunidads,id',Rule::unique('estructura_psuvs','comunidad_id')->where('cargo_id', $this->input('cargo'))->ignore($this->cedula,'persona_id')];
        }

        if($cargo->nivel->name == 'CALLE' ){
            $rules['calle'] = ['required','exists:calles,id',Rule::unique('estructura_psuvs','calle_id')->where('cargo_id', $this->input('cargo'))->ignore($this->cedula,'persona_id')];
        }

        return $rules;
    }
}
