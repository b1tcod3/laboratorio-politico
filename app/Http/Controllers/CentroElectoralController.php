<?php
namespace App\Http\Controllers;

use App\Actions\CentroElectoral\GetCentrosElectorales;
use App\Actions\Comunidad\GetComunidadesCollection;
use App\Actions\Municipio\GetMunicipiosEje;
use App\Actions\Parroquia\GetParroquiasEje;
use App\Enums\EjeEnum;
use App\Models\CentroElectoral;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class CentroElectoralController extends Controller
{
    public function index()
    {
        $numberRows = Request::input('numberRows') ?? 15;
        $filters    = Request::all('search', 'municipio', 'municipio_eje', 'parroquia');
        $dataSort   = Request::all('orderColumn', 'orderType');

        $centros_electorales = GetCentrosElectorales::run($dataSort, $filters, $numberRows);

        $centros_electorales->appends(Request::all());

        $parroquias = GetParroquiasEje::run();

        $municipios = GetMunicipiosEje::run();

        return Inertia::render('CentroElectoral/Index', [
            'filters'             => $filters,
            'dataSort'            => $dataSort,
            'parroquias'          => $parroquias,
            'centros_electorales' => $centros_electorales,
            'numberRows'          => $numberRows,
            'municipios'          => $municipios,
            'ejes'                => EjeEnum::toArray(),
        ]);
    }

    public function show(CentroElectoral $centro_electoral)
    {

        $data_parroquia = [
            'eje'       => $centro_electoral->parroquia->municipio->eje(),
            'municipio' => $centro_electoral->parroquia->municipio->nombre,
        ];

        $comunidades = GetComunidadesCollection::run(
            ['nombre', 'asc'],
            ['centro_electoral_id' => $centro_electoral->id],
            10
        );

        return Inertia::render('CentroElectoral/Show', [
            'centro_electoral' => $centro_electoral,
            'data'             => $data_parroquia,
            'comunidades'      => $comunidades,
        ]);
    }
}
