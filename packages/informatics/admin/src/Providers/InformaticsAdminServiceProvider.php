<?php

namespace Informatics\Admin\Providers;

use Illuminate\Support\ServiceProvider;

class InformaticsAdminServiceProvider extends ServiceProvider
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
        $this->loadViewsFrom(__DIR__ . '/../views', 'admin');
    }
}