<?php

namespace App\Actions\Municipio;

use App\Enums\TipoDataEnum;
use App\Enums\EjeEnum;
use App\Models\Municipio;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Lorisleiva\Actions\Concerns\AsAction;

class GetMunicipios
{
    use AsAction;

    public function handle($order,$filters,$rows=10)
    {  
        $subquery_eje =DB::Raw('(SELECT data_municipios_eje.value_enum FROM data_municipios as data_municipios_eje WHERE data_municipios_eje.tipo='.TipoDataEnum::EJE->value.' AND data_municipios_eje.municipio_id=municipios.id) as eje');
        
        $subquery_cant_ce = DB::Raw('SUM(CASE when data_municipios.tipo='.TipoDataEnum::CANTIDAD_CENTROS_ELECTORALES->value.' THEN data_municipios.value_numeric ELSE 0 END) as centros_electorales_count');


        $municipios = Municipio::join('data_municipios', 'municipios.id', '=', 'data_municipios.municipio_id'
        )->select(DB::Raw('SUM(CASE when data_municipios.tipo='.TipoDataEnum::CANTIDAD_PARROQUIAS->value.' THEN data_municipios.value_numeric ELSE 0 END) as parroquias_count'),'municipios.id','municipios.nombre',
        $subquery_eje, $subquery_cant_ce
        )
        //   ,
        //   DB::Raw('SUM(CASE when data_municipios.tipo='.TipoDataEnum::CANTIDAD_COMUNIDADES->value.' THEN data_municipios.value_numeric ELSE 0 END) as sum_comunidades'),
        //   DB::Raw('SUM(CASE when data_municipios.tipo='.TipoDataEnum::CANTIDAD_CALLES->value.' THEN data_municipios.value_numeric ELSE 0 END) as sum_calles'),
        //   DB::Raw('SUM(CASE when data_municipios.tipo='.TipoDataEnum::CANTIDAD_ELECTORES->value.' THEN data_municipios.value_numeric ELSE 0 END) as sum_electores'),
        ->groupBy('municipios.id','data_municipios.municipio_id','municipios.nombre')
        ->filter($filters)
        ->sort($order)
        ;
            $municipios = $municipios->paginate($rows)
            ->withQueryString()
            ->through(fn ($municipio) => [
                'id' => $municipio->id,
                'nombre' => $municipio->nombre,
                'parroquias_count'=> intval($municipio->parroquias_count),
                'eje'=> EjeEnum::from($municipio->eje)->name,
                'centros_electorales_count' => intval($municipio->centros_electorales_count)
               //  'circuito' => $municipio->circuito,
               //  'eje' => $municipio->eje,
               //  'centros_electorales_count' => intval($municipio->centros_electorales_count),
               //  'parroquias_count' => intval($municipio->parroquias_count),
               //  'centros_electorales_count' => intval($municipio->centros_electorales_count),
               //  'sum_electores' =>number_format($municipio->sum_electores,0,',','.'), //$municipio->sum_electores,
               // 'sum_comunidades' => intval($municipio->sum_comunidades),
               // 'sum_calles' => number_format($municipio->sum_calles,0,',','.'),
            ]);


       return $municipios;
   }
}