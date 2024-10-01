<?php

use App\Http\Controllers\Export\ExportMunicipioController;
use App\Http\Controllers\Export\ExportParroquiaController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth')->controller(ExportMunicipioController::class)->group(function () {
    Route::get('/exports/municipios/index', 'index')
                ->name('exports.municipios.index');
});

Route::middleware('auth')->controller(ExportParroquiaController::class)->group(function () {

    Route::get('/exports/parroquias/index', 'index')
                ->name('exports.parroquias.index');
});
