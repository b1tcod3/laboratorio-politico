<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MunicipioController;
use App\Http\Controllers\ParroquiaController;
use App\Http\Controllers\CentroElectoralController;
use App\Http\Controllers\ResultadosElectoralesController;
use App\Http\Controllers\OrganizacionController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/test', function () {
    return Inertia::render('Test', [
        
    ]);
})->middleware('auth')->name('test');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware('auth')->controller(MunicipioController::class)->group(function () {
    Route::get('/municipios', 'index')
    ->name('municipios.index');
    Route::get('/municipios/{municipio}', 'show')
    ->name('municipios.show');
});

Route::middleware('auth')->controller(ParroquiaController::class)->group(function () {
    Route::get('/parroquias', 'index')
    ->name('parroquias.index');
    Route::get('/parroquias/{parroquia}', 'show')
    ->name('parroquias.show');
});

Route::middleware('auth')->controller(CentroElectoralController::class)->group(function () {
    Route::get('/centros-electorales', 'index')
    ->name('centros-electorales.index');
    Route::get('/centros-electorales/{centro_electoral}', 'show')
    ->name('centros-electorales.show');
});

Route::middleware('auth')->controller(ResultadosElectoralesController::class)->group(function () {
    Route::get('/resultados-electorales', 'index')
    ->name('resultados-electorales.index');
    // Route::get('/resultados-electorales/{centro_electoral}', 'show')
    // ->name('resultados-electorales.show');
});

Route::resources([
    'organizaciones' => OrganizacionController::class,
]);

//misselaneus

Route::post('/logo/{organizacione}', [OrganizacionController::class, 'updateLogo'])
    ->name('logo.upload');

require __DIR__.'/auth.php';
require __DIR__.'/export.php';
