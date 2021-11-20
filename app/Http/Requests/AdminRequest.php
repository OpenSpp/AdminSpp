<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminRequest extends FormRequest
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
     * Get the validation rules that apply to the request.s
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => [
                'required',
                'max:255',
            ],
            'email' => [
                'required',
                'max:255',
                'unique:users',
            ],
            'password' => [
                'required',
                'min:6',
            ],
            'role' => [
                'required',
                'in:admin,super-admin',
            ],
        ];

        if ($this->getMethod() == 'PUT') {
            $rules['email'] = [
                'required',
                Rule::unique('users')->ignore($this->admin),
            ];

            $rules['password'] = [
                'nullable',
            ];
        }

        return $rules;
    }

    /**
    * Get custom attributes for validator errors.
    *
    * @return array
    */
    public function attributes()
    {
        $attributes = [
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
        ];

        return $attributes;
    }
}
