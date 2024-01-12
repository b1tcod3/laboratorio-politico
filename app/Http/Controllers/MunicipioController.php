<?php

namespace App\Http\Controllers;

use App\Actions\Municipio\GetMunicipios;
use App\Models\Municipio;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class MunicipioController extends Controller
{
    public function index()
    {   
        $rows = Request::input('count_rows')??15;
        $filters = Request::all('search');
        $dataSort = Request::all('orderColumn','orderType');

        $municipios = GetMunicipios::run($dataSort, $filters,$rows);

        $municipios->appends(Request::all());

        $fields =[
            ['id'=>1,'name_display'=>'ID','name'=>'id'],
            ['id'=>2,'name_display'=>'Nombre','name'=>'nombre']
        ];

        //botones de acción para la tabla
        
        $buttonsActions =['show'];

        return Inertia::render('Listado/Index', [
            'filters' => $filters,
            'dataSort' => $dataSort,
            'rows' => $municipios,
            'routeName'=>'/municipios/',
            'count_rows' => $rows,
            'name' => 'Municipios',
            'fields' => $fields,
            'buttonsActions' => $buttonsActions
        ]);
    }

    public function show(Municipio $municipio){

        return $municipio;
    }
}
