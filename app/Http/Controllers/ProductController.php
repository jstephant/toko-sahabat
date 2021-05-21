<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\EditProductRequest;
use App\Services\PriceList\SPriceList;
use App\Services\Product\SProduct;
use App\Services\Satuan\SSatuan;
use App\Services\SGlobal;
use App\Services\SubCategory\SSubCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $sGlobal;
    private $sProduct;
    private $sSubCategory;
    private $sSatuan;
    private $sPriceList;

    public function __construct(
        SGlobal $sGlobal,
        SProduct $sProduct,
        SSubCategory $sSubCategory,
        SSatuan $sSatuan,
        SPriceList $sPriceList
    )
    {
        $this->sGlobal = $sGlobal;
        $this->sProduct = $sProduct;
        $this->sSubCategory = $sSubCategory;
        $this->sSatuan = $sSatuan;
        $this->sPriceList = $sPriceList;
    }

    public function index()
    {
        $data = array(
            'title'       => 'Barang',
            'active_menu' => 'Barang',
            'edit_mode'   => 0
        );

        return $this->sGlobal->view('product.index', $data);
    }

    public function listProduct(Request $request)
    {
        $products = $this->sProduct->listProduct($request->keyword, $request->start, $request->length, $request->order);
        $products['draw'] = $request->draw;
        return $products;
    }

    public function create()
    {
        $code = $this->sProduct->generateCode('code', 8);
        $sub_category = $this->sSubCategory->getActive();
        $satuan = $this->sSatuan->getActive();
        $data = array(
            'title'        => 'Barang',
            'active_menu'  => 'Barang',
            'edit_mode'    => 1,
            'code'         => $code,
            'sub_category' => $sub_category,
            'satuan'       => $satuan,
        );

        return $this->sGlobal->view('product.create', $data);
    }

    public function doCreate(CreateProductRequest $request)
    {
        $validated = $request->validated();

        $code = $request->code;
        $name = $request->name;
        $sub_category = $request->sub_category;
        $hpp = $request->hpp;
        $barcode = $request->barcode;
        $satuan = $request->satuan;
        $active_at = $request->active_at;
        $price_list = $request->price_list;
        $created_by = $request->session()->get('id');

        $image_name = null;
        if ($request->hasFile('product_image'))
        {
            $image_name = $this->sGlobal->uploadImage($request->file('product_image'), 'product');
        }

        $input = array(
            'code'            => $code,
            'name'            => $name,
            'sub_category_id' => $sub_category,
            'hpp'             => $hpp,
            'barcode'         => $barcode,
            'image_name'      => $image_name,
            'created_by'      => $created_by
        );

        $created = $this->sProduct->create($input);
        if(!$created['status'])
        {
            return redirect()->back()->with('error', $created['message']);
        }
        $id = $created['id'];

        $product_satuan = $this->sProduct->setProductSatuan($id, $satuan);
        if(!$product_satuan['status'])
        {
            return redirect()->back()->with('error', $product_satuan['message']);
        }

        foreach ($satuan as $key => $value) {
            $input_price_list = array(
                'product_id' => $id,
                'satuan_id'  => $value,
                'price'      => $price_list[$key],
                'active_at'  => $active_at,
                'created_by' => $created_by,
            );
            $created_price_list = $this->sPriceList->create($input_price_list);
        }

        return redirect()->route('product.index')->with('success', 'Data berhasil dibuat');
    }

    public function edit($id)
    {
        $product = $this->sProduct->findById($id);
        $sub_category = $this->sSubCategory->getActive();
        $satuan = $this->sSatuan->getActive();
        $data = array(
            'title'        => 'Barang',
            'active_menu'  => 'Barang',
            'edit_mode'    => 1,
            'product'      => $product,
            'sub_category' => $sub_category,
            'satuan'       => $satuan,
        );

        return $this->sGlobal->view('product.edit', $data);
    }

    public function doUpdate(EditProductRequest $request)
    {
        $validated = $request->validated();

        $product_id = $request->product_id;
        $name = $request->name;
        $sub_category = $request->sub_category;
        $hpp = $request->hpp;
        $satuan = $request->satuan;
        $status = $request->status;
        $image_name = $request->image_name;
        $updated_by = $request->session()->get('id');

        if ($request->hasFile('product_image'))
        {
            $image_name = $this->sGlobal->uploadImage($request->file('product_image'), 'product');
        }

        $input = array(
            'name'            => $name,
            'sub_category_id' => $sub_category,
            'hpp'             => $hpp,
            'is_active'       => $status,
            'image_name'      => $image_name,
            'updated_by'      => $updated_by,
            'updated_at'      => date('Y-m-d H:i:s')
        );

        $updated = $this->sProduct->update($product_id, $input);
        if(!$updated['status'])
        {
            return redirect()->back()->with('error', $updated['message']);
        }

        $product_satuan = $this->sProduct->setProductSatuan($product_id, $satuan);
        if(!$product_satuan['status'])
        {
            return redirect()->back()->with('error', $product_satuan['message']);
        }

        return redirect()->route('product.index')->with('success', 'Data berhasil diupdate');
    }

    public function listActive(Request $request)
    {
        return $this->sProduct->getActive($request->keyword);
    }

    public function findById($id)
    {
        return $this->sProduct->findById($id);
    }

    public function doDelete($id)
    {
        $deleted = $this->sProduct->delete($id);
        if(!$deleted['status'])
        {
            return redirect()->back()->with('error', $deleted['message']);
        }
        return redirect()->route('product.index')->with('success', 'Data berhasil dihapus');
    }
}
