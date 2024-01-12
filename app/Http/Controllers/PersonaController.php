<?php

namespace App\Http\Controllers;

use App\Actions\Buscar\BuscarPersona;
use App\Actions\Persona\GetPersonas;
use App\Models\CentroElectoral;
use App\Models\Municipio;
use App\Models\Parroquia;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;


class PersonaController extends Controller
{
    public function index()
    {   
        $rows = Request::input('rows')??15;
        $filters = Request::all('search','parroquia','sexo','centro_electoral');

        $parroquia = Request::input('parroquia');

        $centros_electorales = $parroquia? CentroElectoral::where('parroquia_id',$parroquia)->select('id','nombre')->get():[];
        
        $personas = GetPersonas::run($filters,$rows);

        $personas->appends(Request::all());

        $parroquias = Parroquia::join('municipios', 'municipios.id', '=', 'parroquias.municipio_id')->select('municipios.nombre','parroquias.id')
            ->selectRaw('parroquias.nombre as parroquia_nombre')->
            get()->groupBy('nombre');

        $municipios = $parroquias->keys();

        return Inertia::render('Persona/Index', [
            'filters' => $filters,
            'personas' => $personas,
            'parroquias' => $parroquias,
            'centrosElectorales' => $centros_electorales,
            'municipios' => $municipios,
            'rows' => $rows
        ]);
    }

    public function buscar()
    {   
        
        $filters = Request::all('cedula','nombre','apellido','sexo','municipio','parroquia','centro_electoral','nombres');
        
        $personas = BuscarPersona::run($filters);

        $personas->appends(Request::all());

        $parroquias = Parroquia::join('municipios', 'municipios.id', '=', 'parroquias.municipio_id')->select('municipios.nombre','parroquias.id')
            ->selectRaw('parroquias.nombre as parroquia_nombre')->
            get()->groupBy('nombre');

        $municipios = $parroquias->keys();

        $centros_electorales = CentroElectoral::join('parroquias', 'parroquias.id', '=', 'centro_electorals.parroquia_id')->select('parroquias.id','centro_electorals.nombre')
            ->selectRaw('centro_electorals.id as centro_electoral_id')->
            get()->groupBy('id');

        return Inertia::render('Busqueda/Persona', [
            'filters' => $filters,
            'personas' => $personas,
            'parroquias' => $parroquias,
            'centrosElectorales' => $centros_electorales,
            'municipios' => $municipios,
        ]);
    }
}
