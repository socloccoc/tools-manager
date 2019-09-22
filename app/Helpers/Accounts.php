<?php


namespace App\Helpers;


use Informatics\Account\Models\Account;
use Informatics\Account\Models\AccountCategory;

class Accounts
{
    public static function makeUrl($accounnt)
    {
        if ($accounnt->category) {
            $accounnt->url = '/' . $accounnt->category->slug . '/' . $accounnt->code . '.html';
        } else {
            $accounnt->url = '/account/' . $accounnt->code . '.html';
        }

        return $accounnt->url;
    }

    public static function getAccountsByCategory($cat_id, $condition = [], $limit = 12)
    {
        $cat_ids = array_merge_recursive([$cat_id], AccountCategory::getAllChildren([$cat_id]));
        if (count($cat_ids)) {
            $accounts = (new Account())->getAccountByCategoryIds($cat_ids, $limit, $condition);
            foreach ($accounts as $account) {
                self::makeUrl($account);
            }
            return $accounts;
        }
        return [];
    }

    public static function getAccountsManySearches($limit = 5)
    {
        $accounts = (new Account())->getInFrontend()->orderBy('view_count', 'desc')->sortOrder()->paginate($limit);
        foreach ($accounts as $account) {
            self::makeUrl($account);
        }
        return $accounts;
    }

    public static function getAccountsRelated($account, $limit = 5)
    {
        $cat_ids = array_merge_recursive([$account->cat_id], AccountCategory::getAllChildren([$account->cat_id]));
        if (count($cat_ids)) {
            $accounts = (new Account())->where('sale_status', 0)->whereIn('cat_id', $cat_ids)->where('id', '<>', $account->id)->inRandomOrder()->paginate($limit);
            foreach ($accounts as $account) {
                self::makeUrl($account);
            }
            return $accounts;
        }
        return [];
    }

    public static function getAccountsLatest($limit = 12)
    {
        $accounts = (new Account())->getInFrontend()->orderBy('published_date', 'desc')->sortOrder()->paginate($limit);
        foreach ($accounts as $account) {
            self::makeUrl($account);
        }
        return $accounts;
    }

    public static function getAccountsSearch($data, $limit = 12)
    {
        $accounts = (new Account())->getInFrontend()->sortOrder();
        if (@$data['keyword']) {
            $accounts = $accounts->where('title', 'like', "%" . $data['keyword'] . "%");
        }
        $accounts = $accounts->paginate($limit);
        foreach ($accounts as $account) {
            self::makeUrl($account);
        }
        return $accounts;
    }

    public static function countAccountByCategory($cat_id)
    {
        $countAccount = (new Account())->where('cat_id', $cat_id)->count();
        return $countAccount;
    }

    public static function countAccountSaleByCategory($cat_id)
    {
        $countAccount = (new Account())->where('cat_id', $cat_id)->where('sale_status', 2)->count();
        return $countAccount;
    }

}
