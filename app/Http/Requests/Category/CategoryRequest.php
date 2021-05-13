<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'name'   => 'required|unique:category,name,'.$this->category_id,
            'status' => 'required_if:mode,edit',
        ];
    }

    public function messages()
    {
        return [
            'name.required'   => 'Nama kategori harus diisi',
            'name.unique'     => 'Nama kategori sudah terpakai',
        ];
    }
}
