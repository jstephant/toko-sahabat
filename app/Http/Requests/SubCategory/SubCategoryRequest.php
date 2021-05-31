<?php

namespace App\Http\Requests\SubCategory;

use Illuminate\Foundation\Http\FormRequest;

class SubCategoryRequest extends FormRequest
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
            'sub_name'   => 'required|unique:sub_category,name,'.$this->sub_category_id,
            'category2'  => 'required',
            'sub_status' => 'required_if:sub_mode,edit',
        ];
    }

    public function messages()
    {
        return [
            'sub_name.required'  => 'Nama sub kategori harus diisi',
            'sub_name.unique'    => 'Nama sub kategori sudah terpakai',
            'category2.required' => 'Nama kategori harus diisi',
        ];
    }
}
