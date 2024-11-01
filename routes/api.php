<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/municipios', [\App\Http\Controllers\ApiController::class, 'municipios'])
    ->name('api.municipios');

Route::get('/parroquias/{municipio}', [\App\Http\Controllers\ApiController::class, 'parroquias'])
    ->name('api.parroquias');
