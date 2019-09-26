<?php

/*
* Helper class for Menu
*/

use Informatics\Menu\Models\Menu;

class Menus
{
    public static function makeMenu($item)
    {
        try {
            switch ($item['type']) {
                case 'homepage':
                    $item->url = route('home');
                    break;
                case 'charge-card':
                    $item->url = route('charge.card');
                    break;
                case 'user-history':
                    $item->url = route('user.profile');
                    break;
                case 'page':
                    $item->url = Categories::makeUrl($item->category);
                    $item->banner = Categories::makeBanner($item->category);
                    break;
                case 'link':
                    $item->url = $item->link;
                    break;
            }
        } catch (\Exception $e) {
            $item->url = route('error.404');
        }

    }

    /*Lấy danh sách menu*/
    public static function getMenus($position = 'primary')
    {
        $menus = Menu::with('category')->where('position', $position)->orderBy('sort_order')->get();

        foreach ($menus as $item) {
            self::makeMenu($item);
        }
        return $menus;
    }

}
