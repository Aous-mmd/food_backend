<?php

namespace App\Http\Requests\Option;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreOptionRequest extends BaseRequest
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
            'description' => 'nullable|string|min:3|max:2000',
            'image' => 'nullable|image',
            'price' => 'required|numeric|min:0',
            'food_id' => 'required|exists:food,id',
        ];
    }
}
