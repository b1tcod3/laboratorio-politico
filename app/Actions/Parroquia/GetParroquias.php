<?php

namespace App\Actions\Parroquia;

use App\Enums\TipoDataEnum;
use App\Models\Parroquia;
use App\Enums\EjeEnum;
use DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetParroquias
{
	use AsAction;

	public function handle($order,$filters,$rows=10)
    {    
        $subquery_eje =DB::Raw('(SELECT data_municipios.value_enum FROM data_municipios WHERE data_municipios.tipo='.TipoDataEnum::EJE->value.' AND data_municipios.municipio_id=parroquias.municipio_id) as eje');
        
        $subquery_cant_ce = DB::Raw('SUM(CASE when data_parroquias.tipo='.TipoDataEnum::CANTIDAD_CENTROS_ELECTORALES->value.' THEN data_parroquias.value_numeric ELSE 0 END) as centros_electorales_count');


         $parroquias = Parroquia::join('municipios', 'parroquias.municipio_id', '=', 'municipios.id')
          ->join('data_parroquias', 'parroquias.id', '=', 'data_parroquias.parroquia_id')
        ->select(
          $subquery_eje, $subquery_cant_ce,
          // DB::Raw('SUM(CASE when data_parroquias.tipo='.TipoDataEnum::CANTIDAD_COMUNIDADES->value.' THEN data_parroquias.value_numeric ELSE 0 END) as sum_comunidades'),
          // DB::Raw('SUM(CASE when data_parroquias.tipo='.TipoDataEnum::CANTIDAD_CALLES->value.' THEN data_parroquias.value_numeric ELSE 0 END) as sum_calles'),
          // DB::Raw('SUM(CASE when data_parroquias.tipo='.TipoDataEnum::CANTIDAD_ELECTORES->value.' THEN data_parroquias.value_numeric ELSE 0 END) as sum_electores'),
          'parroquias.id','parroquias.nombre','municipios.nombre as nombre_municipio')
        ->groupBy('parroquias.id','parroquias.nombre','parroquias.municipio_id','nombre_municipio')
        ->filter($filters)
        ->sort($order)
        ;

            $parroquias = $parroquias->paginate($rows)
            ->withQueryString()
            ->through(fn ($parroquia) => [
                'id' => $parroquia->id,
                'nombre' => $parroquia->nombre,
                'eje'=> EjeEnum::from($parroquia->eje)->name,
                'nombre_municipio' => $parroquia->nombre_municipio,
                'centros_electorales_count' => intval($parroquia->centros_electorales_count),
               //  'sum_electores' =>number_format($parroquia->sum_electores,0,',','.'), //$municipio->sum_electores,
               // 'sum_comunidades' => intval($parroquia->sum_comunidades),
               // 'sum_calles' => number_format($parroquia->sum_calles,0,',','.'),
            ]);
       return $parroquias;   
         
    }
}