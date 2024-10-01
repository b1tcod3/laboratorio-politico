<?php

namespace App\Actions\Parroquia;

use App\Enums\TipoDataEnum;
use App\Enums\EjeEnum;
use App\Models\Parroquia;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Lorisleiva\Actions\Concerns\AsAction;

class GetParroquiasEje
{
    use AsAction;

    public function handle()
    {  
        $parroquias = Parroquia::join('municipios', 'municipios.id', '=', 'parroquias.municipio_id')
            ->join('data_municipios', 'municipios.id', '=', 'data_municipios.municipio_id')
            ->select('municipios.id as municipio_id','parroquias.id','parroquias.nombre','data_municipios.value_enum')
            ->where('data_municipios.tipo',TipoDataEnum::EJE->value)
            ->orderBy('parroquias.nombre')
            ->get()->transform(fn ($parroquia) => [
                'id' => $parroquia->id,
                'nombre' => $parroquia->nombre,
                'municipio_id'=> $parroquia->municipio_id,
                'eje'=> EjeEnum::from($parroquia->value_enum)->name,
                'eje_id'=> $parroquia->value_enum
            ]);


       return $parroquias;
   }
}