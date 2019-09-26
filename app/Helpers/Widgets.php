<?php

namespace App\Helpers;

use Informatics\Widget\Models\Widget;

class Widgets
{
    public static function getWidget($type = ['homepage'], $column = ['*'], $limit = 0)
    {
        $model =(new Widget())->whereIn('type', $type)
            ->whereActive()
            ->sortOrder()
            ->select($column);

        return $limit ? $model->limit($limit)->get() : $model->get();
    }

    public static function getSlider()
    {
        return self::getWidget(['slider']);
    }

    public static function getBanner($limit = 3)
    {
        return self::getWidget(['banner'], ['*'], $limit);
    }

    public static function getAccountWidget()
    {
        return self::getWidget(['account_widget']);
    }

    public static function getSocialWidget()
    {
        return (new Widget())->where('type', 'social')
            ->whereActive()->first();
    }

    public static function getFanpageWidget()
    {
        return (new Widget())->where('type', 'fanpage')
            ->whereActive()->first();
    }

    public static function getSidebarWidget()
    {
        return (new Widget())->where('type', 'sidebar')
            ->whereActive()->first();
    }
}