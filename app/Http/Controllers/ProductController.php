<?php

namespace App\Http\Controllers;

use App\Services\Product\SProduct;
use App\Services\SGlobal;
use App\Services\SubCategory\SSubCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $sGlobal;
    private $sProduct;
    private $sSubCategory;

    public function __construct(SGlobal $sGlobal, SProduct $sProduct, SSubCategory $sSubCategory)
    {
        $this->sGlobal = $sGlobal;
        $this->sProduct = $sProduct;
        $this->sSubCategory = $sSubCategory;
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
        $barcode = $this->sProduct->generateCode('barcode', 8);
        $sub_category = $this->sSubCategory->getActive();
        $data = array(
            'title'        => 'Barang',
            'active_menu'  => 'Barang',
            'edit_mode'    => 1,
            'code'         => $code,
            'barcode'      => $barcode,
            'sub_category' => $sub_category
        );

        return $this->sGlobal->view('product.create', $data);
    }

    public function doCreate(Request $request)
    {
        $code = $request->code;
        $name = $request->name;
        $sub_category = $request->sub_category;
        $hpp = $request->hpp;
        $barcode = $request->barcode;
        // $image_url = $request->image_url;


        $input = array(
            'code'            => $code,
            'name'            => $name,
            'hpp'             => $hpp,
            'barcode'         => $barcode,
        );

        $created = $this->sProduct->create($input);
        if(!$created['status'])
        {
            alert()->error('Error', $created['message']);
            return redirect()->back()->withInput();
        }
        $id = $created['id'];

        $product_sub = $this->sProduct->setSubCategory($id, $sub_category);
        if(!$product_sub)
        {
            alert()->error('Error', $product_sub['message']);
            return redirect()->back()->withInput();
        }

        alert()->success('Success', 'Data updated successfully');
        return redirect()->route('product.index');
    }

    public function edit($id)
    {
        $product = $this->sProduct->findById($id);
        $sub_category = $this->sSubCategory->getActive();
        $data = array(
            'title'       => 'Barang',
            'active_menu' => 'Barang',
            'edit_mode'   => 1,
            'product'     => $product,
            'sub_category' => $sub_category
        );

        return $this->sGlobal->view('product.edit', $data);
    }

    public function doUpdate(Request $request)
    {
        $product_id = $request->product_id;
        $name = $request->name;
        $sub_category = $request->sub_category;
        $hpp = $request->hpp;
        $status = $request->status;
        // $image_url = $request->image_url;


        $input = array(
            'name'       => $name,
            'hpp'        => $hpp,
            'is_active'  => $status,
            'updated_at' => date('Y-m-d H:i:s')
        );

        $updated = $this->sProduct->update($product_id, $input);
        if(!$updated['status'])
        {
            alert()->error('Error', $updated['message']);
            return redirect()->back()->withInput();
        }

        $product_sub = $this->sProduct->setSubCategory($product_id, $sub_category);
        if(!$product_sub)
        {
            alert()->error('Error', $product_sub['message']);
            return redirect()->back()->withInput();
        }

        alert()->success('Success', 'Data updated successfully');
        return redirect()->route('product.index');
    }
}
