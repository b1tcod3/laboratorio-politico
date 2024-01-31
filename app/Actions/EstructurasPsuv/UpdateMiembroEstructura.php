<?php

namespace App\Actions\EstructurasPsuv;

use App\Models\EstructuraPsuv;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateMiembroEstructura
{
    use AsAction;

    public function handle(EstructuraPsuv $miembro, $data)
    {  
        $miembro->persona->contacto()->updateOrCreate([
        	"telefono_movil" => $data["telefono_movil"],
  			"telefono_movil_aux" =>$data["telefono_movil_aux"],
  			"email" => $data["email"]
        ]);

        $data['municipio'] = isset($data['parroquia'])&&$data['parroquia']?null:$data['municipio']??null;

        $data_estructura = [
         'cargo_id' => $data['cargo'],
         'municipio_id' => $data['municipio']??null,
         'parroquia_id' => $data['parroquia']??null,
         'centro_electoral_id' => $data['centro_electoral']??null,
         'comunidad_id' => $data['comunidad']??null,
         'calle_id' => $data['calle']??null,
         ];

      
        $miembro->update($data_estructura);

        return $miembro;
    }
}