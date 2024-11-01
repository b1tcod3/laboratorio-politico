<?php
namespace App\Http\Controllers;

use App\Enums\NivelEstructuraEnum;
use App\Enums\TipoOrganizacionEnum;
use App\Http\Requests\Organizacion\StoreOrganizacionRequest;
use App\Http\Requests\Organizacion\UpdateOrganizacionRequest;
use App\Models\Organizacion;
use ErlandMuchasaj\LaravelFileUploader\FileUploader;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Validation\Rules\File;
use Inertia\Inertia;

class OrganizacionController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            'auth',
            new Middleware(HandlePrecognitiveRequests::class, only: ['store', 'update']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $organizaciones = Organizacion::orderBy('nombre')
            ->get()
            ->transform(fn($organizacion) =>
                ['id'    => $organizacion->id,
                    'nombre' => $organizacion->nombre,
                    'logo'   => $organizacion->logo,
                    'tipo'   => str_replace('_', ' ', TipoOrganizacionEnum::from($organizacion->tipo)->name),
                ]
            );

        return Inertia::render('Organizacion/Index', [
            'organizaciones' => $organizaciones,
        ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Organizacion/Create', [
            'tipos' => TipoOrganizacionEnum::toArray(),
        ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrganizacionRequest $request)
    {
        $input = $request->validated();

        $file = $input['logo'];

        $response = FileUploader::store($file);

        $input['logo'] = $response['path'];

        Organizacion::create($input);

        return redirect('/organizaciones')->with('success', 'Organización Creada con éxito!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Organizacion $organizacione)
    {
        return Inertia::render('Organizacion/Show', [
            'organizacion'       => $organizacione,
            'niveles_estructura' => NivelEstructuraEnum::toArray(),
            'estructuras'        => $organizacione->estructuras,
        ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Organizacion $organizacione)
    {
        return Inertia::render('Organizacion/Edit', [
            'tipos'        => TipoOrganizacionEnum::toArray(),
            'organizacion' => $organizacione,
        ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrganizacionRequest $request, Organizacion $organizacione)
    {
        $input = $request->validated();

        $organizacione->update($input);

        return redirect('/organizaciones')->with('success', 'Organización Actualizada con éxito!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Organizacion $organizacione)
    {
        $organizacione->delete();

        return redirect('/organizaciones')->with('success', 'Organización Elimanada con éxito!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function updateLogo(Request $request, Organizacion $organizacione)
    {

        $extensions = implode(',', FileUploader::images());

        $validated = $request->validate([
            'logo' => ['required', File::image()->max(2 * 1000),
                'mimes:' . $extensions,
            ],
        ]);

        $file = $validated['logo'];

        $response = FileUploader::store($file);

        $path = $response['path'];

        $organizacione->logo = $path;

        $organizacione->save();

        return redirect('/organizaciones')->with('success', 'Logo subido con éxito!');
    }
}
