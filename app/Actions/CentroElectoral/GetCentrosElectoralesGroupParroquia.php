<?php

namespace App\Actions\CentroElectoral;

use App\Models\CentroElectoral;
use Lorisleiva\Actions\Concerns\AsAction;

class GetCentrosElectoralesGroupParroquia
{
	use AsAction;

	public function handle()
    { 
         $centros_electorales = CentroElectoral::join('parroquias', 'parroquias.id', '=', 'centro_electorals.parroquia_id')->select('parroquias.id as parroquia_id','centro_electorals.id')
            ->selectRaw('centro_electorals.nombre as centro_electoral_nombre')->
            get()->groupBy('parroquia_id');

          return $centros_electorales;
    }
}