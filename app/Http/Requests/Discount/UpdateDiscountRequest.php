<?php

namespace App\Http\Requests\Discount;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDiscountRequest extends BaseRequest
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
            'day' => 'sometimes|required|in:Saturday,Sunday,Monday,Tuesday,Wednesday,Thursday,Friday',
            'amount' => 'sometimes|required|numeric|min:0',
            'category_id' => 'sometimes|required|exists:categories,id'
        ];
    }
}
