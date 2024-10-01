<?php

namespace App\Actions\Command\Process\CentrosElectorales;

use App\Enums\TipoDataEnum;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateCantidadCentrosElectoralesMunicipios
{
    use AsAction;

    public function handle()
    {  	
    	//esto se hace especialmente para actualizar la tabla de data de ubch
        $data = DB::table('parroquias')
        ->join('centro_electorals','centro_electorals.parroquia_id','parroquias.id')
        ->select('parroquias.municipio_id')
        ->selectRaw('COUNT(centro_electorals.id) as cantidad_centros_electorales')
        ->groupBy('parroquias.municipio_id')
        ->get()
        ->transform(fn ($centro_electoral) => [
            'municipio_id' => $centro_electoral->municipio_id,
            'value_numeric' => $centro_electoral->cantidad_centros_electorales,
            'tipo' => TipoDataEnum::CANTIDAD_CENTROS_ELECTORALES->value
        ]);

        return $data;

    }
}