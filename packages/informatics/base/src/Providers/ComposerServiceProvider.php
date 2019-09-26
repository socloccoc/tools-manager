<?php


namespace Informatics\Base\Providers;

use Assets;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        view()->composer(['base::layout.master'], function ($view) {

            $headScripts = Assets::getJavascript('top');
            $bodyScripts = Assets::getJavascript('bottom');
            $appModules = Assets::getAppModules();

            $groupedBodyScripts = array_merge($bodyScripts, $appModules);

            $view->with('headScripts', $headScripts);
            $view->with('bodyScripts', $groupedBodyScripts);
            $view->with('stylesheets', Assets::getStylesheets(['core']));
        });
    }
}