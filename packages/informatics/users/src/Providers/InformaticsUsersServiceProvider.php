<?php


namespace Informatics\Users\Providers;

use Illuminate\Support\ServiceProvider;

class InformaticsUsersServiceProvider extends ServiceProvider
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
        $this->loadViewsFrom(__DIR__ . '/../views', 'users');
    }
}