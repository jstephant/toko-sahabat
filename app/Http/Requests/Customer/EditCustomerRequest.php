<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class EditCustomerRequest extends FormRequest
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
            'name'    => 'required',
            'phone'   => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:8|unique:customers,mobile_phone,'.$this->customer_id,
            'address' => 'nullable',
            'status'  => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required'   => 'Nama customer harus diisi',
            'phone.required'  => 'No. telp harus diisi',
            'phone.regex'     => 'No. telp tidak valid',
            'phone.min'       => 'No. telp minimal 8 karakter',
            'phone.unique'    => 'No. telp sudah terpakai',
            'status.required' => 'Status harus diisi',
        ];
    }
}
