<?php

namespace App\Http\Requests\Satuan;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class SatuanRequest extends FormRequest
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
            'code'   => 'required|unique:satuan,code,'.$this->satuan_id,
            'name'   => 'required|unique:satuan,name,'.$this->satuan_id,
            'status' => 'required_if:mode,edit',
        ];
    }

    public function messages()
    {
        return [
            'code.required'   => 'Kode satuan harus diisi',
            'code.unique'     => 'Kode satuan sudah terpakai',
            'name.required'   => 'Nama satuan harus diisi',
            'name.unique'     => 'Nama satuan sudah terpakai',
        ];
    }
}
