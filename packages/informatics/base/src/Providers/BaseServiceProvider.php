<?php

namespace Informatics\Base\Providers;

use Illuminate\Support\ServiceProvider;
use Informatics\Admin\Providers\InformaticsAdminServiceProvider;
use Informatics\Affiliate\Providers\InformaticsAffiliateServiceProvider;
use Informatics\Agency\Providers\InformaticsAgencyServiceProvider;
use Informatics\Analytics\Providers\InformaticsAnalyticsServiceProvider;
use Informatics\Assets\Providers\AssetsServiceProvider;
use Informatics\Auth\Providers\InformaticsAuthServiceProvider;
use Informatics\Key\Providers\InformaticsKeyServiceProvider;
use Informatics\Users\Providers\InformaticsUsersServiceProvider;
use Informatics\Dashboard\Providers\DashboardServiceProvider;
use Informatics\Tool\Providers\InformaticsToolServiceProvider;
use Blade;

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
        $this->app->register(InformaticsToolServiceProvider::class);
        $this->app->register(InformaticsKeyServiceProvider::class);
        $this->app->register(InformaticsAnalyticsServiceProvider::class);
        $this->app->register(InformaticsAffiliateServiceProvider::class);


        $this->loadViewsFrom(__DIR__ . '/../views', 'base');

        Blade::directive('money', function ($amount) {
            return "number_format($amount, 0)";
        });

    }
}
