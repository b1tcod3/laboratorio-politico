<?php

namespace App\Actions\Command\Process\Calles;

use App\Enums\TipoDataEnum;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateCantidadCallesMunicipios
{
    use AsAction;

    public function handle()
    {  	
    	//esto se hace especialmente para actualizar la tabla de data de ubch
        $data = DB::table('parroquias')
        ->join('centro_electorals','centro_electorals.parroquia_id','parroquias.id')
        ->join('comunidads','comunidads.centro_electoral_id','centro_electorals.id')
        ->join('calles','comunidads.id','calles.comunidad_id')
        ->select('parroquias.municipio_id')
        ->selectRaw('COUNT(calles.id) as cantidad_calles')
        ->groupBy('parroquias.municipio_id')
        ->get()
        ->transform(fn ($centro_electoral) => [
    'municipio_id' => $centro_electoral->municipio_id,
    'value_numeric' => $centro_electoral->cantidad_calles,
    'tipo' => TipoDataEnum::CANTIDAD_CALLES->value
  ]);

        return $data;

    }
}