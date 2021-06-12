<?php

namespace App\Http\Requests\DeliveryAddress;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreDeliveryAddressRequest extends BaseRequest
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
        return [
            'name' => 'required|string|min:3|max:200',
            'code' => 'required',
            'min_delivery' => 'required|numeric|min:0',
            'delivery_cost' => 'required|numeric|min:0',
        ];
    }
}
