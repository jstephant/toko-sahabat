<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class EditProductRequest extends FormRequest
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
            'category'      => 'required',
            'satuan'        => 'present|array',
            'hpp'           => 'nullable',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'active_at'     => 'required',
            'price_list'    => 'present|array',
        ];
    }

    public function messages()
    {
        return [
            'code.required'      => 'Kode barang harus diisi',
            'name.required'      => 'Nama barang harus diisi',
            'category.required'  => 'Kategori harus diisi',
            'satuan.present'     => 'Satuan harus diisi',
            'product_image.mime' => 'Tipe image salah',
            'product_image.max'  => 'Ukuran file max: 2MB',
            'active_at.required' => 'Tanggal berlaku harus diisi',
            'price_list.present' => 'Harga jual barang harus diisi',
        ];
    }
}
