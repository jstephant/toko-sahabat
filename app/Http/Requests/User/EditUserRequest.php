<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class EditUserRequest extends FormRequest
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
            'name'     => 'required',
            'email'    => 'email|nullable|unique:users,email,'.$this->user_id,
            'role'     => 'required',
            'status'   => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required'   => 'Nama harus diisi',
            'email.email'     => 'Email tidak valid',
            'email.unique'    => 'Email sudah terpakai',
            'role.required'   => 'Role harus diisi',
            'status.required' => 'Status harus diisi'
        ];
    }
}
