<?php

use Informatics\Category\Models\Category;

/*
* Helper class for Category
*/

class Categories
{
    public static function makeUrl($category)
    {
        return $category->url = "/$category->slug/";
    }

    public static function makeBanner($category)
    {
        if(!is_null($category->thumb)){
            return $category->banner = $category->thumb;
        }
    }

    public static function findCategoryById($id)
    {
        $category = Category::find($id);
        if ($category) {
            self::makeUrl($category);
        }

        return $category;
    }

    public static function getCategoryChildById($id)
    {
        $categories = Category::where('parent_id', $id)->get();
        foreach ($categories as $category) {
            self::makeUrl($category);
        }
        return $categories;
    }

}
