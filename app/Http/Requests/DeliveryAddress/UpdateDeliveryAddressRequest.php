<?php

namespace App\Http\Requests\DeliveryAddress;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDeliveryAddressRequest extends BaseRequest
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
            'name' => 'sometimes|required|string|min:3|max:200',
            'code' => 'sometimes|required',
            'min_delivery' => 'sometimes|required|numeric|min:0',
            'delivery_cost' => 'sometimes|required|numeric|min:0',
        ];
    }
}
