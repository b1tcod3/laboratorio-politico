<?php
namespace App\Actions\Comunidad;

use App\Enums\EjeEnum;
use App\Enums\TipoDataEnum;
use App\Models\Comunidad;
use DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetComunidades
{
    use AsAction;

    public function handle($order, $filters, $rows = 10, $withPagination = 1)
    {
        $subquery_eje = DB::Raw('(SELECT data_municipios.value_enum FROM data_municipios WHERE data_municipios.tipo=' . TipoDataEnum::EJE->value . ' AND data_municipios.municipio_id=parroquias.municipio_id) as eje');

        $comunidades = Comunidad::leftjoin('centro_electorals', 'centro_electorals.id', '=', 'comunidads.centro_electoral_id')
            ->join('parroquias', 'parroquias.id', '=', 'centro_electorals.parroquia_id')
            ->join('municipios', 'municipios.id', '=', 'parroquias.municipio_id')
            ->leftjoin('data_comunidads', 'comunidads.id', '=', 'data_comunidads.comunidad_id')
            ->sort($order)
            ->select('comunidads.id', 'comunidads.nombre as comunidad_nombre', 'centro_electorals.nombre as centro_electoral_nombre', 'centro_electorals.id as centro_electoral_id', 'municipios.nombre as municipio_nombre', 'municipios.id as municipio_id', 'parroquias.id as parroquia_id',
                'parroquias.nombre as parroquia_nombre',
                $subquery_eje
            )
            ->groupBy('centro_electorals.nombre', 'comunidads.id', 'comunidads.nombre', 'centro_electorals.nombre', 'centro_electorals.id', 'parroquias.id', 'municipios.nombre', 'municipios.id', 'parroquias.nombre')
            ->filter($filters)
        ;

        if ($withPagination) {
            $comunidades = $comunidades->paginate($rows)
                ->withQueryString()
                ->through(fn($comunidad) => [
                    'id'                      => $comunidad->id,
                    'comunidad_nombre'        => $comunidad->comunidad_nombre,
                    'eje'                     => EjeEnum::from($comunidad->eje)->name,
                    'municipio_nombre'        => $comunidad->municipio_nombre,
                    'centro_electoral_nombre' => $comunidad->centro_electoral_nombre,
                    // 'sum_electores'    => number_format($centro_electoral->sum_electores, 0, ',', '.'),
                ]);

        } else {
            $comunidades = $comunidades->get();
        }
        return $comunidades;
    }
}
