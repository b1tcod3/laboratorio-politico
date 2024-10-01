<?php

namespace App\Actions\Command\Process\Electores;

use App\Enums\TipoDataEnum;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateCantidadElectoresMunicipios
{
    use AsAction;

    public function handle()
    {  	
    	//esto se hace especialmente para actualizar la tabla de data de ubch
        $data = DB::table('parroquias')
        ->join('centro_electorals','centro_electorals.parroquia_id','parroquias.id')
        ->join('data_centro_electorales','data_centro_electorales.centro_electoral_id','centro_electorals.id')
        ->select('parroquias.municipio_id')
        ->selectRaw('SUM(CASE when data_centro_electorales.tipo='.TipoDataEnum::CANTIDAD_ELECTORES->value.' THEN data_centro_electorales.value_numeric ELSE 0 END) as sum_electores
                    ')
        ->groupBy('parroquias.municipio_id')
        ->get()
        ->transform(fn ($centro_electoral) => [
    'municipio_id' => $centro_electoral->municipio_id,
    'value_numeric' => $centro_electoral->sum_electores,
    'tipo' => TipoDataEnum::CANTIDAD_ELECTORES->value
  ]);

        return $data;

    }
}