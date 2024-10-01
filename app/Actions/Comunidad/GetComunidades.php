<?php

namespace App\Actions\Comunidad;

use App\Enums\TipoDataEnum;
use App\Models\Comunidad;
use DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetComunidades
{
	use AsAction;

	public function handle($order,$filters,$rows=10,$withPagination=1)
    { 
         $comunidades = Comunidad::join('centro_electorals', 'centro_electorals.id', '=', 'comunidads.centro_electoral_id')
                ->join('parroquias', 'parroquias.id', '=', 'centro_electorals.parroquia_id')
                ->join('municipios', 'municipios.id', '=', 'parroquias.municipio_id')
                ->leftjoin('data_comunidads', 'comunidads.id', '=', 'data_comunidads.comunidad_id')
                ->filter($filters)
                ->sort($order)
                ->select('comunidads.id', 'comunidads.nombre as comunidad_nombre','centro_electorals.nombre as centro_electoral_nombre','centro_electorals.id as centro_electoral_id','municipios.eje','municipios.nombre as municipio_nombre','municipios.id as municipio_id','parroquias.id as parroquia_id',
                    'parroquias.nombre as parroquia_nombre',
                    DB::Raw('SUM(CASE when data_comunidads.tipo='.TipoDataEnum::CANTIDAD_MIEMBROS_COMUNIDAD->value.' THEN data_comunidads.value_numeric ELSE 0 END) as sum_miembros_comunidad
                    ')
                )
                ->groupBy('centro_electorals.nombre','comunidads.id','comunidads.nombre','centro_electorals.nombre','centro_electorals.id','parroquias.id','municipios.eje','municipios.nombre','municipios.id','parroquias.nombre');
        
        if($withPagination){
            $comunidades = $comunidades->paginate($rows)
            ->withQueryString();
        }
        else{
             $comunidades = $comunidades->get();
        }
        return $comunidades;
    }
}