<?php

namespace App\Actions\Resumen;

use App\Enums\TipoDataEnum;
use App\Models\Municipio;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Lorisleiva\Actions\Concerns\AsAction;

class GetResumenGeneral
{
    use AsAction;

    public function handle($municipio=null,$parroquia=null,$centro_electoral=null)
    {  
        $resumen = Municipio::join('parroquias', 'municipios.id', '=', 'parroquias.municipio_id')
                ->join('centro_electorals', 'parroquias.id', '=', 'centro_electorals.parroquia_id')
                ->join('data_centro_electorales', 'centro_electorals.id', '=', 'data_centro_electorales.centro_electoral_id')
                ->select(DB::raw('COUNT(distinct municipios.id) as municipio_count,
                    COUNT(distinct parroquias.id) as parroquias_count,
                    count(distinct centro_electorals.id) as centros_electorales_count,
                    SUM(CASE when data_centro_electorales.tipo='.TipoDataEnum::CANTIDAD_ELECTORES->value.' THEN data_centro_electorales.value_numeric ELSE 0 END) as sum_electores,
                    SUM(CASE when data_centro_electorales.tipo='.TipoDataEnum::CANTIDAD_COMUNIDADES->value.' THEN data_centro_electorales.value_numeric ELSE 0 END) as sum_comunidades'),
                    )
                ->get()
                ->transform(fn ($resumen) => [
        'sum_electores' => number_format($resumen->sum_electores,0,',', '.'),
        'parroquias_count' => number_format($resumen->parroquias_count,0,',', '.'),
        'centros_electorales_count' => number_format($resumen->centros_electorales_count,0,',', '.'),
        'sum_comunidades' => number_format($resumen->sum_comunidades,0,',', '.')
    ])->first();

        return $resumen;
    }
}