<?php
namespace App\Actions\Parroquia;

use App\Enums\TipoDataEnum;
use App\Models\Parroquia;
use DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetParroquiasCollection
{
    use AsAction;

    public function handle($order, $filters, $rows = 10)
    {
        $parroquias = Parroquia::leftjoin('data_parroquias', 'parroquias.id', '=', 'data_parroquias.parroquia_id')
            ->select(
                DB::Raw('SUM(CASE when data_parroquias.tipo=' . TipoDataEnum::CANTIDAD_CENTROS_ELECTORALES->value . ' THEN data_parroquias.value_numeric ELSE 0 END) as centros_electorales_count'),
                // DB::Raw('SUM(CASE when data_parroquias.tipo='.TipoDataEnum::CANTIDAD_COMUNIDADES->value.' THEN data_parroquias.value_numeric ELSE 0 END) as sum_comunidades'),
                // DB::Raw('SUM(CASE when data_parroquias.tipo='.TipoDataEnum::CANTIDAD_CALLES->value.' THEN data_parroquias.value_numeric ELSE 0 END) as sum_calles'),
                // DB::Raw('SUM(CASE when data_parroquias.tipo='.TipoDataEnum::CANTIDAD_ELECTORES->value.' THEN data_parroquias.value_numeric ELSE 0 END) as sum_electores'),
                'parroquias.id', 'parroquias.nombre')
            ->groupBy('parroquias.id', 'parroquias.nombre')
            ->filter($filters)
            ->sort($order)
        ;

        $parroquias = $parroquias
            ->take($rows)
            ->get()
            ->transform(fn($parroquia) => [
                'id'                        => $parroquia->id,
                'nombre'                    => $parroquia->nombre,
                // 'circuito' => $parroquia->circuito,
                // 'eje' => $parroquia->eje,
                'centros_electorales_count' => intval($parroquia->centros_electorales_count),
                //  'sum_electores' =>$parroquia->sum_electores, //$municipio->sum_electores,
                // 'sum_comunidades' => intval($parroquia->sum_comunidades),
                // 'sum_calles' => $parroquia->sum_calles,
            ]);

        return $parroquias;

    }
}
