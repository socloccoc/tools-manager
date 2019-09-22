<?php


namespace Informatics\Admin\Requests;

use App\Http\Requests\Request;
use Permission;

class SystemAdminCreateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'username' => 'required|min:5|max:50|unique:users,username',
            'name' => 'required|min:5|max:50',
            'email' => 'required|max:50|unique:users,email',
            'password' => 'required|confirmed|min:6|max:50',
            'password_confirmation' => 'required|min:6',
        ];

        return $rules;
    }

}