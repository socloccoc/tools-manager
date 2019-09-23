<?php

namespace Informatics\Agency\Providers;

use Illuminate\Support\ServiceProvider;

class InformaticsAgencyServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider
     * @author Toinn
     */
    public function register()
    {

    }

    /**
     * Boot the service provider.
     * @author Toinn
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../views', 'agency');
    }
}