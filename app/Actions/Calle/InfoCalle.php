<?php

namespace App\Actions\Calle;

use App\Models\Calle;
use DB;
use Lorisleiva\Actions\Concerns\AsAction;

class InfoCalle
{
	use AsAction;

	public function handle($id)
    { 
        $calle = Calle::find($id);

        if(!$calle){
            return null;
        }
        $jefe_calle = $calle->jefe_calle()?$calle->jefe_calle->nombres." ".$calle->jefe_calle->apellidos:null;
        $telefono = $calle->jefe_calle()?$calle->jefe_calle->contacto->telefono_movil:null;

        $electores_internos = DB::table('electores')->join('voto_calles', 'electores.persona_id', '=', 'voto_calles.persona_id')->selectRaw('COUNT(electores.persona_id) as count_electores')
            ->where('electores.centro_electoral_id',$calle->comunidad->centro_electoral->id)
            ->first();

        return [
            'jefe_calle'=> $jefe_calle,
            'telefono'=> $telefono,
            'count_votos_externos'=> $calle->votos()->count()-$electores_internos->count_electores,
            'count_votos_internos'=> $electores_internos->count_electores,
            'total_votos'=> $calle->votos()->count()
        ];
    }
}