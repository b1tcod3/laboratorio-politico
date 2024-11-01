<?php
namespace App\Http\Controllers;

use App\Actions\Calle\GetCalles;
use App\Actions\CentroElectoral\GetCentrosElectoralesEje;
use App\Actions\Comunidad\GetComunidadesEje;
use App\Actions\Municipio\GetMunicipiosEje;
use App\Actions\Parroquia\GetParroquiasEje;
use App\Enums\EjeEnum;
use App\Http\Requests\StoreCalleRequest;
use App\Http\Requests\UpdateCalleRequest;
use App\Models\Calle;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class CalleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $numberRows = Request::input('numberRows') ?? 15;
        $filters    = Request::all('search', 'municipio', 'municipio_eje', 'parroquia', 'centro_electoral');
        $dataSort   = Request::all('orderColumn', 'orderType');

        $calles = GetCalles::run($dataSort, $filters, $numberRows);

        $calles->appends(Request::all());

        $comunidades = GetComunidadesEje::run();

        $parroquias = GetParroquiasEje::run();

        $centros_electorales = GetCentrosElectoralesEje::run();

        $municipios = GetMunicipiosEje::run();

        return Inertia::render('Calle/Index', [
            'filters'             => $filters,
            'dataSort'            => $dataSort,
            'parroquias'          => $parroquias,
            'centros_electorales' => $centros_electorales,
            'comunidades'         => $comunidades,
            'numberRows'          => $numberRows,
            'municipios'          => $municipios,
            'calles'              => $calles,
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
    public function store(StoreCalleRequest $request)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Calle $calle)
    {
        //
    }
}
