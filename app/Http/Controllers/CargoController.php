<?php
namespace App\Http\Controllers;

use App\Http\Requests\Cargo\StoreCargoRequest;
use App\Http\Requests\Cargo\UpdateCargoRequest;
use App\Models\Cargo;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CargoController extends Controller implements HasMiddleware
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
        //
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
    public function store(StoreCargoRequest $request)
    {
        $input = $request->validated();

        Cargo::create($input);

        return redirect($input['redirect'])->with('success', 'Cargo Actualizada con éxito!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cargo $cargo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cargo $cargo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCargoRequest $request, Cargo $cargo)
    {
        $input = $request->validated();

        $cargo->update($input);

        return redirect($input['redirect'])->with('success', 'Cargo Actualizado con éxito!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cargo $cargo)
    {
        //
    }
}
