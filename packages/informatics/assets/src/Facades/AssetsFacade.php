<?php

namespace Informatics\Assets\Facades;

use Illuminate\Support\Facades\Facade;
use Informatics\Assets\Assets;

/**
 * Class AssetsFacade
 *  @author Toinn
 * @package Informatics\Assets\Facades
 */
class AssetsFacade extends Facade
{

    /**
     * @return string
     * @author Toinn
     */
    protected static function getFacadeAccessor()
    {
        return Assets::class;
    }
}
