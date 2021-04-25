<?php

namespace App\Services\Product;

use App\Models\Product;
use App\Models\ProductSubCategory;
use App\Services\Product\IProduct;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class SProduct implements IProduct
{
    private $product;
    private $productSubCategory;

    public function __construct(Product $product, ProductSubCategory $productSubCategory)
    {
        $this->product = $product;
        $this->productSubCategory = $productSubCategory;
    }

    public function create($input)
    {
        $data = array(
            'status'  => false,
            'message' => '',
            'id'      => null,
        );

        try {
            DB::beginTransaction();
            $product = Product::create($input);
            DB::commit();
            $data['status'] = true;
            $data['message'] = 'OK';
            $data['id'] = $product->id;
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $data['message'] = $e->getMessage();
        }

        return $data;
    }

    public function update($id, $input)
    {
        $data = array(
            'status'  => false,
            'message' => ''
        );

        try {
            DB::beginTransaction();
            $product = Product::where('id', $id)->update($input);
            DB::commit();
            $data['status'] = true;
            $data['message'] = 'OK';
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $data['message'] = $e->getMessage();
        }

        return $data;
    }

    public function delete($id)
    {
        $data = array(
            'status'  => false,
            'message' => ''
        );

        try {
            DB::beginTransaction();
            $product = Product::where('id', $id)->first();
            $product->is_active = 0;
            $product->save();
            DB::commit();
            $data['status'] = true;
            $data['message'] = 'OK';
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $data['message'] = $e->getMessage();
        }

        return $data;
    }

    public function findById($id)
    {
        return $this->product->with(['product_sub_category', 'product_sub_category.sub_category.category'])->where('id', $id)->first();
    }

    public function getActive($keyword=null)
    {
        $products = $this->product->with(['product_sub_category', 'product_sub_category.sub_category.category']);
        if($keyword)
        {
            $products = $products->where('code', 'like', '%'.$keyword.'%')
                                 ->orwhere('name', 'like', '%'.$keyword.'%')
                                 ->orwhere('barcode', 'like', '%'.$keyword.'%');
        }
        $products = $products->get();
        return $products;
    }

    public function listProduct($keyword, $start, $length, $order)
    {
        $products = $this->product->with(['product_sub_category.sub_category.category']);

        if($keyword)
        {
            $products = $products->where('code', 'like', '%'.$keyword.'%')
                                 ->orwhere('name', 'like', '%'.$keyword.'%')
                                 ->orwhere('barcode', 'like', '%'.$keyword.'%')
                                 ->orWhereHas('sub_category', function($q) use($keyword){ $q->where('name', 'like', ''.$keyword.''); });
        }

        $count = $products->count();

        if($length!=-1) {
            $products = $products->offset($start)->limit($length);
        }

        $products = $products->get();

        $data = [
            'recordsTotal'    => $count,
            'recordsFiltered' => $count,
            'data'	          => $products->toArray(),
        ];

        return $data;
    }

    public function generateCode($type, $length = 4)
    {
        $characters = '1234567890';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        if($type == 'code')
            $check = $this->product->where('code', $randomString)->first();
        else if($type == 'barcode')
            $check = $this->product->where('barcode', $randomString)->first();

        if((isset($check->id) && $check->id != null) || strlen(intval($randomString))<$length){
            $randomString = $this->generateCode($type, $length);
        }

        return $randomString;
    }

    public function createSubCategory($input)
    {
        $data = array(
            'status'  => false,
            'message' => ''
        );

        try {
            DB::beginTransaction();
            $product = ProductSubCategory::create($input);
            DB::commit();
            $data['status'] = true;
            $data['message'] = 'OK';
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $data['message'] = $e->getMessage();
        }

        return $data;
    }

    public function deleteSubCategory($product_id, $sub_category_id)
    {
        $data = array(
            'status'  => false,
            'message' => ''
        );

        try {
            DB::beginTransaction();
            $product = ProductSubCategory::where('product_id', $product_id)->where('sub_category_id', $sub_category_id)->first();
            $product->delete();
            DB::commit();
            $data['status'] = true;
            $data['message'] = 'OK';
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $data['message'] = $e->getMessage();
        }

        return $data;
    }

    public function setSubCategory($product_id, $sub_categories)
    {
        $status = array();
        $type = array();
        $message = array();

        foreach ($sub_categories as $value) {
            $sub_category = $this->productSubCategory->where('product_id', $product_id)->where('sub_category_id', $value)->first();
            if($sub_category)
            {
                $deleted = $this->deleteSubCategory($product_id, $value);
                array_push($status, $deleted['status']);
                array_push($type, 'deleted');
                array_push($message, $deleted['message']);
            }

            $input = array('product_id' => $product_id, 'sub_category_id' => $value);
            $created = $this->createSubCategory($input);
            array_push($status, $created['status']);
            array_push($type, 'created');
            array_push($message, $created['message']);
        }

        $data = array(
            'status'  => true,
            'message' => 'OK'
        );
        for ($i=0; $i < count($sub_categories) ; $i++) {
            if($status[$i]==false)
            {
                $data = array(
                    'status'  => $status[$i],
                    'message' => 'Error in '. $type[$i] . ': ' . $message[$i]
                );
                break;
            }
        }

        return $data;
    }
}
