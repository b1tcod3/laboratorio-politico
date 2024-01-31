<?php

namespace App\Actions\Calle;

use App\Enums\TipoDataEnum;
use App\Models\Calle;
use DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetCalles
{
	use AsAction;

	public function handle($order,$filters,$rows=10,$withPagination=1)
    { 
         $calles = Calle::join('comunidads', 'comunidads.id', '=', 'calles.comunidad_id')
                ->join('centro_electorals', 'centro_electorals.id', '=', 'comunidads.centro_electoral_id')
                ->join('parroquias', 'parroquias.id', '=', 'centro_electorals.parroquia_id')
                ->join('municipios', 'municipios.id', '=', 'parroquias.municipio_id')
                ->leftjoin('data_calles', 'calles.id', '=', 'data_calles.calle_id')
                ->filter($filters)
                ->sort($order)
                ->select('calles.id', 'calles.nombre as calle_nombre','comunidads.id as comunidad_id', 'comunidads.nombre as comunidad_nombre','centro_electorals.nombre as centro_electoral_nombre','centro_electorals.id as centro_electoral_id','municipios.eje','municipios.nombre as municipio_nombre','municipios.id as municipio_id','parroquias.id as parroquia_id',
                    'parroquias.nombre as parroquia_nombre',
                    DB::Raw('SUM(CASE when data_calles.tipo='.TipoDataEnum::CANTIDAD_MIEMBROS_CALLE->value.' THEN data_calles.value_numeric ELSE 0 END) as sum_miembros_calles
                    ')
                )
                ->groupBy('calles.nombre','calles.id','centro_electorals.nombre','comunidads.id','comunidads.nombre','centro_electorals.nombre','centro_electorals.id','parroquias.id','municipios.eje','municipios.nombre','municipios.id','parroquias.nombre');
        
        if($withPagination){
            $calles = $calles->paginate($rows)
            ->withQueryString();
        }
        else{
             $calles = $calles->get();
        }
        return $calles;
    }
}