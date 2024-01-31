<?php

use App\Exports\CentroElectoralExport;
use App\Exports\MunicipioExport;
use App\Exports\ParroquiaExport;
use App\Exports\PersonaExport;
use App\Http\Resources\MunicipioResource;
use App\Models\Municipio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/municipios', function (Request $request) {

	$filters = $request->all('search','municipio','eje');
    $dataSort = $request->all('orderColumn','orderType');

    return Excel::download(new MunicipioExport($filters,$dataSort,$request->rows), 'municipios.xlsx');
})->name('api.municipios');

Route::get('/get-data-persona/{cedula}', function (Request $request,$cedula) {

    return \App\Models\Persona::with('contacto')->find($cedula)?['status'=>"ok","message"=>\App\Models\Persona::with('contacto')->find($cedula)]:['status'=>"error","message"=>"persona no encontrada"];
        
})->name('data.persona');

Route::get('/parroquias', function (Request $request) {
	
	$filters = $request->all('search','municipio','eje');
    $dataSort = $request->all('orderColumn','orderType');
    
    return Excel::download(new ParroquiaExport($filters,$dataSort,$request->rows), 'parroquias.xlsx');
})->name('api.parroquias');

Route::get('/centros-electorales', function (Request $request) {
	
	$filters = $request->all('search','municipio','eje','parroquia');
    $dataSort = $request->all('orderColumn','orderType');
    
    return Excel::download(new CentroElectoralExport($filters,$dataSort,$request->rows), 'centros-electorales.xlsx');
})->name('api.centros-electorales');

Route::get('/personas', function (Request $request) {
    
    $filters = $request->all('search','municipio','eje','parroquia');
    
    return Excel::download(new PersonaExport($filters,$request->rows), 'personas.xlsx');
})->name('api.personas');
