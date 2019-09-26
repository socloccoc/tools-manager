<?php

namespace Informatics\Tool\Controllers;

use App\Http\Controllers\Controller;
use Informatics\Tool\Requests\ToolCreateRequest;
use Informatics\Tool\Models\Tool;
use Informatics\Tool\Requests\ToolUpdateRequest;
use Informatics\Users\Repositories\Db\DbUsersRepository as UserRepo;
use Sentinel;
use Illuminate\Http\Request;
use Input;
use Helper;
use Permission;
use Log;
use Redirect;

class IndexController extends Controller
{
    const ADD_ACCOUNT_SUCCESS_MSG = 'Thêm tài khoản thành công !';

    /**
     *  Display a listing of Admin
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author Toinn
     */
    public function index()
    {
        $keyword = Input::get('keyword');

        // array to show selected values for search conditions
        $filters = array(
            'Keyword' => trim($keyword),
        );

        $sortInfo = array();
        if (Input::has('sort') && Input::has('dir')) {
            $sortInfo['column'] = Input::get('sort');
            $sortInfo['order'] = Input::get('dir');
        }

        $query = app(Tool::class)->newQuery();
        $pagination = $query->paginate('15')->render();
        $tools = $query->get();
        //Getting list of sortable columns
        $columns = $this->getSortableColumn();

        return view('tool::index.index', compact('tools', 'columns', 'pagination', 'filters'));

    }

    public function getSortableColumn()
    {
        $columns = array(
            'tool.name' => 'Name',
        );
        return Helper::getSortableColumnOnArray($columns);
    }

    /**
     * Show form to add tool
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('tool::create.create');
    }

    /**
     * Function to add a new tool into the system
     * @param Request $request
     * @return $this
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(ToolCreateRequest $request)
    {
        try {
            $newTool = $request->only('name', 'max_point', 'fee');
            $tool = Tool::create($newTool);
            if ($tool) {
                return redirect('manager/tool')
                    ->with('message', 'Bạn đã thêm thành công !');
            }
        } catch (\Exception $ex) {
            return redirect('manager/tool')
                ->with('error_message', $ex->getMessage());
        }
    }

    public function edit($id)
    {
        $currentID = Sentinel::getUser()->id;
        if (Permission::checkRole($currentID, 'super-admin')) {
            $tool = Tool::where('id', $id)->first();
            return view('tool::create.create', compact('tool'));
        } else {
            return redirect('manager/tool')
                ->with('error_message', 'Either User Not Found or Editing in a wrong role.');
        }
    }

    public function update(ToolUpdateRequest $request, $id)
    {
        try {
            $tool = $request->only('name', 'max_point', 'fee');
            $tool = Tool::where('id', $id)->limit(1)->update($tool);
            if ($tool) {
                return Redirect::back()
                    ->withMessage('Cập nhật thông tin thành công');
            }
        } catch (\Exception $ex) {
            return redirect('manager/tool')
                ->with('error_message', $ex->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $tool = Tool::where('id', $id)->delete();
            if ($tool) {
                return Redirect::back()
                    ->withMessage('Xóa tool thành công');
            }
        } catch (\Exception $ex) {
            return redirect('manager/tool')
                ->with('error_message', $ex->getMessage());
        }
    }

}
