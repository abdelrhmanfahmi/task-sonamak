<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => 'min:2|max:50|string',
            'email' => 'email|min:3|max:50|unique:users,email,'.$this->user,
            'password' => 'min:8|max:20|confirmed',
            'role' => 'string|exists:roles,name'
        ];
    }
}
