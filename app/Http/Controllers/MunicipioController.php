<?php

namespace App\Http\Controllers;

use App\Actions\Municipio\GetMunicipios;
use App\Actions\Parroquia\GetParroquiasCollection;
use App\Enums\EjeEnum;
use App\Models\Municipio;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class MunicipioController extends Controller
{
    public function index()
    {   
        $numberRows = Request::input('numberRows')??10;
        $filters = Request::all('search','eje');
        $dataSort = Request::all('columnSort','typeSort');

        $municipios = GetMunicipios::run($dataSort, $filters,$numberRows);

        $municipios->appends(Request::all());

        return Inertia::render('Municipio/Index', [
            'municipios' => $municipios,
            'numberRows' => $numberRows,
            'dataSort' => $dataSort,
            'filters' => $filters,
            'ejes' => EjeEnum::array()
        ]);
    }

    public function show(Municipio $municipio){

        $data_municipio = [
            'eje' => $municipio->eje()
            ];

        $parroquias = GetParroquiasCollection::run(
            ['nombre','asc'],
            ['municipio' =>$municipio->id ],
            10
        );

        return Inertia::render('Municipio/Show', [
            'municipio' => $municipio,
            'data' => $data_municipio,
            'parroquias' => $parroquias
        ]);
    }
}
