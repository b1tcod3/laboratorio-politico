<?php
namespace App\Http\Controllers;

use App\Actions\CentroElectoral\GetCentrosElectoralesEje;
use App\Actions\Comunidad\GetComunidades;
use App\Actions\Municipio\GetMunicipiosEje;
use App\Actions\Parroquia\GetParroquiasEje;
use App\Enums\EjeEnum;
use App\Http\Requests\StoreComunidadRequest;
use App\Http\Requests\UpdateComunidadRequest;
use App\Models\Comunidad;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class ComunidadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $numberRows = Request::input('numberRows') ?? 15;
        $filters    = Request::all('search', 'municipio', 'municipio_eje', 'parroquia', 'centro_electoral');
        $dataSort   = Request::all('orderColumn', 'orderType');

        $comunidades = GetComunidades::run($dataSort, $filters, $numberRows);

        $comunidades->appends(Request::all());

        $parroquias = GetParroquiasEje::run();

        $centros_electorales = GetCentrosElectoralesEje::run();

        $municipios = GetMunicipiosEje::run();

        return Inertia::render('Comunidad/Index', [
            'filters'             => $filters,
            'dataSort'            => $dataSort,
            'parroquias'          => $parroquias,
            'centros_electorales' => $centros_electorales,
            'comunidades'         => $comunidades,
            'numberRows'          => $numberRows,
            'municipios'          => $municipios,
            'ejes'                => EjeEnum::toArray(),
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
        //
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
    public function update(UpdateComunidadRequest $request, Comunidad $comunidad)
    {
        //
    }

/**
 * Remove the specified resource from storage.
 */
    public function destroy(Comunidad $comunidad)
    {
        //
    }
}
