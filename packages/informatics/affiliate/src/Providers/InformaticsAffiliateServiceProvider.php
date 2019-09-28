<?php

namespace Informatics\Affiliate\Providers;

use Illuminate\Support\ServiceProvider;

class InformaticsAffiliateServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider
     * @author Daidv
     */
    public function register()
    {

    }

    /**
     * Boot the service provider.
     * @author Daidv
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../views', 'affiliate');
    }
}