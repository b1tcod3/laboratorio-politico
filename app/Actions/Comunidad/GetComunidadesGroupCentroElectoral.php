<?php

namespace App\Actions\Comunidad;

use App\Models\Comunidad;
use Lorisleiva\Actions\Concerns\AsAction;

class GetComunidadesGroupCentroElectoral
{   
/***informacion de comunidades para formularios agrupados por centro electoral
    ***/
	use AsAction;

	public function handle()
    { 
         $comunidades = Comunidad::join('centro_electorals', 'centro_electorals.id', '=', 'comunidads.centro_electoral_id')->select('centro_electorals.id as centro_electoral_id','comunidads.id')
            ->selectRaw('comunidads.nombre as comunidad_nombre')->
            get()->groupBy('centro_electoral_id');

          return $comunidades  ;

    }
}