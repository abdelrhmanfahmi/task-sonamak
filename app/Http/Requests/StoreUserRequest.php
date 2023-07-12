<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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

    public function rules()
    {
        return [
            'name' => 'required|min:2|max:50|string',
            'email' => 'required|email|min:3|max:50|unique:users,email',
            'password' => 'required|min:8|max:20|confirmed',
            'role' => 'required|string|exists:roles,name'
        ];
    }
}
