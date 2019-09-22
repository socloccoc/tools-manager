<?php

namespace Informatics\Assets;

class Assets
{
    /**
     * @var array
     */
    protected $javascript = [];
    /**
     * @var array
     */
    protected $stylesheets = [];
    /**
     * @var array
     */
    protected $appModules = [];
    /**
     * @var mixed
     */
    protected $build;

    /**
     * @var array
     */
    protected $appendedJs = [
        'top' => [],
        'bottom' => [],
    ];

    /**
     * @var array
     */
    protected $appendedCss = [];

    /**
     * Assets constructor.
     * @author Toinn
     */
    public function __construct()
    {
        $this->javascript = config('assets.javascript');
        $this->stylesheets = config('assets.stylesheets');

        $this->build = time();
    }

    /**
     * Add Javascript to current module
     *
     * @param array $assets
     * @return $this
     * @author Toinn
     */
    public function addJavascript($assets)
    {
        if (!is_array($assets)) {
            $assets = [$assets];
        }
        $this->javascript = array_merge($this->javascript, $assets);
        return $this;
    }

    /**
     * Add Css to current module
     *
     * @param array $assets
     * @return $this
     * @author Toinn
     */
    public function addStylesheets($assets)
    {
        if (!is_array($assets)) {
            $assets = [$assets];
        }
        $this->stylesheets = array_merge($this->stylesheets, $assets);
        return $this;
    }

    /**
     * Add Module to current module
     *
     * @param array $modules
     * @return $this;
     * @author Toinn
     */
    public function addAppModule($modules)
    {
        if (!is_array($modules)) {
            $modules = [$modules];
        }
        $this->appModules = array_merge($this->appModules, $modules);
        return $this;
    }

    /**
     * Remove Css to current module
     *
     * @param array $assets
     * @return $this;
     * @author Toinn
     */
    public function removeStylesheets($assets)
    {
        if (!is_array($assets)) {
            $assets = [$assets];
        }
        foreach ($assets as $rem) {
            unset($this->stylesheets[array_search($rem, $this->stylesheets)]);
        }
        return $this;
    }

    /**
     * Add Javascript to current module
     *
     * @param array $assets
     * @return $this;
     * @author Toinn
     */
    public function removeJavascript($assets)
    {
        if (!is_array($assets)) {
            $assets = [$assets];
        }
        foreach ($assets as $rem) {
            unset($this->javascript[array_search($rem, $this->javascript)]);
        }
        return $this;
    }

    /**
     * Get All Javascript in current module
     *
     * @param string $location : top or bottom
     * @param boolean $version : show version?
     * @return array
     * @author Toinn
     */
    public function getJavascript($location = null, $version = true)
    {
        $scripts = [];
        if (!empty($this->javascript)) {
            // get the final scripts need for page
            $this->javascript = array_unique($this->javascript);
            foreach ($this->javascript as $js) {
                $jsConfig = 'assets.resources.javascript.' . $js;

                if (config()->has($jsConfig)) {
                    if ($location != null && config($jsConfig . '.location') !== $location) {
                        // Skip assets that don't match this location
                        continue;
                    }

                    $src = config($jsConfig . '.src.local');
                    $cdn = false;
                    if (config($jsConfig . '.use_cdn') && !config('assets.offline')) {
                        $src = config($jsConfig . '.src.cdn');
                        $cdn = true;
                    }

                    if (config($jsConfig . '.include_style')) {
                        $this->addStylesheets([$js]);
                    }

                    $version = $version ? '?ver=' . $this->build : '';
                    if (!is_array($src)) {
                        $scripts[] = $src . $version;
                    } else {
                        foreach ($src as $s) {
                            $scripts[] = $s . $version;
                        }
                    }

                    if (empty($src) && $cdn && $location === 'top' && config()->has($jsConfig . '.fallback')) {
                        // Fallback to local script if CDN fails
                        $fallback = config($jsConfig . '.fallback');
                        $scripts[] = [
                            'url' => $src,
                            'fallback' => $fallback,
                            'fallbackURL' => config($jsConfig . '.src.local'),
                        ];
                    }
                }
            }
        }

        if (isset($this->appendedJs[$location])) {
            $scripts = array_merge($scripts, $this->appendedJs[$location]);
        }

        return $scripts;
    }

    /**
     * Get All CSS in current module
     *
     * @param array $lastModules : append last CSS to current module
     * @param boolean $version : show version?
     * @return array
     * @author Toinn
     */
    public function getStylesheets($lastModules = [], $version = true)
    {
        $stylesheets = [];
        if (!empty($this->stylesheets)) {
            if (!empty($lastModules)) {
                $this->stylesheets = array_merge($this->stylesheets, $lastModules);
            }
            // get the final scripts need for page
            $this->stylesheets = array_unique($this->stylesheets);
            foreach ($this->stylesheets as $style) {
                if (config()->has('assets.resources.stylesheets.' . $style)) {

                    $src = config('assets.resources.stylesheets.' . $style . '.src.local');
                    if (config('assets.resources.stylesheets.' . $style . '.use_cdn') && !config('assets.offline')) {
                        $src = config('assets.resources.stylesheets.' . $style . '.src.cdn');
                    }

                    if (!is_array($src)) {
                        $src = [$src];
                    }
                    foreach ($src as $s) {
                        $stylesheets[] = $s . ($version ? '?ver=' . $this->build : '');
                    }
                }
            }
        }

        $stylesheets = array_merge($stylesheets, $this->appendedCss);


        return $stylesheets;
    }

    /**
     * Get all modules in current module
     * @param boolean $version : show version?
     * @return array
     * @author Toinn
     */
    public function getAppModules($version = true)
    {
        $modules = [];
        if (!empty($this->appModules)) {
            // get the final scripts need for page
            $this->appModules = array_unique($this->appModules);
            foreach ($this->appModules as $module) {
                if (($module = $this->getModule($module, $version)) !== null) {
                    $modules[] = $module;
                }
            }
        }

        return $modules;
    }

    /**
     * Get a modules
     * @param string $module : module's name
     * @param boolean $version : show version?
     * @return string
     */
    protected function getModule($module, $version)
    {
        $pathPrefix = public_path() . '/vendor/core/js/app_modules/' . $module;

        $file = null;

        if (file_exists($pathPrefix . '.min.js')) {
            $file = $module . '.min.js';
        } elseif (file_exists($pathPrefix . '.js')) {
            $file = $module . '.js';
        }

        if ($file) {
            return '/vendor/core/js/app_modules/' . $file . ($version ? '?ver=' . $this->build : '');
        }
        return null;
    }

}