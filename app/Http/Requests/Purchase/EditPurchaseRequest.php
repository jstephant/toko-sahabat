<?php

namespace App\Http\Requests\Purchase;

use Illuminate\Foundation\Http\FormRequest;

class EditPurchaseRequest extends FormRequest
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
            'purchase_date' => 'required',
            'supplier'      => 'required',
            'products'      => 'required|array|min:1',
            'satuan'        => 'required|array|min:1',
            'qty'           => 'required|array|min:1',
            'price'         => 'required|array|min:1',
        ];
    }

    public function messages()
    {
        return [
            'purchase_date.required' => 'Tgl. Pembelian harus diisi',
            'supplier.required'      => 'Supplier harus diisi',
            'products.required'      => 'Detail pembelian harus diisi minimal 1',
            'satuan.required'        => 'Satuan barang harus diisi',
            'qty.required'           => 'Kuantitas barang harus diisi',
            'price.required'         => 'Harga pembelian barang harus diisi',
        ];
    }
}
