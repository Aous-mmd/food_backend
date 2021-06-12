<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends BaseRequest
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
            'first_name' => 'sometimes|required|string|min:3|max:200',
            'last_name' => 'sometimes|required|string|min:3|max:200',
            'email' => 'sometimes|required|email',
            'password' => 'sometimes|required|confirmed',
            'image' => 'nullable|image',
            'name' => 'nullable|string|min:3|max:200',
            'phone' => 'sometimes|required',
        ];
    }
}
