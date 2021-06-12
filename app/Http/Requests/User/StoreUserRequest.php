<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends BaseRequest
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
        'first_name' => 'required|string|min:3|max:200',
        'last_name' => 'required|string|min:3|max:200',
        'email' => 'required|email|unique:users',
        'password' => 'required|confirmed',
        'image' => 'nullable|image',
        'name' => 'nullable|string|min:3|max:200',
        'phone' => 'required',
        ];
    }
}
