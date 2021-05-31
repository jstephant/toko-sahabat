<?php

namespace App\Http\Requests\user;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'email'    => 'email|nullable|unique:users,email',
            'username' => 'required|unique:users,user_name',
            'password' => 'required|min:5',
            'role'     => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required'     => 'Nama harus diisi',
            'email.email'       => 'Email tidak valid',
            'email.unique'      => 'Email sudah terpakai',
            'username.required' => 'Username harus diisi',
            'username.unique'   => 'Username sudah terpakai',
            'password.required' => 'Password harus diisi',
            'password.min'      => 'Password minimal diisi dengan 5 karakter',
            'role.required'     => 'Role harus diisi'
        ];
    }
}
