<?php

namespace App\Helpers;

use Informatics\Account\Models\Account;
use Informatics\Account\Models\AccountCategory;
use Informatics\Users\Models\User;
use Sentinel;
use Helper;
use URL;
use Route;
use Permission;

class MenuItemHelper
{
    /**
     * Function to get menu items
     *
     * @return type Array
     * @author Toinn
     */
    public static function getMenu()
    {
        $roles = Helper::getCurrentUserRole();
        $menuNavigationItems = config('menuitems.' . $roles[0]['slug']);
        return self::getMenuView($menuNavigationItems);
    }

    /**
     * Function to get menu view for dashboard
     *
     * @author Toinn
     */
    public static function getMenuView($menuNavigationItems)
    {
        $badge_key_array = array();
        $badget_key_value = array();

        if (Permission::isSuperAdmin() || Permission::isSystemAdmin()) {
            $badge_key_array = ['Danh sách tài khoản', 'Danh mục tài khoản', 'Danh sách người dùng', 'Danh sách admin'];
//            $badget_key_value['Danh sách tài khoản'] = (new Account())->count(); // call repository get count
//            $badget_key_value['Danh mục tài khoản'] = (new AccountCategory())->count(); // call repository get count
//            $badget_key_value['Danh sách người dùng'] = (new User())->count(); // call repository get count
//            $badget_key_value['Danh sách admin'] = 3; // call repository get count
        }
        $route_current = Route::currentRouteName();

        $menu = '';
        $icons = config('menuitems.Icons');
        if (is_array($menuNavigationItems) && count($menuNavigationItems) > 0) {
            foreach ($menuNavigationItems as $key => $value) {
                if (is_array($value)) {
                    $menu .= '<li class="sm-sub ' . (in_array($route_current, array_values($value)) ? 'active' : '') . '">'
                        . '<a href="javascript:void(0)">'
                        . (isset($icons[$key]) ? $icons[$key] : '')
                        . '<span class="menu-title">' . $key . '</span>' . (isset($key) && count($badge_key_array) && in_array($key, $badge_key_array) && is_array($badget_key_value) && isset($badget_key_value[$key]) && $badget_key_value[$key] > 0 ? '<span class="label label-danger">' . (!empty($badget_key_value[$key]) ? $badget_key_value[$key] : '0') . '</span>' : '')
                        . '</a>'
                        . '<ul>'
                        . self::getMenuView($value)
                        . '</ul>'
                        . '</li>';
                } else {
                    $menu .= '<li class="' . ($route_current == $value ? 'active' : '') . '">'
                        . '<a class="' . ($route_current == $value ? 'active_a_tree ' : '') . (isset($icons[$key]) ? 'treeview_a ' : '') . $key . '" href="' . (Route::has($value) ? URL::route($value) : URL::to('login')) . '">'
                        . (isset($icons[$key]) ? $icons[$key] : '')
                        . '<span class="menu-title">' . $key . '</span>' . (isset($key) && count($badge_key_array) && in_array($key, $badge_key_array) && is_array($badget_key_value) && isset($badget_key_value[$key]) && $badget_key_value[$key] > 0 ? '<span class="label label-danger">' . (!empty($badget_key_value[$key]) ? $badget_key_value[$key] : '0') . '</span>' : '')
                        . '</a>'
                        . '</li>';
                }
            }
        }
        return $menu;
    }

}
