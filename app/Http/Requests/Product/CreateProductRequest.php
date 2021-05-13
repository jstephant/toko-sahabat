<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
            'code'          => 'required',
            'name'          => 'required',
            'sub_category'  => 'required',
            'hpp'           => 'nullable',
            'satuan'        => 'required',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'code.required'         => 'Kode barang harus diisi',
            'name.required'         => 'Nama barang harus diisi',
            'sub_category.required' => 'Sub kategori harus diisi',
            'satuan.required'       => 'Satuan harus diisi',
            'product_image.mime'    => 'Tipe image salah',
            'product_image.max'     => 'Ukuran file max: 2MB',
        ];
    }
}
