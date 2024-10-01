<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use App\Actions\Parroquia\GetParroquias;
use App\Actions\Municipio\GetMunicipiosEje;
use App\Actions\CentroElectoral\GetCentrosElectoralesCollection;
use Inertia\Inertia;
use App\Models\Municipio;
use App\Models\Parroquia;
use App\Enums\EjeEnum;

class ParroquiaController extends Controller
{
    public function index()
    {   
        $numberRows = Request::input('numberRows')??15;
        $filters = Request::all('search','municipio','eje');
        $dataSort = Request::all('columnSort','typeSort');

        $parroquias = GetParroquias::run($dataSort, $filters,$numberRows);

        $parroquias->appends(Request::all());

        return Inertia::render('Parroquia/Index', [
            'filters' => $filters,
            'dataSort' => $dataSort,
            'numberRows' => $numberRows,
            'parroquias' => $parroquias,
            'municipios' => GetMunicipiosEje::run(),
            'ejes' => EjeEnum::array()
        ]);
    }

    public function show(Parroquia $parroquia){

        $data_parroquia = [
            'eje' => $parroquia->municipio->eje(),
            'municipio' => $parroquia->municipio->nombre
            ];

        $centros_electorales = GetCentrosElectoralesCollection::run(
            ['nombre','asc'],
            ['parroquia' =>$parroquia->id ],
            10
        );

        return Inertia::render('Parroquia/Show', [
            'parroquia' => $parroquia,
            'data' => $data_parroquia,
            'centros_electorales' => $centros_electorales
        ]);
    }
}
