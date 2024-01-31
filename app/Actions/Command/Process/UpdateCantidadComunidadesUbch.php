<?php

namespace App\Actions\Command\Process;

use App\Enums\TipoDataEnum;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateCantidadComunidadesUbch
{
    use AsAction;

    public function handle()
    {  	
    	//esto se hace especialmente para actualizar la tabla de data de ubch
        $data = DB::table('comunidads')
        ->select('centro_electoral_id')
        ->selectRaw('COUNT(comunidads.id) as cantidad_comunidades')
        ->groupBy('centro_electoral_id')
        ->get()
        ->transform(fn ($centro_electoral) => [
    'centro_electoral_id' => $centro_electoral->centro_electoral_id,
    'value_numeric' => $centro_electoral->cantidad_comunidades,
    'tipo' => TipoDataEnum::CANTIDAD_COMUNIDADES->value
  ]);

        return $data;

    }
}