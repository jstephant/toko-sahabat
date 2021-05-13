<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
            'name'   => 'required|unique:roles,name,'.$this->role_id,
            'status' => 'required_if:mode,edit',
        ];
    }

    public function messages()
    {
        return [
            'name.required'   => 'Nama role harus diisi',
            'name.unique'     => 'Nama role sudah terpakai',
        ];
    }
}
