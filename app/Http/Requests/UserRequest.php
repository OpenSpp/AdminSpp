<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            'nisn' => [
                'required',
                'max:50',
                'unique:students',
            ],
            'nis' => [
                'required',
                'max:50',
                'unique:students',
            ],
            'room_id' => [
                'required',
                'exists:rooms,id',
            ],
            'address' => [
                'nullable',
                'max:255',
            ],
            'phone' => [
                'nullable',
                'max:20',
            ],
        ];

        if ($this->getMethod() == 'PUT') {
            $rules['email'] = [
                'required',
                Rule::unique('users')->ignore($this->user),
            ];

            $rules['nisn'] = [
                'required',
                Rule::unique('students')->ignore($this->user->student),
            ];

            $rules['nis'] = [
                'required',
                Rule::unique('students')->ignore($this->user->student),
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
            'name' => 'Nama Siswa',
            'email' => 'Email',
            'password' => 'Password',
            'nisn' => 'NISN',
            'nis' => 'NIS',
            'address' => 'Alamat',
            'phone' => 'No Telfon',
        ];

        return $attributes;
    }
}
