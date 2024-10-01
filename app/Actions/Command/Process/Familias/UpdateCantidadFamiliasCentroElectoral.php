<?php

namespace App\Actions\Command\Process\Familias;

use App\Enums\TipoDataEnum;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateCantidadFamiliasCentroElectoral
{
    use AsAction;

    public function handle()
    {  	
    	$data = DB::table('comunidads')
        ->join('data_comunidads','data_comunidads.comunidad_id','comunidads.id')
        ->select('comunidads.centro_electoral_id')
        ->selectRaw('SUM(CASE when data_comunidads.tipo='.TipoDataEnum::CANTIDAD_FAMILIAS->value.' THEN data_comunidads.value_numeric ELSE 0 END) as sum_familias
                    ')
        ->groupBy('comunidads.centro_electoral_id')
        ->get()
        ->transform(fn ($comunidad) => [
    'centro_electoral_id' => $comunidad->centro_electoral_id,
    'value_numeric' => $comunidad->sum_familias,
    'tipo' => TipoDataEnum::CANTIDAD_FAMILIAS->value
  ]);

        return $data;
    }
}