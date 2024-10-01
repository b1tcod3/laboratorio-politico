<?php

namespace App\Actions\Parroquia;

use App\Models\Parroquia;
use DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetParroquiasGroupMunicipio
{
	use AsAction;

	public function handle()
    {   
         $parroquias = Parroquia::join('municipios', 'municipios.id', '=', 'parroquias.municipio_id')->select('municipios.id as municipio_id','parroquias.id')
            ->selectRaw('parroquias.nombre as parroquia_nombre')->
            get()->groupBy('municipio_id');

       return $parroquias;   
         
    }
}