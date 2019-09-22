<?php


namespace App\Http\Controllers\FrontEnd;


use Illuminate\Http\Request;
use Informatics\Account\Models\Account;
use Informatics\Base\Models\Content;
use Informatics\Base\Models\Seo;
use Informatics\Category\Models\Category;
use Informatics\Account\Models\Rank;
use Informatics\Account\Models\AccountStatus;
use View;

class HomeController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * This function is used to display home page.
     *
     * @param void
     * @return view
     * @author Toinn
     */
    public function index(Request $request)
    {
        $segments = $request->segments();
        if (!count($segments)) {
            return view('layout.FrontHome');
        }

        $category = Category::findBySlug($segments[0]);

        if ($category) {
            $this->setUp();
            $type = $category->type;
            view()->share('category', $category);
            if (isset($segments[1])) {

                switch ($type) {
                    case 'account':
                        $account = Account::findByCode(str_replace('.html', '', $segments[1]));
                        if ($account) {
                            view()->share('account', $account);
                            $seo = Seo::find($account->seo_id);
                            $content = Content::getContent($account->content_id);
                            view()->share('content', $content);

                        } else {
                            abort('404');
                        }
                        break;
                    default:
                        return abort(404);
                }
                return view('frontend.' . $type . '-detail');
            } else {
                if ($category) {
                    $seo = Seo::find($category->seo_id);
                    $content = Content::getContent($category->content_id);
                    view()->share('content', $content);
                    return view('frontend.' . $category->type);
                } else {
                    abort(404);
                }
            }

        } else {
            abort('404');
        }
    }

    public function setUp()
    {
        $ranks = (new Rank())->getArrayRank();
        $accountStatus = (new AccountStatus())->getStatusArray();
        View::share('ranks', $ranks);
        View::share('accountStatus', $accountStatus);
    }
}
