<?php


namespace Informatics\Order\Requests;

use App\Http\Requests\Request;

class OrderCreateRequest extends Request
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
            'full_name'    => 'required',
            'phone'        => 'required',
            'province'     => 'required',
            'district'     => 'required',
            'village'      => 'required',
            'street'       => 'required',
            'store_name'   => 'required',
            'product_name' => 'required',
            'product_link' => '',
            'quantity'     => 'required',
            'option_1'     => 'required',
            'option_2'     => 'required',
            'promo_code'   => '',
            'transport'    => '',
        ];

        return $rules;
    }

}