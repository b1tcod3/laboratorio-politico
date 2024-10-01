<?php

namespace App\Actions\Command\Process\Comunidades;

use App\Enums\TipoDataEnum;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateCantidadComunidadesMunicipios
{
    use AsAction;

    public function handle()
    {  	
    	//esto se hace especialmente para actualizar la tabla de data de ubch
        $data = DB::table('parroquias')
        ->join('centro_electorals','centro_electorals.parroquia_id','parroquias.id')
        ->join('comunidads','comunidads.centro_electoral_id','centro_electorals.id')
        ->select('parroquias.municipio_id')
        ->selectRaw('COUNT(comunidads.id) as cantidad_comunidades')
        ->groupBy('parroquias.municipio_id')
        ->get()
        ->transform(fn ($centro_electoral) => [
    'municipio_id' => $centro_electoral->municipio_id,
    'value_numeric' => $centro_electoral->cantidad_comunidades,
    'tipo' => TipoDataEnum::CANTIDAD_COMUNIDADES->value
  ]);

        return $data;

    }
}