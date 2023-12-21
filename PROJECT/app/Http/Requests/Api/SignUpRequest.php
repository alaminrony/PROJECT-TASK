<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class SignUpRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name'                      => 'required|max:50',
            'email'                     => 'required|max:50|unique:users,email',
            'password'                  => 'required|confirmed|min:6',
        ];
    }

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
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required'                      => ___('validation.name_is_required'),
            'name.max'                           => ___('validation.name_must_be_less_than_255_characters'),
            'email.required'                     => ___('validation.email_is_required'),
            'email.max'                          => ___('validation.email_must_be_less_than_50_characters'),
            'email.unique'                       => ___('validation.email_must_be_unique'),
            'phone.required'                     => ___('validation.phone_is_required'),
            'phone.numeric'                      => ___('validation.phone_number_must_be_number'),
            'phone.unique'                       => ___('validation.phone_must_be_unique'),
            'password.required'                  => ___('validation.password_is_required'),
            'password.min'                       => ___('validation.password_must_be_less_than_or_equal_6_characters'),
        ];
    }
}
