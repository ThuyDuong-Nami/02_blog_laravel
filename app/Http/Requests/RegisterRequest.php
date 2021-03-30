<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'username' => 'required|string|unique:users',
            'password' => 'required|string|min:6',
            'email'    => 'required|string|email:rfc,dns|unique:users',
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'A username is required',
            'password.required' => 'A password is required',
            'email.required'    => 'A email is required',
            'username.unique'   => 'A username is existed',
            'email.unique'      => 'A email is existed',
        ];
    }
}
