<?php


namespace Informatics\Order\Requests;

use App\Http\Requests\Request;
use Permission;

class KeyCreateRequest extends Request
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
            'fullname' => 'required',
            'user_id' => 'required',
            'point_order' => 'required|integer',
            'number' => 'required|integer|max:1000',
            'expire_time' => 'required|integer|max:1000',
        ];

        return $rules;
    }

}