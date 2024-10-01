<?php

namespace App\Actions\Command\Process\VotosCalle;

use App\Enums\TipoDataEnum;
use DB;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateCantidadVotosCalleMunicipios
{
    use AsAction;

    public function handle()
    {  	
    	//esto se hace especialmente para actualizar la tabla de data de votos calles
        $data = DB::table('parroquias')
        ->join('centro_electorals','centro_electorals.parroquia_id','parroquias.id')
        ->join('comunidads','comunidads.centro_electoral_id','centro_electorals.id')
        ->join('calles','comunidads.id','calles.comunidad_id')
        ->join('voto_calles','calles.id','voto_calles.calle_id')
        ->select('parroquias.municipio_id')
        ->selectRaw('COUNT(voto_calles.id) as cantidad_votos')
        ->groupBy('parroquias.municipio_id')
        ->get()
        ->transform(fn ($votos) => [
    'municipio_id' => $votos->municipio_id,
    'value_numeric' => $votos->cantidad_votos,
    'tipo' => TipoDataEnum::CANTIDAD_VOTOS_CALLE->value
  ]);

        return $data;
    }
}