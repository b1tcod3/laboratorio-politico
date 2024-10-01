<?php

namespace App\Http\Controllers;

use App\Actions\ResultadoElectoral\GetResultadosElectorales;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use App\Models\CentroElectoral;
use App\Actions\Municipio\GetMunicipiosEje;
use App\Actions\Parroquia\GetParroquiasEje;
use App\Actions\CentroElectoral\GetCentrosElectoralesEje;
use App\Enums\EjeEnum;

class ResultadosElectoralesController extends Controller
{
    public function index()
    {  
    	$filters = Request::all('municipio','municipio_eje','parroquia','centro_electoral');


    	$data = GetResultadosElectorales::run($filters);

    	$data_votos = [
            	$data->first()->votos_2015,
            	$data->first()->votos_2017,
            	$data->first()->votos_2018,
            	$data->first()->votos_2021,
        ];

        $parroquias = GetParroquiasEje::run();

        $municipios = GetMunicipiosEje::run();

        $centros_electorales = GetCentrosElectoralesEje::run();

        return Inertia::render('Resultados-Electorales/Index', [
            'data_votos' => $data_votos,
            'parroquias' => $parroquias,
            'municipios' => $municipios,
            'centros_electorales' => $centros_electorales,
            'ejes' => EjeEnum::array(),
            'filters' => $filters,
        	]
        );
    }
}
