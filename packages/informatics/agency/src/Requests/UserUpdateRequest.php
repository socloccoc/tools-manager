<?php

namespace Informatics\Agency\Requests;

use App\Http\Requests\Request;
use Permission;

class UserUpdateRequest extends Request
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
            'point' => 'numeric|min:0',
        ];
        return $rules;
    }
}