<?php

namespace App\Actions\Command\Process\Comunidades;

use App\Enums\TipoDataEnum;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateCantidadParroquias
{
    use AsAction;

    public function handle()
    {  	
    	//esto se hace especialmente para actualizar la tabla de data de ubch
        $data = DB::table('parroquias')
        ->select('municipio_id')
        ->selectRaw('COUNT(parroquias.id) as cantidad_parroquias')
        ->groupBy('municipio_id')
        ->get()
        ->transform(fn ($centro_electoral) => [
    'municipio_id' => $centro_electoral->municipio_id,
    'value_numeric' => $centro_electoral->cantidad_parroquias,
    'tipo' => TipoDataEnum::CANTIDAD_PARROQUIAS->value
  ]);

        return $data;

    }
}