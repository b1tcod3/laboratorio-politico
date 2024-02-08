<?php

namespace App\Http\Controllers;

use App\Actions\VotoCalle\GetVotoCalle;
use App\Actions\Calle\InfoCalle;
use App\Actions\VotoCalle\CreateVotoCalle;
use App\Actions\VotoCalle\UpdateVotoCalle;
use App\Enums\TipoVotoEnum;
use App\Enums\HoraVotoEnum;
use App\Http\Requests\StoreVotoCalleRequest;
use App\Http\Requests\UpdateVotoCalleRequest;
use App\Models\Calle;
use App\Models\CentroElectoral;
use App\Models\Comunidad;
use App\Models\Municipio;
use App\Models\Parroquia;
use App\Models\VotoCalle;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class VotoCalleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $count_rows = Request::input('count_rows')??15;
        $filters = Request::all('nombres','personas','municipio','parroquia','centro_electoral','comunidad','calle','sexo','cedula');

        $dataSort = Request::all('orderColumn','orderType');

        $votos = GetVotoCalle::run($filters,$dataSort,$count_rows);

        $votos->appends(Request::all());
        
        $info_calle = InfoCalle::run($filters['calle']);

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

        return Inertia::render('VotoCalle/Index', [
            'filters' => $filters,
            'count_rows' => $count_rows,
            'info_calle' => $info_calle,
            'dataSort' => $dataSort,
            'municipios' => $municipios,
            'parroquias' => $parroquias,
            'comunidades' => $comunidades,
            'calles' => $calles,
            'tipo_voto' => TipoVotoEnum::array(),
            'hora_voto' => HoraVotoEnum::array(),
            'votos' => $votos,
            'centros_electorales' => $centros_electorales
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVotoCalleRequest $request)
    {
        $data = $request->validated();
        
        $voto = CreateVotoCalle::run($data);

         return to_route('votos_calle.index',['calle'=>$voto->calle_id,'comunidad'=>$voto->calle->comunidad->id,'centro_electoral'=>$voto->calle->comunidad->centro_electoral->id,'municipio'=>$voto->calle->comunidad->centro_electoral->parroquia->municipio->id,'parroquia'=>$voto->calle->comunidad->centro_electoral->parroquia->id])->with('success','Voto Calle Registrado con Éxito');
    }

    /**
     * Display the specified resource.
     */
    public function show(VotoCalle $votoCalle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VotoCalle $votoCalle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVotoCalleRequest $request, VotoCalle $votos_calle)
    {
        $data = $request->validated();
        $voto = UpdateVotoCalle::run($votos_calle,$data);

         return to_route('votos_calle.index',['calle'=>$voto->calle_id,'comunidad'=>$voto->calle->comunidad->id,'centro_electoral'=>$voto->calle->comunidad->centro_electoral->id,'municipio'=>$voto->calle->comunidad->centro_electoral->parroquia->municipio->id,'parroquia'=>$voto->calle->comunidad->centro_electoral->parroquia->id])->with('success','Voto Calle Registrado con Éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VotoCalle $votos_calle)
    {   
        $calle = $votos_calle->calle;
        $votos_calle->delete();

        return to_route('votos_calle.index',['calle'=>$calle->id,'comunidad'=>$calle->comunidad->id,'centro_electoral'=>$calle->comunidad->centro_electoral->id,'municipio'=>$calle->comunidad->centro_electoral->parroquia->municipio->id,'parroquia'=>$calle->comunidad->centro_electoral->parroquia->id])->with('success','Voto Calle Registrado con Éxito');
    }
}
