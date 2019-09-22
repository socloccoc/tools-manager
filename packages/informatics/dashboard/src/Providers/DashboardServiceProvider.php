<?php


namespace Informatics\Dashboard\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * @author Toinn
 * Class DashboardServiceProvider
 * @package Informatics\Dashboard\Providers
 */
class DashboardServiceProvider extends ServiceProvider
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
        $this->loadViewsFrom(__DIR__ . '/../views', 'dashboard');
    }

}