<?php

namespace App\Actions\ResultadoElectoral;

use App\Enums\TipoDataEnum;
use App\Enums\EjeEnum;
use App\Models\CentroElectoral;
use Illuminate\Database\Query\JoinClause;
use DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetResultadosElectorales
{
	use AsAction;

	public function handle($filters)
    {   
         $query_sum_2015 = DB::Raw('SUM(CASE when data_centro_electorales.tipo='.TipoDataEnum::VOTOP_PSUV_AN_2015->value.' THEN data_centro_electorales.value_numeric ELSE 0 END) as votos_2015');

         $query_sum_2017 = DB::Raw('SUM(CASE when data_centro_electorales.tipo='.TipoDataEnum::VOTOP_PSUV_REG_2017->value.' THEN data_centro_electorales.value_numeric ELSE 0 END) as votos_2017');

         $query_sum_2018 = DB::Raw('SUM(CASE when data_centro_electorales.tipo='.TipoDataEnum::VOTOP_PSUV_PRES_2018->value.' THEN data_centro_electorales.value_numeric ELSE 0 END) as votos_2018');

         $query_sum_2021 = DB::Raw('SUM(CASE when data_centro_electorales.tipo='.TipoDataEnum::VOTOP_PSUV_REG_2021->value.' THEN data_centro_electorales.value_numeric ELSE 0 END) as votos_2021');

         $data = CentroElectoral::join('parroquias', 'parroquias.id', '=', 'centro_electorals.parroquia_id')
                ->join('municipios', 'municipios.id', '=', 'parroquias.municipio_id')
                ->join('data_centro_electorales', 'centro_electorals.id', '=', 'data_centro_electorales.centro_electoral_id')
                ->join('data_municipios', function (JoinClause $join) {
                    $join->on('data_municipios.municipio_id', '=', 'municipios.id')
                 ->where('data_municipios.tipo',TipoDataEnum::EJE->value);
                })
                ->filter($filters)
                ->select(
                    $query_sum_2015,$query_sum_2017,$query_sum_2018,$query_sum_2021
                    )
                ;

        return $data->get();
    }
}