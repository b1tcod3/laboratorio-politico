<?php

namespace App\Actions\VotoCalle;

use App\Models\VotoCalle;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateVotoCalle
{
    use AsAction;

    public function handle(VotoCalle $voto,$data)
    {  
        $voto->persona->contacto()->updateOrCreate([
            "telefono_movil" => $data["telefono_movil"],
            "telefono_movil_aux" =>$data["telefono_movil_aux"],
            "email" => $data["email"]
        ]);
        
        $data_voto = [
         'jefe_familia_id' => $data['cedula_jefe_familia']??null,
         'tipo' => $data['tipo_voto']??null,
         'hora_votacion' => $data['hora_voto']??null,
         'calle_id' => $data['calle'],
         'es_jefe_familia' => $data['es_jefe_familia'],
		];

        $voto->update($data_voto);

        return $voto;
    }
}