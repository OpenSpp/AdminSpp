<?php

namespace App\Http\Requests\Payment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PaymentRegistrasionRequest extends FormRequest
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
            'user_id' => [
                'required',
                'exists:users,id',
                Rule::unique('payments')->where(function ($query) {
                    return $query->where('user_id', $this->user_id)
                            ->where('type', $this->type)
                            ->where('year', $this->year)
                            ->where('month', $this->month);
                })
            ],
            'type' => [
                'required',
                'string',
                'in:daftar-ulang',
            ],
            'year' => [
                'required',
                'numeric',
                'min:' . (((int) date('Y')) - 10 ),
                'max:' . (((int) date('Y')) + 10 ),
            ],
            'month' => [
                'required',
                'numeric',
                'min:1',
                'max:12',
            ],
            'amount' => [
                'required',
                'numeric',
                'min:0',
            ],
        ];

        if ($this->getMethod() == 'PUT') {
            $rules['user_id'] = [
                'required',
                'exists:users,id',
                Rule::unique('payments')->where(function ($query) {
                    return $query->where('user_id', $this->user_id)
                            ->where('type', $this->type)
                            ->where('year', $this->year)
                            ->where('month', $this->month);
                })->ignore($this->registration),
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
            'user_id' => 'Siswa',
            'type' => 'Daftar Ulang',
            'year' => 'Tahun',
            'month' => 'Bulan',
            'amount' => 'Jumlah Pembayaran',
        ];

        return $attributes;
    }

    public function messages()
    {
        return [
            "user_id.unique" => "Daftar Ulang Untuk bulan {$this->month} tahun {$this->year} sudah dibayar" 
        ];
    }
}
