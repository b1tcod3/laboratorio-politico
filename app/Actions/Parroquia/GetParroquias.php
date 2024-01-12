<?php

namespace App\Actions\Parroquia;

use App\Enums\TipoDataEnum;
use App\Models\Parroquia;
use DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetParroquias
{
	use AsAction;

	public function handle($order,$filters,$rows=10,$withPagination=TRUE)
    { 
         $parroquias = Parroquia::join('municipios', 'municipios.id', '=', 'parroquias.municipio_id')
                ->join('centro_electorals', 'parroquias.id', '=', 'centro_electorals.parroquia_id')
                ->join('data_centro_electorales', 'centro_electorals.id', '=', 'data_centro_electorales.centro_electoral_id')
                ->filter($filters)
                ->sort($order)
                ->select(DB::Raw('parroquias.id, municipios.eje,municipios.nombre as municipio,parroquias.nombre,
                    count(distinct centro_electorals.id) as centros_electorales_count,
                    SUM(CASE when data_centro_electorales.tipo='.TipoDataEnum::CANTIDAD_ELECTORES->value.' THEN data_centro_electorales.value_numeric ELSE 0 END) as sum_electores
                    '))
                ->groupBy('parroquias.id','parroquias.nombre','municipios.eje','municipios.circuito','municipios.nombre');
        
        if($withPagination){
            $parroquias = $parroquias->paginate($rows)
            ->withQueryString();
        }
        else{
             $parroquias = $parroquias->get();
        }

        return $parroquias;
    }
}