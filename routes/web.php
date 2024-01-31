<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


//MUNICIPIOS
Route::get('municipios', [\App\Http\Controllers\MunicipioController::class, 'index'])
    ->name('municipios.index')
    ->middleware('auth');
Route::get('municipios/{municipio}', [\App\Http\Controllers\MunicipioController::class, 'show'])
    ->name('municipios.show')
    ->middleware('auth');

Route::get('parroquias', [\App\Http\Controllers\ParroquiaController::class, 'index'])
    ->name('parroquias.index')
    ->middleware('auth');

Route::get('centros-electorales', [\App\Http\Controllers\CentroElectoralController::class, 'index'])
    ->name('centros-electorales.index')
    ->middleware('auth');

Route::get('personas', [\App\Http\Controllers\PersonaController::class, 'index'])
    ->name('personas.index')
    ->middleware('auth');

//BUSQUEDA

Route::get('buscar/persona', [\App\Http\Controllers\PersonaController::class, 'buscar'])
    ->name('buscar.persona')
    ->middleware('auth');

Route::get('resumen', [\App\Http\Controllers\ResumenController::class, 'index'])
    ->name('resumen.index')
    ->middleware('auth');


//testing
//
Route::get('/test', function () {
    
    dd(\App\Models\Persona::find(15190934)->miembroPsuv->cargo->nivel->name);
});

//Estructuras CRUD

Route::get('estructuras/EPR', [\App\Http\Controllers\EstructuraController::class, 'EPR'])
    ->name('estructuras.EPR')
    ->middleware('auth');

Route::get('estructuras/EPM', [\App\Http\Controllers\EstructuraController::class, 'EPM'])
    ->name('estructuras.EPM')
    ->middleware('auth');

Route::get('estructuras/EPP', [\App\Http\Controllers\EstructuraController::class, 'EPP'])
    ->name('estructuras.EPP')
    ->middleware('auth');
    
Route::get('estructuras/UBCH', [\App\Http\Controllers\EstructuraController::class, 'UBCH'])
    ->name('estructuras.UBCH')
    ->middleware('auth');

Route::get('estructuras/COMUNIDAD', [\App\Http\Controllers\EstructuraController::class, 'COMUNIDAD'])
    ->name('estructuras.COMUNIDAD')
    ->middleware('auth');

Route::get('estructuras/CALLE', [\App\Http\Controllers\EstructuraController::class, 'CALLE'])
    ->name('estructuras.CALLE')
    ->middleware('auth');


//CRUDS
//
Route::apiResources([
    'estructuras_psuv' => \App\Http\Controllers\EstructuraPsuvController::class,
    'comunidades' => \App\Http\Controllers\ComunidadController::class,
    'calles' => \App\Http\Controllers\CalleController::class,
    'votos_calle' => \App\Http\Controllers\VotoCalleController::class,
]);