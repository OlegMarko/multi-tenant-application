<?php

namespace App\Providers;

use Illuminate\Config\Repository;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\ServiceProvider;

class VentureServiceProvider extends ServiceProvider
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
     * Register venture specific services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * Create db and config instance for each venture.
         */
        foreach ($this->app['venture']->getAllVentures() as $venture) {

            // Venture specific configs.
            $this->app->singleton('config.' . $venture, function ($app) use ($venture) {
                $config = new Repository($app['config']->all());

                $app['venture']->loadVentureConfigs($venture, $config);

                return $config;
            });
        }

    }
}
