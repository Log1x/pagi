<?php

namespace Log1x\Pagi;

use Roots\Acorn\ServiceProvider;
use Illuminate\Pagination\Paginator;

class PagiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'pagi');

        $this->publishes([
            __DIR__ . '/resources/views' => $this->app->resourcePath('views/components'),
        ], 'pagi');

        Paginator::viewFactoryResolver(function () {
            return $this->app->make('view');
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('pagi', function () {
            return new Pagi();
        });

        return $this->app->make('pagi');
    }
}
