<?php

namespace App\Actions\EstructurasPsuv;

use App\Models\EstructuraPsuv;
use App\Models\Persona;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateMiembroEstructura
{
    use AsAction;

    public function handle($data)
    {  
        $persona = Persona::findOrFail($data['cedula']);

        $persona->contacto()->updateOrCreate([
        	"telefono_movil" => $data["telefono_movil"],
  			"telefono_movil_aux" =>$data["telefono_movil_aux"],
  			"email" => $data["email"]
        ]);
        

        $miembro = EstructuraPsuv::create([
   			 'persona_id' => $persona->id,
   			 'cargo_id' => $data['cargo'],
         'municipio_id' => $data['municipio']??null,
         'parroquia_id' => $data['parroquia']??null,
         'centro_electoral_id' => $data['centro_electoral']??null,
         'comunidad_id' => $data['comunidad']??null,
         'calle_id' => $data['calle']??null,
		]);

        return $miembro;
    }
}