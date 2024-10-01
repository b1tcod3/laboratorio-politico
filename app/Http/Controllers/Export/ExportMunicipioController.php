<?php

namespace App\Http\Controllers\Export;

use App\Http\Controllers\Controller;
use App\Actions\Municipio\GetMunicipiosCollection;
use Illuminate\Support\Facades\Request;
use App\Exports\MunicipiosExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportMunicipioController extends Controller
{
     public function index() 
    {	
    	$numberRows = Request::input('numberRows')??10;
        $filters = Request::all('search','eje');
        $dataSort = Request::all('columnSort','typeSort');

        $municipios = GetMunicipiosCollection::run($dataSort, $filters,$numberRows);

        return Excel::download(new MunicipiosExport($municipios), 'data-municipios.xlsx');
    }
}
