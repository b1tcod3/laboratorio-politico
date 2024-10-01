<?php

namespace App\Actions\Calle;

use App\Models\Calle;
use Lorisleiva\Actions\Concerns\AsAction;

class GetCallesGroupComunidad
{
	use AsAction;

	public function handle()
    { 
         $calles = Calle::join('comunidads', 'comunidads.id', '=', 'calles.comunidad_id')->select('comunidads.id as comunidad_id','calles.id')
            ->selectRaw('calles.nombre as calle_nombre')->
            get()->groupBy('comunidad_id');

          return $calles;
    }
}