<?php

namespace App\Actions\CentroElectoral;

use App\Enums\TipoDataEnum;
use App\Enums\EjeEnum;
use App\Models\CentroElectoral;
use DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetCentrosElectorales
{
	use AsAction;

	public function handle($order,$filters,$rows=10,$withPagination=1)
    {   

         $subquery_eje =DB::Raw('(SELECT data_municipios.value_enum FROM data_municipios WHERE data_municipios.tipo='.TipoDataEnum::EJE->value.' AND data_municipios.municipio_id=parroquias.municipio_id) as eje');  

         $subquery_ce = DB::Raw('municipios.nombre as municipio, parroquias.nombre as parroquia,SUM(CASE when data_centro_electorales.tipo='.TipoDataEnum::CANTIDAD_ELECTORES->value.' THEN data_centro_electorales.value_numeric ELSE 0 END) as sum_electores');

         $centro_electorales = CentroElectoral::join('parroquias', 'parroquias.id', '=', 'centro_electorals.parroquia_id')
                ->join('municipios', 'municipios.id', '=', 'parroquias.municipio_id')
                ->leftjoin('data_centro_electorales', 'centro_electorals.id', '=', 'data_centro_electorales.centro_electoral_id')
                ->filter($filters)
                ->sort($order)
                ->select('centro_electorals.id','centro_electorals.nombre','municipios.nombre as nombre_municipio',
                    $subquery_eje
                    )
                ->groupBy('centro_electorals.nombre','centro_electorals.id','municipios.nombre','parroquias.municipio_id',);
        
        $centro_electorales = $centro_electorales->paginate($rows)
            ->withQueryString()
            ->through(fn ($centro_electoral) => [
                'id' => $centro_electoral->id,
                'nombre' => $centro_electoral->nombre,
                'eje'=> EjeEnum::from($centro_electoral->eje)->name,
                'nombre_municipio' => $centro_electoral->nombre_municipio
               //  'sum_electores' =>number_format($parroquia->sum_electores,0,',','.'), //$municipio->sum_electores,
               // 'sum_comunidades' => intval($parroquia->sum_comunidades),
               // 'sum_calles' => number_format($parroquia->sum_calles,0,',','.'),
            ]);

        return $centro_electorales;
    }
}