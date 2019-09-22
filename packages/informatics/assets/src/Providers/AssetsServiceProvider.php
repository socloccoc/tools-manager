<?php

namespace Informatics\Assets\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Informatics\Assets\Facades\AssetsFacade;

/**
 * Class AssetsServiceProvider
 * * @author Toinn
 * @package Informatics\Assets\Providers
 */
class AssetsServiceProvider extends ServiceProvider
{
    /**
     * @author Toinn
     */
    public function register()
    {
        AliasLoader::getInstance()->alias('Assets', AssetsFacade::class);
    }

    /**
     * @author Toinn
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/assets.php', 'assets');
        if (app()->runningInConsole()) {
            $this->publishes([__DIR__ . '/../config/assets.php' => config_path('assets.php')], 'config');
        }
    }
}