<?php

namespace Informatics\Admin\Requests;

use App\Http\Requests\Request;
use Permission;

class SystemAdminUpdateRequest extends Request
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
        // Basic Property Validation
        $rules = [
            'username' => 'required|max:255',
            'name' => 'required|max:255',
            'email' => 'required|max:255',
        ];
        return $rules;
    }
}