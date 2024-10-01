<?php

namespace App\Actions\Resumen;

use App\Enums\TipoDataEnum;
use App\Models\Municipio;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Lorisleiva\Actions\Concerns\AsAction;

class GetResumenGeneralMunicipio
{
    use AsAction;

    public function handle($municipio=null)
    {  
        $resumen = Municipio::join('data_municipios', 'municipios.id', '=', 'data_municipios.municipio_id')
           ->when($municipio, function ($query, $municipio) {
            $query->where('municipios.id',$municipio);
            })
                ->select(DB::raw('SUM(CASE when data_municipios.tipo='.TipoDataEnum::CANTIDAD_CENTROS_ELECTORALES->value.' THEN data_municipios.value_numeric ELSE 0 END) as sum_centros_electorales, SUM(CASE when data_municipios.tipo='.TipoDataEnum::CANTIDAD_ELECTORES->value.' THEN data_municipios.value_numeric ELSE 0 END) as sum_electores,
                    SUM(CASE when data_municipios.tipo='.TipoDataEnum::CANTIDAD_COMUNIDADES->value.' THEN data_municipios.value_numeric ELSE 0 END) as sum_comunidades,
                    SUM(CASE when data_municipios.tipo='.TipoDataEnum::CANTIDAD_CALLES->value.' THEN data_municipios.value_numeric ELSE 0 END) as sum_calles,
                    SUM(CASE when data_municipios.tipo='.TipoDataEnum::CANTIDAD_VOTOS_CALLE->value.' THEN data_municipios.value_numeric ELSE 0 END) as sum_votos_calle
                    '

                ),

                    )
                ->get()
                ->transform(fn ($resumen) => [
        'sum_electores' => number_format($resumen->sum_electores,0,',', '.'),
        'parroquias_count' => number_format($resumen->parroquias_count,0,',', '.'),
        'centros_electorales_count' => number_format($resumen->sum_centros_electorales,0,',', '.'),
        'sum_comunidades' => number_format($resumen->sum_comunidades,0,',', '.'),
        'sum_calles' => number_format($resumen->sum_calles,0,',', '.'),
        'sum_votos_calle' => number_format($resumen->sum_votos_calle,0,',', '.')
    ])->first();

        return $resumen;
    }
}