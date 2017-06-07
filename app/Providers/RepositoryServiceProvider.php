<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Repositories\TituloRepository::class, \App\Repositories\TituloRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\AvisoRepository::class, \App\Repositories\AvisoRepositoryEloquent::class);

        $this->app->bind(\App\Repositories\AvisosRepository::class, \App\Repositories\AvisosRepositoryEloquent::class);
        //:end-bindings:
    }
}
