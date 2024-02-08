<?php

namespace App\Http\Controllers;

use App\Actions\Cargo\GetCargos;
use App\Actions\EstructurasPsuv\GetMiembrosPsuvBaseComunidad;
use App\Actions\EstructurasPsuv\GetMiembrosPsuvBaseCalle;
use App\Actions\EstructurasPsuv\GetMiembrosPsuvBaseUbch;
use App\Actions\EstructurasPsuv\GetMiembrosPsuvMedia;
use App\Enums\NivelCargoEnum;
use App\Models\Calle;
use App\Models\CentroElectoral;
use App\Models\Comunidad;
use App\Models\Municipio;
use App\Models\Parroquia;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class EstructuraController extends Controller
{
    public function EPR(){

    	$count_rows = Request::input('count_rows')??15;
        $filters = Request::all('nombres','personas','sexo','cedula');

        $dataSort = Request::all('orderColumn','orderType');

        $miembros = GetMiembrosPsuvMedia::run($filters,NivelCargoEnum::EPR,$dataSort,$count_rows);

        $miembros->appends(Request::all());
        
        $cargos = GetCargos::run(NivelCargoEnum::EPR);

        return Inertia::render('Estructura/Regional', [
            'filters' => $filters,
            'miembros' => $miembros,
            'count_rows' => $count_rows,
            'cargos' => $cargos,
            'dataSort' => $dataSort,
        ]);
    }

    public function EPM(){
        $count_rows = Request::input('count_rows')??15;
        $filters = Request::all('nombres','personas','municipio','sexo','cedula');

        $dataSort = Request::all('orderColumn','orderType');

        $miembros = GetMiembrosPsuvMedia::run($filters,NivelCargoEnum::EPM,$dataSort,$count_rows);

        $miembros->appends(Request::all());
        
        $cargos = GetCargos::run(NivelCargoEnum::EPM);

        $municipios = Municipio::select('id','nombre')->orderBy('nombre')->get();

        return Inertia::render('Estructura/Municipal', [
            'filters' => $filters,
            'miembros' => $miembros,
            'count_rows' => $count_rows,
            'municipios' => $municipios,
            'cargos' => $cargos,
            'dataSort' => $dataSort,
        ]);
    }
    public function EPP(){

        $count_rows = Request::input('count_rows')??15;
        $filters = Request::all('nombres','personas','municipio_parroquia','parroquia','sexo','cedula');

        $dataSort = Request::all('orderColumn','orderType');

        $miembros = GetMiembrosPsuvMedia::run($filters,NivelCargoEnum::EPP,$dataSort,$count_rows);

        $miembros->appends(Request::all());
        
        $cargos = GetCargos::run(NivelCargoEnum::EPP);

        //data parroquia
        
        $parroquias = Parroquia::join('municipios', 'municipios.id', '=', 'parroquias.municipio_id')->select('municipios.id as municipio_id','parroquias.id')
            ->selectRaw('parroquias.nombre as parroquia_nombre')->
            get()->groupBy('municipio_id');

        $municipios = Municipio::select('id','nombre')->orderBy('nombre')->get(); 

        return Inertia::render('Estructura/Parroquial', [
            'filters' => $filters,
            'miembros' => $miembros,
            'count_rows' => $count_rows,
            'cargos' => $cargos,
            'dataSort' => $dataSort,
            'municipios' => $municipios,
            'parroquias' => $parroquias
        ]);
    }

    public function UBCH(){

        $count_rows = Request::input('count_rows')??15;
        $filters = Request::all('nombres','personas','municipio','parroquia','centro_electoral','sexo','cedula');

        $dataSort = Request::all('orderColumn','orderType');

        $miembros = GetMiembrosPsuvBaseUbch::run($filters,NivelCargoEnum::UBCH,$dataSort,$count_rows);

        $miembros->appends(Request::all());
        
        $cargos = GetCargos::run(NivelCargoEnum::UBCH);

        //data parroquia
        
        $centros_electorales = CentroElectoral::join('parroquias', 'parroquias.id', '=', 'centro_electorals.parroquia_id')->select('parroquias.id as parroquia_id','centro_electorals.id')
            ->selectRaw('centro_electorals.nombre as centro_electoral_nombre')->
            get()->groupBy('parroquia_id');

        $parroquias = Parroquia::join('municipios', 'municipios.id', '=', 'parroquias.municipio_id')->select('municipios.id as municipio_id','parroquias.id')
            ->selectRaw('parroquias.nombre as parroquia_nombre')->
            get()->groupBy('municipio_id');

        $municipios = Municipio::select('id','nombre')->orderBy('nombre')->get(); 

        return Inertia::render('Estructura/Ubch', [
            'filters' => $filters,
            'miembros' => $miembros,
            'count_rows' => $count_rows,
            'cargos' => $cargos,
            'dataSort' => $dataSort,
            'municipios' => $municipios,
            'parroquias' => $parroquias,
            'centros_electorales' => $centros_electorales
        ]);
    }

    public function COMUNIDAD(){

        $count_rows = Request::input('count_rows')??15;
        $filters = Request::all('nombres','personas','municipio','parroquia','centro_electoral','comunidad','sexo','cedula');

        $dataSort = Request::all('orderColumn','orderType');

        $miembros = GetMiembrosPsuvBaseComunidad::run($filters,NivelCargoEnum::COMUNIDAD,$dataSort,$count_rows);

        $miembros->appends(Request::all());
        
        $cargos = GetCargos::run(NivelCargoEnum::COMUNIDAD);

        //data parroquia
        
        $comunidades = Comunidad::join('centro_electorals', 'centro_electorals.id', '=', 'comunidads.centro_electoral_id')->select('centro_electorals.id as centro_electoral_id','comunidads.id')
            ->selectRaw('comunidads.nombre as comunidad_nombre')->
            get()->groupBy('centro_electoral_id');

        $centros_electorales = CentroElectoral::join('parroquias', 'parroquias.id', '=', 'centro_electorals.parroquia_id')->select('parroquias.id as parroquia_id','centro_electorals.id')
            ->selectRaw('centro_electorals.nombre as centro_electoral_nombre')->
            get()->groupBy('parroquia_id');

        $parroquias = Parroquia::join('municipios', 'municipios.id', '=', 'parroquias.municipio_id')->select('municipios.id as municipio_id','parroquias.id')
            ->selectRaw('parroquias.nombre as parroquia_nombre')->
            get()->groupBy('municipio_id');

        $municipios = Municipio::select('id','nombre')->orderBy('nombre')->get(); 

        return Inertia::render('Estructura/Comunidad', [
            'filters' => $filters,
            'miembros' => $miembros,
            'count_rows' => $count_rows,
            'cargos' => $cargos,
            'dataSort' => $dataSort,
            'municipios' => $municipios,
            'parroquias' => $parroquias,
            'comunidades' => $comunidades,
            'centros_electorales' => $centros_electorales
        ]);
    }

    public function CALLE(){

        $count_rows = Request::input('count_rows')??15;
        $filters = Request::all('nombres','personas','municipio','parroquia','centro_electoral','comunidad','calle','sexo','cedula');

        $dataSort = Request::all('orderColumn','orderType');

        $miembros = GetMiembrosPsuvBaseCalle::run($filters,NivelCargoEnum::CALLE,$dataSort,$count_rows);

        $miembros->appends(Request::all());
        
        $cargos = GetCargos::run(NivelCargoEnum::CALLE);

        //data parroquia
        
        $calles = Calle::join('comunidads', 'comunidads.id', '=', 'calles.comunidad_id')->select('comunidads.id as comunidad_id','calles.id')
            ->selectRaw('calles.nombre as calle_nombre')->
            get()->groupBy('comunidad_id');

        $comunidades = Comunidad::join('centro_electorals', 'centro_electorals.id', '=', 'comunidads.centro_electoral_id')->select('centro_electorals.id as centro_electoral_id','comunidads.id')
            ->selectRaw('comunidads.nombre as comunidad_nombre')->
            get()->groupBy('centro_electoral_id');

        $centros_electorales = CentroElectoral::join('parroquias', 'parroquias.id', '=', 'centro_electorals.parroquia_id')->select('parroquias.id as parroquia_id','centro_electorals.id')
            ->selectRaw('centro_electorals.nombre as centro_electoral_nombre')->
            get()->groupBy('parroquia_id');

        $parroquias = Parroquia::join('municipios', 'municipios.id', '=', 'parroquias.municipio_id')->select('municipios.id as municipio_id','parroquias.id')
            ->selectRaw('parroquias.nombre as parroquia_nombre')->
            get()->groupBy('municipio_id');

        $municipios = Municipio::select('id','nombre')->orderBy('nombre')->get(); 

        return Inertia::render('Estructura/Calle', [
            'filters' => $filters,
            'miembros' => $miembros,
            'count_rows' => $count_rows,
            'cargos' => $cargos,
            'dataSort' => $dataSort,
            'municipios' => $municipios,
            'parroquias' => $parroquias,
            'comunidades' => $comunidades,
            'calles' => $calles,
            'centros_electorales' => $centros_electorales
        ]);
    }
}
