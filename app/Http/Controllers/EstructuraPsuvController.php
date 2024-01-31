<?php

namespace App\Http\Controllers;

use App\Actions\EstructurasPsuv\CreateMiembroEstructura;
use App\Actions\EstructurasPsuv\UpdateMiembroEstructura;
use App\Http\Requests\StoreEstructuraPsuvRequest;
use App\Http\Requests\UpdateEstructuraPsuvRequest;
use App\Models\EstructuraPsuv;

class EstructuraPsuvController extends Controller
{
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
    public function store(StoreEstructuraPsuvRequest $request)
    {
        $data = $request->validated();

        $miembro = CreateMiembroEstructura::run($data);

        return to_route('estructuras.'.$miembro->cargo->nivel->name)->with('success','Miembro Psuv Registrado con Éxito');
    }

    /**
     * Display the specified resource.
     */
    public function show(EstructuraPsuv $estructuras_psuv)
    {
        dd($estructuras_psuv);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EstructuraPsuv $estructuraPsuv)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEstructuraPsuvRequest $request, EstructuraPsuv $estructuras_psuv)
    {
        $data = $request->validated();

        UpdateMiembroEstructura::run($estructuras_psuv,$data);

        return to_route('estructuras.'.$estructuras_psuv->cargo->nivel->name)->with('success','Miembro Psuv Actualizado con Éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EstructuraPsuv $estructuras_psuv)
    {
        $nivel = $estructuras_psuv->cargo->nivel->name;

        $estructuras_psuv->delete();

        return to_route('estructuras.'.$nivel)->with('success','Miembro Psuv Eliminado con Éxito');
    }
}
