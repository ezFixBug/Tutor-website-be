<?php

namespace App\Http\Requests;

class RegisterRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'avatar' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'username' => 'required|string',
            'phone_number' => 'required|string',
            'email' => 'required|unique:users|email',
            'password' => 'required|string',
            'cfm_password' => 'required|same:password',
        ];
    }
}
