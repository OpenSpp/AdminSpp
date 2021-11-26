<?php

namespace App\Http\Requests\Room;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoomRequest extends FormRequest
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
                'max:100',
                'unique:rooms',
            ],
            'price' => [
                'required',
                'numeric',
                'min:0',
            ],
            're_registration' => [
                'required',
                'numeric',
                'min:0',
            ],
            'description' => [
                'nullable',
                'max:255'
            ],
        ];

        if ($this->getMethod() == 'PUT') {
            $rules['name'] = [
                'required',
                'max:100',
                Rule::unique('rooms')->ignore($this->room),
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
            'name' => 'Nama Kelas',
            'description' => 'Keterangan',
            'price' => 'SPP',
            're_registration' => 'Daftar Ulang',
        ];

        return $attributes;
    }
}
