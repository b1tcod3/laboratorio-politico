<?php

namespace App\Http\Controllers;

use App\Actions\Parroquia\GetParroquias;
use App\Enums\EjeEnum;
use App\Models\Municipio;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class ParroquiaController extends Controller
{
    public function index()
    {   
        $rows = Request::input('rows')??15;
        $filters = Request::all('search','municipio','eje');
        $dataSort = Request::all('orderColumn','orderType');

        $parroquias = GetParroquias::run($dataSort, $filters,$rows);

        $parroquias->appends(Request::all());

        return Inertia::render('Parroquia/Index', [
            'filters' => $filters,
            'dataSort' => $dataSort,
            'parroquias' => $parroquias,
            'rows' => $rows,
            'municipios' => Municipio::orderBy('nombre')->get('nombre')->pluck('nombre'),
            'ejes' => EjeEnum::values()
        ]);
    }
}
