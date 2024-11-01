<?php
namespace App\Actions\Comunidad;

use App\Models\Comunidad;
use Lorisleiva\Actions\Concerns\AsAction;

class GetComunidadesCollection
{
    use AsAction;

    public function handle($order, $filters, $rows = 10)
    {
        $comunidades = Comunidad::leftjoin('centro_electorals', 'centro_electorals.id', '=', 'comunidads.centro_electoral_id')
            ->join('parroquias', 'parroquias.id', '=', 'centro_electorals.parroquia_id')
            ->join('municipios', 'municipios.id', '=', 'parroquias.municipio_id')
            ->leftjoin('data_comunidads', 'comunidads.id', '=', 'data_comunidads.comunidad_id')
            ->filter($filters)
            ->sort($order)
            ->select('comunidads.id', 'comunidads.nombre as comunidad_nombre', 'centro_electorals.nombre as centro_electoral_nombre', 'centro_electorals.id as centro_electoral_id', 'municipios.nombre as municipio_nombre', 'municipios.id as municipio_id', 'parroquias.id as parroquia_id',
                'parroquias.nombre as parroquia_nombre'
            )
            ->groupBy('centro_electorals.nombre', 'comunidads.id', 'comunidads.nombre', 'centro_electorals.nombre', 'centro_electorals.id', 'parroquias.id', 'municipios.nombre', 'municipios.id', 'parroquias.nombre');

        return $comunidades->get();
    }
}
