<?php

namespace App\Actions\CentroElectoral;

use App\Enums\TipoDataEnum;
use App\Enums\EjeEnum;
use App\Models\CentroElectoral;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Lorisleiva\Actions\Concerns\AsAction;

class GetCentrosElectoralesEje
{
    use AsAction;

    public function handle()
    {  
        $centros_electorales = CentroElectoral::join('parroquias', 'parroquias.id', '=', 'centro_electorals.parroquia_id')
        ->join('municipios', 'municipios.id', '=', 'parroquias.municipio_id')
            ->join('data_municipios', 'municipios.id', '=', 'data_municipios.municipio_id')
            ->select('municipios.id as municipio_id','centro_electorals.id','centro_electorals.parroquia_id','centro_electorals.nombre','data_municipios.value_enum')
            ->where('data_municipios.tipo',TipoDataEnum::EJE->value)
            ->orderBy('parroquias.nombre')
            ->get()->transform(fn ($centro_electoral) => [
                'id' => $centro_electoral->id,
                'nombre' => $centro_electoral->nombre,
                'parroquia_id' => $centro_electoral->parroquia_id,
                'municipio_id'=> $centro_electoral->municipio_id,
                'eje'=> EjeEnum::from($centro_electoral->value_enum)->name,
                'eje_id'=> $centro_electoral->value_enum
            ]);


       return $centros_electorales;
   }
}