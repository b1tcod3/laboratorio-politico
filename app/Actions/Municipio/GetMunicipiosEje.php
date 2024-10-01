<?php

namespace App\Actions\Municipio;

use App\Enums\TipoDataEnum;
use App\Enums\EjeEnum;
use App\Models\Municipio;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Lorisleiva\Actions\Concerns\AsAction;

class GetMunicipiosEje
{
    use AsAction;

    public function handle()
    {  
        $municipios = Municipio::join('data_municipios', 'municipios.id', '=', 'data_municipios.municipio_id'
        )
        ->select('municipios.id','data_municipios.municipio_id','municipios.nombre','data_municipios.value_enum')
        ->groupBy('municipios.id','data_municipios.municipio_id','municipios.nombre','data_municipios.value_enum')
        ->where('data_municipios.tipo',TipoDataEnum::EJE->value)
        ->get()->transform(fn ($municipio) => [
                'id' => $municipio->id,
                'nombre' => $municipio->nombre,
                'eje'=> EjeEnum::from($municipio->value_enum)->name,
                'eje_id'=> $municipio->value_enum
            ]);


       return $municipios;
   }
}