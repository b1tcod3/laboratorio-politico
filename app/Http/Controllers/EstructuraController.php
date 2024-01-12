<?php

namespace App\Http\Controllers;

use App\Enums\NivelCargoEnum;
use App\Actions\EstructurasPsuv\GetMiembrosPsuv;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class EstructuraController extends Controller
{
    public function EPR(){
    	$count_rows = Request::input('count_rows')??15;
        $filters = Request::all('nombres','personas','parroquia','sexo','cedula');

        $miembros = GetMiembrosPsuv::run($filters,NivelCargoEnum::EPR,$count_rows);

        $dataSort = Request::all('orderColumn','orderType');

        $miembros->appends(Request::all());

        session()->flash('message', 'Post successfully updated.');
        
        return Inertia::render('Estructura/Regional', [
            'filters' => $filters,
            'miembros' => $miembros,
            'count_rows' => $count_rows,
            'dataSort' => $dataSort,
        ]);
    }
}
