<?php
namespace App\Actions\Comunidad;

use App\Enums\EjeEnum;
use App\Enums\TipoDataEnum;
use App\Models\Comunidad;
use Lorisleiva\Actions\Concerns\AsAction;

class GetComunidadesEje
{
    use AsAction;

    public function handle()
    {
        $comunidades = Comunidad::leftjoin('centro_electorals', 'centro_electorals.id', '=', 'comunidads.centro_electoral_id')->join('parroquias', 'parroquias.id', '=', 'centro_electorals.parroquia_id')
            ->join('municipios', 'municipios.id', '=', 'parroquias.municipio_id')
            ->join('data_municipios', 'municipios.id', '=', 'data_municipios.municipio_id')
            ->select('comunidads.id', 'municipios.id as municipio_id', 'centro_electorals.id as centro_electoral_id', 'centro_electorals.parroquia_id', 'comunidads.nombre', 'data_municipios.value_enum')
            ->where('data_municipios.tipo', TipoDataEnum::EJE->value)
            ->orderBy('parroquias.nombre')
            ->get()->transform(fn($comunidad) => [
            'id'                  => $comunidad->id,
            'nombre'              => $comunidad->nombre,
            'centro_electoral_id' => $comunidad->centro_electoral_id,
            'parroquia_id'        => $comunidad->parroquia_id,
            'municipio_id'        => $comunidad->municipio_id,
            'eje'                 => EjeEnum::from($comunidad->value_enum)->name,
            'eje_id'              => $comunidad->value_enum,
        ]);

        return $comunidades;
    }
}
