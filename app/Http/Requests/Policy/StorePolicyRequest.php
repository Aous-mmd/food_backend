<?php

namespace App\Http\Requests\Policy;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class StorePolicyRequest extends BaseRequest
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
            'title' => 'required|string|min:3|max:200',
            'description' => 'nullable|string|min:3|max:2000',
        ];
    }
}
