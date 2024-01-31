<?php

namespace App\Http\Controllers;
use App\Enums\EjeEnum;
use App\Actions\Comunidad\CreateComunidad;
use App\Actions\Comunidad\GetComunidades;

use App\Http\Requests\StoreComunidadRequest;
use App\Http\Requests\UpdateComunidadRequest;
use App\Models\CentroElectoral;
use App\Models\Comunidad;
use App\Models\Municipio;
use App\Models\Parroquia;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class ComunidadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $count_rows = Request::input('count_rows')??15;
        $filters = Request::all('search','municipio','eje','parroquia','centro_electoral');
        $dataSort = Request::all('orderColumn','orderType');

        $comunidades = GetComunidades::run($dataSort, $filters,$count_rows);

        $comunidades->appends(Request::all());

        $centros_electorales = CentroElectoral::join('parroquias', 'parroquias.id', '=', 'centro_electorals.parroquia_id')->select('parroquias.id as parroquia_id','centro_electorals.id')
            ->selectRaw('centro_electorals.nombre as centro_electoral_nombre')->
            get()->groupBy('parroquia_id');

        $parroquias = Parroquia::join('municipios', 'municipios.id', '=', 'parroquias.municipio_id')->select('municipios.id as municipio_id','parroquias.id')
            ->selectRaw('parroquias.nombre as parroquia_nombre')->
            get()->groupBy('municipio_id');

        $municipios = Municipio::select('id','nombre')->orderBy('nombre')->get(); 

        return Inertia::render('Comunidad/Index', [
            'filters' => $filters,
            'dataSort' => $dataSort,
            'parroquias' => $parroquias,
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
    public function store(StoreComunidadRequest $request)
    {
        $data = $request->validated();

        $comunidad = CreateComunidad::run($data);

        return to_route('comunidades.index')->with('success','Comunidad Creada con Éxito');
    }

    /**
     * Display the specified resource.
     */
    public function show(Comunidad $comunidad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comunidad $comunidad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateComunidadRequest $request, Comunidad $comunidade)
    {
        $data = $request->validated();

        $comunidade->nombre = $data['nombre'];
        $comunidade->centro_electoral_id = $data['centro_electoral'];

        $comunidade->save();

        return to_route('comunidades.index')->with('success','Comunidad Actualizada con Éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comunidad $comunidade)
    {
        if($comunidade->miembros_psuv()->exists())
        {
            return to_route('comunidades.index')->with('error','comunidad con miembros activod');
        }
        if($comunidade->calles()->exists())
        {
            return to_route('comunidades.index')->with('error','comunidad con calles activas');
        }

        $comunidade->delete();

        return to_route('comunidades.index')->with('success','comunidad eliminada con éxito');
    }
}
