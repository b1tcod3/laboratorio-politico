<?php
namespace App\Actions\Calle;

use App\Enums\EjeEnum;
use App\Enums\TipoDataEnum;
use App\Models\Calle;
use DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetCalles
{
    use AsAction;

    public function handle($order, $filters, $rows = 10, $withPagination = 1)
    {
        $subquery_eje = DB::Raw('(SELECT data_municipios.value_enum FROM data_municipios WHERE data_municipios.tipo=' . TipoDataEnum::EJE->value . ' AND data_municipios.municipio_id=parroquias.municipio_id) as eje');

        $calles = Calle::join('comunidads', 'comunidads.id', '=', 'calles.comunidad_id')
            ->join('centro_electorals', 'centro_electorals.id', '=', 'comunidads.centro_electoral_id')
            ->join('parroquias', 'parroquias.id', '=', 'centro_electorals.parroquia_id')
            ->join('municipios', 'municipios.id', '=', 'parroquias.municipio_id')
            ->leftjoin('data_calles', 'calles.id', '=', 'data_calles.calle_id')
            ->filter($filters)
            ->sort($order)
            ->select('calles.id', 'calles.nombre as calle_nombre', 'comunidads.nombre as comunidad_nombre', 'centro_electorals.nombre as centro_electoral_nombre', 'centro_electorals.id as centro_electoral_id', 'municipios.nombre as municipio_nombre', 'municipios.id as municipio_id', 'parroquias.id as parroquia_id',
                'parroquias.nombre as parroquia_nombre',
                $subquery_eje
            )
            ->groupBy('calles.nombre', 'calles.id', 'centro_electorals.nombre', 'comunidads.id', 'comunidads.nombre', 'centro_electorals.nombre', 'centro_electorals.id', 'parroquias.id', 'municipios.nombre', 'municipios.id', 'parroquias.nombre');

        if ($withPagination) {
            $calles = $calles->paginate($rows)
                ->withQueryString()
                ->through(fn($calle) => [
                    'id'                      => $calle->id,
                    'calle_nombre'            => $calle->calle_nombre,
                    'comunidad_nombre'        => $calle->comunidad_nombre,
                    'eje'                     => EjeEnum::from($calle->eje)->name,
                    'municipio_nombre'        => $calle->municipio_nombre,
                    'centro_electoral_nombre' => $calle->centro_electoral_nombre,
                    // 'sum_electores'    => number_format($centro_electoral->sum_electores, 0, ',', '.'),
                ]);

        } else {
            $calles = $calles->get();
        }
        return $calles;
    }
}
