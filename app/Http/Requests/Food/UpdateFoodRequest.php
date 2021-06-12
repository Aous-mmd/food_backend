<?php

namespace App\Http\Requests\Food;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateFoodRequest extends BaseRequest
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
            'description' => 'nullable|string|min:3|max:2000',
            'category_id' => 'sometimes|required|exists:categories,id',
            'image' => 'nullable|image',
        ];
    }
}
