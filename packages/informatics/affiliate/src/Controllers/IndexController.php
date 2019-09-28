<?php

namespace Informatics\Affiliate\Controllers;

use App\Http\Controllers\Controller;
use Informatics\Affiliate\Models\Affiliate;
use Informatics\Affiliate\Requests\LinkCreateRequest;
use Informatics\Affiliate\Requests\LinkUpdateRequest;
use Sentinel;
use Illuminate\Http\Request;
use Input;
use Helper;
use Permission;
use Log;
use Redirect;

class IndexController extends Controller
{

    /**
     *  Display a listing of tool
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author Toinn
     */
    public function index()
    {
        $query = app(Affiliate::class)->newQuery();
        $links = $query->get();
        return view('affiliate::index.index', compact('links'));
    }

    /**
     * Show form to add tool
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('affiliate::create.create');
    }

    /**
     * Function to add a new tool into the system
     * @param Request $request
     * @return $this
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(LinkCreateRequest $request)
    {
        try {
            $link = $request->only('url');
            $result = Affiliate::create($link);
            if ($result) {
                return redirect('manager/affiliate')
                    ->with('message', 'Bạn đã thêm thành công !');
            }
        } catch (\Exception $ex) {
            return redirect('manager/affiliate')
                ->with('error_message', $ex->getMessage());
        }
    }

    public function edit($id)
    {
        $currentID = Sentinel::getUser()->id;
        if (Permission::checkRole($currentID, 'super-admin')) {
            $link = Affiliate::where('id', $id)->first();
            return view('affiliate::create.create', compact('link'));
        } else {
            return redirect('manager/affiliate')
                ->with('error_message', 'Either User Not Found or Editing in a wrong role.');
        }
    }

    public function update(LinkUpdateRequest $request, $id)
    {
        try {
            $link = $request->only('url');
            $result = Affiliate::where('id', $id)->limit(1)->update($link);
            if ($result) {
                return Redirect::back()
                    ->withMessage('Cập nhật thông tin thành công');
            }
        } catch (\Exception $ex) {
            return redirect('manager/affiliate')
                ->with('error_message', $ex->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $result = Affiliate::where('id', $id)->delete();
            if ($result) {
                return Redirect::back()
                    ->withMessage('Xóa tool thành công');
            }
        } catch (\Exception $ex) {
            return redirect('manager/affiliate')
                ->with('error_message', $ex->getMessage());
        }
    }

}
