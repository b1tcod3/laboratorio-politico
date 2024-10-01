<?php

namespace App\Actions\CentroElectoral;

use App\Enums\TipoDataEnum;
use App\Models\CentroElectoral;
use DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetCentrosElectoralesCollection
{
	use AsAction;

	public function handle($order,$filters,$rows=10,$withPagination=1)
    {       
        $sub_query = DB::Raw('municipios.nombre as municipio, parroquias.nombre as parroquia,SUM(CASE when data_centro_electorales.tipo='.TipoDataEnum::CANTIDAD_ELECTORES->value.' THEN data_centro_electorales.value_numeric ELSE 0 END) as sum_electores');

         $centro_electorales = CentroElectoral::join('parroquias', 'parroquias.id', '=', 'centro_electorals.parroquia_id')
                ->join('municipios', 'municipios.id', '=', 'parroquias.municipio_id')
                ->leftjoin('data_centro_electorales', 'centro_electorals.id', '=', 'data_centro_electorales.centro_electoral_id')
                ->filter($filters)
                ->sort($order)
                ->select('centro_electorals.id','centro_electorals.nombre')
                ->groupBy('centro_electorals.nombre','centro_electorals.id','municipios.nombre','parroquias.nombre');
        
        
        return $centro_electorales->get();
        
    }
}