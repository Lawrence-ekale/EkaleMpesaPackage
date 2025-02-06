<?php

namespace Ekale\LaravelMpesa\Providers;



use Ekale\LaravelMpesa\MpesaService;
use Illuminate\Support\ServiceProvider;

class MpesaServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('mpesa', function () {
            return new MpesaService();
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../config/mpesa.php' => config_path('mpesa.php'),
        ], 'mpesa-config');

        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../../routes/api.php');
    }
}