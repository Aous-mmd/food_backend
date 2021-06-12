<?php

namespace App\Http\Requests\Restaurant;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRestaurantRequest extends BaseRequest
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
            'address' => 'sometimes|required|string|min:3|max:2000',
            'from_day' => 'sometimes|required|in:Saturday,Sunday,Monday,Tuesday,Wednesday,Thursday,Friday',
            'to_day' => 'sometimes|required|in:Saturday,Sunday,Monday,Tuesday,Wednesday,Thursday,Friday',
            'open_time' => 'sometimes|required',
            'close_time' => 'sometimes|required',
            'phone' => 'sometimes|required',
            'email' => 'sometimes|required|string|min:3|max:200',
            'street' => 'sometimes|required|string|min:3|max:200',
            'build_number' => 'sometimes|required',
            'min_order' => 'sometimes|required|numeric|min:0',
            'image' => 'nullable|image',
            'android_url' => 'sometimes|required|string',
            'iphone_url' => 'sometimes|required|string',
            'owner' => 'sometimes|required|string',
            'facebook' => 'nullable|string',
            'instagram' => 'nullable|string',
            'whatsapp' => 'nullable|string',
            'twitter' => 'nullable|string',
        ];
    }
}
