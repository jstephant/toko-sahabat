<?php

namespace App\Http\Requests\POS;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
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
            'cart_id'        => 'required',
            'customer'       => 'nullable',
            'customer_name'  => 'required_if:customer,null',
            'customer_phone' => 'nullable',
            'notes'          => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'customer_name.required_if'  => 'Nama pelanggan harus diisi',
            'customer_phone.required_if' => 'No. telp pelanggan harus diisi',
        ];
    }
}
