<?php

namespace App\Providers;

use App\Models\CentroElectoral;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Lorisleiva\Actions\Facades\Actions;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('is_admin', function(User $user) {

            return $user->is_admin;
        });

        if ($this->app->runningInConsole()) {
            Actions::registerCommands('app/Actions/Command');
        }

        //cambiar los parametros del route
        Route::model('centro_electoral', CentroElectoral::class);
        
    }
}
