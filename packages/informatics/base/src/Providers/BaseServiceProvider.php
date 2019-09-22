<?php

namespace Informatics\Base\Providers;

use Illuminate\Support\ServiceProvider;
use Informatics\Admin\Providers\InformaticsAdminServiceProvider;
use Informatics\Agency\Providers\InformaticsAgencyServiceProvider;
use Informatics\Assets\Providers\AssetsServiceProvider;
use Informatics\Auth\Providers\InformaticsAuthServiceProvider;
use Informatics\Log\Providers\InformaticsLogServiceProvider;
use Informatics\Menu\Providers\MenuServiceProvider;
use Informatics\Page\Providers\InformaticsPageServiceProvider;
use Informatics\Users\Providers\InformaticsUsersServiceProvider;
use Informatics\Dashboard\Providers\DashboardServiceProvider;
use Informatics\Category\Providers\InformaticsCategoryServiceProvider;
use Informatics\Account\Providers\InformaticsAccountServiceProvider;
use Blade;
use Informatics\Widget\Providers\InformaticsWidgetServiceProvider;

class BaseServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     * @author Toinn
     */
    public function register()
    {
        $this->app->register(AssetsServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
    }

    /**
     * Boot the service provider.
     * @return void
     * @author Toinn
     */

    public function boot()
    {
        $this->app->register(ComposerServiceProvider::class);
        $this->app->register(InformaticsAuthServiceProvider::class);
        $this->app->register(InformaticsUsersServiceProvider::class);
        $this->app->register(DashboardServiceProvider::class);
        $this->app->register(InformaticsAdminServiceProvider::class);
        $this->app->register(InformaticsAgencyServiceProvider::class);

        $this->loadViewsFrom(__DIR__ . '/../views', 'base');

        Blade::directive('money', function ($amount) {
            return "number_format($amount, 0)";
        });

    }
}
