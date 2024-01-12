<?php

namespace App\Http\Controllers;

use App\Actions\Municipio\GetMunicipios;
use App\Actions\Resumen\GetResumenGeneral;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ResumenController extends Controller
{
    /**
     * Muestra resumen del sistema
     */
    public function index(Request $request)
    {	
    	$resumen = GetResumenGeneral::run();

        $municipios = GetMunicipios::run([], [],25);

        return Inertia::render('Resumen/Index', [
            'resumen' => $resumen,
            'municipios' => $municipios,
        ]);
    }
}
