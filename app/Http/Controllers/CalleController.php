<?php

namespace App\Http\Controllers;

use App\Actions\Calle\GetCalles;
use App\Actions\Calle\CreateCalle;
use App\Enums\EjeEnum;
use App\Http\Requests\StoreCalleRequest;
use App\Http\Requests\UpdateCalleRequest;
use App\Models\Calle;
use App\Models\CentroElectoral;
use App\Models\Comunidad;
use App\Models\Municipio;
use App\Models\Parroquia;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class CalleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $count_rows = Request::input('count_rows')??15;
        $filters = Request::all('search','municipio','eje','parroquia','centro_electoral','calle', 'comunidad');
        $dataSort = Request::all('orderColumn','orderType');

        $calles = GetCalles::run($dataSort, $filters,$count_rows);

        $calles->appends(Request::all());

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

        return Inertia::render('Calle/Index', [
            'filters' => $filters,
            'dataSort' => $dataSort,
            'parroquias' => $parroquias,
            'calles' => $calles,
            'comunidades' => $comunidades,
            'centros_electorales' => $centros_electorales,
            'count_rows' => $count_rows,
            'municipios' => $municipios,
            'ejes' => EjeEnum::values()
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
    public function store(StoreCalleRequest $request)
    {
        $data = $request->validated();

        $calle = CreateCalle::run($data);

        return to_route('calles.index')->with('success','Calle Creada con Éxito');
    }

    /**
     * Display the specified resource.
     */
    public function show(Calle $calle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Calle $calle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCalleRequest $request, Calle $calle)
    {
        $data = $request->validated();

        $calle->nombre = $data['nombre'];
        $calle->comunidad_id = $data['comunidad'];

        $calle->save();

        return to_route('calles.index')->with('success','Calle Actualizada con Éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Calle $calle)
    {
        if($calle->miembros_psuv()->exists())
        {
            return to_route('calles.index')->with('error','calle con miembros activod');
        }
        // if($calle->calles()->exists())
        // {
        //     return to_route('calles.index')->with('error','calle con calles activas');
        // }

        $calle->delete();

        return to_route('calles.index')->with('success','calle eliminada con éxito');
    }
}
