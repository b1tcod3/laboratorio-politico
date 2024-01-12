<?php

namespace App\Actions\Municipio;

use App\Enums\TipoDataEnum;
use App\Models\Municipio;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Lorisleiva\Actions\Concerns\AsAction;

class GetMunicipios
{
    use AsAction;

    public function handle($order,$filters,$rows=10,$withPagination=1)
    {  
        $municipios = Municipio::join('parroquias', 'municipios.id', '=', 'parroquias.municipio_id')
        ->join('centro_electorals', 'parroquias.id', '=', 'centro_electorals.parroquia_id')
        ->join('data_centro_electorales', 'centro_electorals.id', '=', 'data_centro_electorales.centro_electoral_id')
        ->select(DB::raw('municipios.id,municipios.eje,municipios.circuito,municipios.nombre,
            COUNT(distinct parroquias.id) as parroquias_count,
            count(distinct centro_electorals.id) as centros_electorales_count,
            SUM(CASE when data_centro_electorales.tipo='.TipoDataEnum::CANTIDAD_ELECTORES->value.' THEN data_centro_electorales.value_numeric ELSE 0 END) as sum_electores'),
    )
        ->groupBy('municipios.id','municipios.nombre','municipios.eje','municipios.circuito')
        ->filter($filters)
        ->sort($order)
        ;

        if($withPagination){
            $municipios = $municipios->paginate($rows)
            ->withQueryString()
            ->through(fn ($municipio) => [
                'id' => $municipio->id,
                'nombre' => $municipio->nombre,
                'circuito' => $municipio->circuito,
                'eje' => $municipio->eje,
                'parroquias_count' => $municipio->parroquias_count,
                'centros_electorales_count' => $municipio->centros_electorales_count,
                'sum_electores' => number_format($municipio->sum_electores,0,',', '.'),
            ]);
        }
        else{
           $municipios = $municipios
           ->take($rows)
           ->get()
           ->transform(fn ($persona) => [
               'id' => $municipio->id,
               'nombre' => $municipio->nombre,
               'circuito' => $municipio->circuito,
               'eje' => $municipio->eje,
               'parroquias_count' => $municipio->parroquias_count,
               'centros_electorales_count' => $municipio->centros_electorales_count,
               'sum_electores' => number_format($municipio->sum_electores,0,',', '.'),
           ]);
       }


       return $municipios;
   }
}