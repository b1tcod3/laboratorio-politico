<?php

namespace App\Actions\Command\Process;

use App\Enums\TipoDataEnum;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateCantidadMiembrosPsuvComunidad
{
    use AsAction;

    public function handle()
    {  	
    	//esto se hace especialmente para actualizar la tabla de data de ubch
        $data = DB::table('estructura_psuvs')
        ->select('comunidad_id')
        ->selectRaw('COUNT(estructura_psuvs.id) as cantidad_miembros_comunidad')
        ->groupBy('comunidad_id')
        ->where('comunidad_id','<>',NULL)
        ->get()
        ->transform(fn ($comunidad) => [
    'comunidad_id' => $comunidad->comunidad_id,
    'value_numeric' => $comunidad->cantidad_miembros_comunidad??0,
    'tipo' => TipoDataEnum::CANTIDAD_MIEMBROS_COMUNIDAD->value
  ]);

        return $data;

    }
}