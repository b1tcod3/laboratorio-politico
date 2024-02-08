<?php

namespace App\Rules;

use Closure;
use App\Models\Persona;
use Illuminate\Contracts\Validation\ValidationRule;

class IsEstructuraPsuv implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $persona = Persona::find($value);
        $is_miembro = $persona->miembroPsuv()->exists();

        if($is_miembro){
        	$fail('La persona esta en la estructura del partido');
        }
    }
}
