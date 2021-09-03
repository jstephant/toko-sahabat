<?php

namespace App\Services\Product;

use App\Models\Product;
use App\Models\ProductSatuan;
use App\Models\ProductSubCategory;
use App\Services\Product\IProduct;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class SProduct implements IProduct
{
    private $product;
    private $productSatuan;

    public function __construct(Product $product, ProductSatuan $productSatuan)
    {
        $this->product = $product;
        $this->productSatuan = $productSatuan;
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
        $product = $this->product->with(['product_category', 'product_satuan.satuan'])->where('id', $id)->first();
        $product->image_url = ($product->image_name) ? url('images/product/'. $product->image_name) : url('images/product/default.png');
        return $product;
    }

    public function getActive($keyword=null)
    {
        $products = $this->product->with(['product_category', 'product_satuan.satuan']);
        if($keyword)
        {
            $products = $products->where('code', 'like', '%'.$keyword.'%')
                                 ->orwhere('name', 'like', '%'.$keyword.'%')
                                 ->orwhere('barcode', 'like', '%'.$keyword.'%');
        }
        return $products->get();
    }

    public function listProduct($keyword, $start, $length, $order)
    {
        $products = $this->product->with(['product_category', 'product_satuan.satuan', 'created_user', 'updated_user']);

        if($keyword)
        {
            $products = $products->where('code', 'like', '%'.$keyword.'%')
                                 ->orwhere('name', 'like', '%'.$keyword.'%')
                                 ->orWhereHas('product_category', function($q) use($keyword){ $q->where('name', 'like', ''.$keyword.''); })
                                 ->orWhereHas('product_satuan.satuan', function($q) use($keyword) {
                                        $q->where('name', 'like', '%'.$keyword.'%')
                                          ->orwhere('code', 'like', '%'.$keyword.'%');
                                 });
        }

        $count = $products->count();

        if($length!=-1) {
            $products = $products->offset($start)->limit($length);
        }

        if(count($order)>0)
        {
            switch ($order[0]['column']) {
                case 0:
                    $products = $products->orderby('name', $order[0]['dir']);
                    break;
                case 3:
                    $products = $products->orderby('code', $order[0]['dir']);
                    break;
                case 5:
                    $products = $products->orderby('created_at', $order[0]['dir']);
                    break;
                default:
                    $products = $products->orderby('created_at', $order[0]['dir']);
                    break;
            }
        }

        $products = $products->get();
        foreach ($products as $value) {
            $value->thumbnail = ($value->image_name) ? url('images/product/thumbnail/'. $value->image_name) : url('images/product/default.png');
            $value->image_url = ($value->image_name) ? url('images/product/'. $value->image_name) : url('images/product/default.png');
        }

        $data = [
            'recordsTotal'    => $count,
            'recordsFiltered' => $count,
            'data'	          => $products->toArray(),
        ];

        return $data;
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

    public function deleteSubCategory($product_id)
    {
        $data = array(
            'status'  => false,
            'message' => ''
        );

        try {
            DB::beginTransaction();
            $product = ProductSubCategory::where('product_id', $product_id)->delete();
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

        $deleted = $this->deleteSubCategory($product_id);
        array_push($status, $deleted['status']);
        array_push($type, 'deleted');
        array_push($message, $deleted['message']);

        foreach ($sub_categories as $value) {
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

    public function createProductSatuan($input)
    {
        $data = array(
            'status'  => false,
            'message' => ''
        );

        try {
            DB::beginTransaction();
            $product = ProductSatuan::create($input);
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

    public function deleteProductSatuan($product_id)
    {
        $data = array(
            'status'  => false,
            'message' => ''
        );

        try {
            DB::beginTransaction();
            $product = ProductSatuan::where('product_id', $product_id)->delete();
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

    public function setProductSatuan($product_id, $satuan)
    {
        $status = array();
        $type = array();
        $message = array();

        $deleted = $this->deleteProductSatuan($product_id);
        array_push($status, $deleted['status']);
        array_push($type, 'deleted');
        array_push($message, $deleted['message']);

        foreach ($satuan as $value) {
            $input = array('product_id' => $product_id, 'satuan_id' => $value);
            $created = $this->createProductSatuan($input);
            array_push($status, $created['status']);
            array_push($type, 'created');
            array_push($message, $created['message']);
        }

        $data = array(
            'status'  => true,
            'message' => 'OK'
        );
        for ($i=0; $i < count($satuan) ; $i++) {
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

    public function getProductSatuanById($product_id)
    {
        return DB::table('product_satuan')
                 ->leftjoin('satuan', 'product_satuan.satuan_id', 'satuan.id')
                 ->where('product_id', $product_id)
                 ->orderby('satuan.qty', 'asc')
                 ->get();
    }

    public function getDetailProductSatuan($product_id, $satuan_id)
    {
        return DB::table('product_satuan')
                 ->leftjoin('satuan', 'product_satuan.satuan_id', 'satuan.id')
                 ->where('product_id', $product_id)
                 ->where('satuan_id', $satuan_id)
                 ->first();
    }
}
