<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Database\Query\Builder;

class UpdateEstructuraPsuvRequest extends FormRequest
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
            $rules['centro_electoral'] = ['required','exists:centro_electorals,id',Rule::unique('estructura_psuvs','centro_electoral_id')->where(fn (Builder $query) => $query->where('cargo_id', $this->input('cargo'))->where('centro_electoral_id', $this->input('centro_electoral'))->where('persona_id','<>',$this->input('cedula')))];
        }

        if($cargo->nivel->name == 'COMUNIDAD' ){
            $rules['comunidad'] = ['required','exists:comunidads,id',Rule::unique('estructura_psuvs','comunidad_id')->where(fn (Builder $query) => $query->where('cargo_id', $this->input('cargo'))->where('comunidad_id', $this->input('comunidad'))->where('persona_id','<>',$this->input('cedula')))];
        }
        if($cargo->nivel->name == 'CALLE' ){
            $rules['calle'] = ['required','exists:calles,id',Rule::unique('estructura_psuvs','calle_id')->where(fn (Builder $query) => $query->where('cargo_id', $this->input('cargo'))->where('calle_id', $this->input('calle'))->where('persona_id','<>',$this->input('cedula')))];
        }

        return $rules;

        return $rules;
    }
}
