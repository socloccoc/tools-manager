<?php

use Informatics\Category\Models\Category;
use Informatics\Page\Models\Page;

class Pages
{

    public static function urlPage($page)
    {
        try {
            return '/' . $page->slug . '/';
        } catch (Exception $e) {
            return route('error.404');
        }
    }
}
