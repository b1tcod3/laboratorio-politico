<?php

namespace App\Http\Controllers;

use App\Actions\CentroElectoral\GetCentrosElectorales;
use App\Enums\EjeEnum;
use App\Models\Parroquia;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class CentroElectoralController extends Controller
{
    public function index()
    {   
        $rows = Request::input('rows')??15;
        $filters = Request::all('search','municipio','eje','parroquia');
        $dataSort = Request::all('orderColumn','orderType');

        $centros_electorales = GetCentrosElectorales::run($dataSort, $filters,$rows);

        $centros_electorales->appends(Request::all());

        $parroquias = Parroquia::join('municipios', 'municipios.id', '=', 'parroquias.municipio_id')->select('municipios.nombre')
            ->selectRaw('parroquias.nombre as parroquia_nombre')->
            get()->groupBy('nombre');

        $municipios = $parroquias->keys();

        return Inertia::render('Centro-Electoral/Index', [
            'filters' => $filters,
            'dataSort' => $dataSort,
            'parroquias' => $parroquias,
            'centros_electorales' => $centros_electorales,
            'rows' => $rows,
            'municipios' => $municipios,
            'ejes' => EjeEnum::values()
        ]);
    }
}
