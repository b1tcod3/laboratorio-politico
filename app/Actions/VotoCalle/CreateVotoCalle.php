<?php

namespace App\Actions\VotoCalle;

use App\Models\VotoCalle;
use App\Models\Persona;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateVotoCalle
{
    use AsAction;

    public function handle($data)
    {  
        $persona = Persona::findOrFail($data['cedula']);

        $persona->contacto()->updateOrCreate(['persona_id'=>$persona->id],[
        	"telefono_movil" => $data["telefono_movil"],
  			"telefono_movil_aux" =>$data["telefono_movil_aux"],
  			"email" => $data["email"]
        ]);
        

        $voto = VotoCalle::create([
   			 'persona_id' => $persona->id,
         'jefe_familia_id' => $data['cedula_jefe_familia']??null,
         'tipo' => $data['tipo_voto']??null,
         'hora_votacion' => $data['hora_voto']??null,
         'calle_id' => $data['calle'],
         'es_jefe_familia' => $data['es_jefe_familia'],
		]);

        return $voto;
    }
}