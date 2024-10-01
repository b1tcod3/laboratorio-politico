<?php

namespace App\Http\Controllers;

use App\Actions\CentroElectoral\GetCentrosElectorales;
use App\Actions\Municipio\GetMunicipiosEje;
use App\Actions\Parroquia\GetParroquiasEje;
use App\Enums\EjeEnum;
use App\Models\Parroquia;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class CentroElectoralController extends Controller
{
    public function index()
    {   
        $numberRows = Request::input('numberRows')??15;
        $filters = Request::all('search','municipio','eje','parroquia');
        $dataSort = Request::all('orderColumn','orderType');

        $centros_electorales = GetCentrosElectorales::run($dataSort, $filters,$numberRows);

        $centros_electorales->appends(Request::all());

        $parroquias = GetParroquiasEje::run();

        $municipios = GetMunicipiosEje::run();

        return Inertia::render('Centro-Electoral/Index', [
            'filters' => $filters,
            'dataSort' => $dataSort,
            'parroquias' => $parroquias,
            'centros_electorales' => $centros_electorales,
            'numberRows' => $numberRows,
            'municipios' => $municipios,
            'ejes' => EjeEnum::array()
        ]);
    }
}
