<?php

namespace App\Services\Orders;

use App\Models\OrderDetail;
use App\Models\Orders;
use App\Models\Product;
use App\Services\Orders\IOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SOrder implements IOrder
{
    private $orders;
    private $orderDetail;
    private $product;

    public function __construct(Orders $orders, OrderDetail $orderDetail, Product $product)
    {
        $this->orders = $orders;
        $this->orderDetail = $orderDetail;
        $this->product = $product;
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
            $order = Orders::create($input);
            DB::commit();
            $data['status'] = true;
            $data['message'] = 'OK';
            $data['id'] = $order->id;
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
            $update = Orders::where('id', $id)->update($input);
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
            $deleted = Orders::where('id', $id)->first();
            $deleted->status_id = 2;
            $deleted->save();
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
        return $this->orders->where('id', $id)->first();
    }

    public function createDetail($input)
    {
        $data = array(
            'status'  => false,
            'message' => '',
        );

        try {
            DB::beginTransaction();
            $new = OrderDetail::create($input);
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

    public function updateDetail($id, $item_id, $input)
    {
        $data = array(
            'status'  => false,
            'message' => ''
        );

        try {
            DB::beginTransaction();
            $update = OrderDetail::where('order_id', $id)->where('product_id', $item_id)->update($input);
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

    public function deleteDetail($id, $item_id)
    {
        $data = array(
            'status'  => false,
            'message' => ''
        );

        try {
            DB::beginTransaction();
            $deleted = OrderDetail::where('order_id', $id)->where('product_id', $item_id)->delete();
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

    public function deleteDetailAll($id)
    {
        $data = array(
            'status'  => false,
            'message' => ''
        );

        try {
            DB::beginTransaction();
            $deleted = OrderDetail::where('order_id', $id)->delete();
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

    public function findDetailById($id)
    {
        return $this->orderDetail->with(['product', 'satuan'])->where('order_id', $id)->get();
    }

    public function listOrder($start_date, $end_date, $status, $keyword, $start, $length, $order)
    {
        $orders = $this->orders
                          ->with([
                                'customer'        => function($q){ $q->select('id', 'name', 'mobile_phone'); },
                                'payment_status',
                                'transaction_status',
                                'created_user'    => function($q) { $q->select('id', 'name'); },
                                'updated_user'    => function($q) { $q->select('id', 'name'); },
                                'order_detail.product.product_sub_category',
                                'order_detail.satuan'
                            ])
                          ->whereBetween('order_date', [$start_date, $end_date])
                          ->where('status_id', 2);
        if($status)
        {
            $orders = $orders->where('payment_status_id', $status);
        }

        if($keyword)
        {
            $orders = $orders->where('order_code', 'like', '%'. $keyword .'%')
                             ->orwhereHas('customer', function($q) use($keyword) {
                                    $q->where('name', 'like', '%'.$keyword.'%')
                                      ->orwhere('mobile_phone', 'like', '%'.$keyword.'%');
                             });
        }

        $count = $orders->count();

        if($length!=-1) {
            $orders = $orders->offset($start)->limit($length);
        }

        $orders = $orders->get();

        $data = [
            'recordsTotal'    => $count,
            'recordsFiltered' => $count,
            'data'	          => $orders,
        ];

        return $data;
    }

    public function listProduct($sub_category, $keyword, $last_id=null)
    {
        $products = $this->product
                         ->with([
                                'product_sub_category',
                                'product_satuan.satuan' => function($q) { $q->orderby('qty', 'asc'); },
                            ])
                         ->where('is_active', true);

        if($sub_category)
        {
            $products = $products->where('sub_category_id', $sub_category);
        }

        if($keyword)
        {
            $products = $products->where('name', 'like', '%'.$keyword.'%');
        }

        if($last_id && $last_id!=0)
        {
            $products = $products->where('id', '<', $last_id);
        }

        $product_last_id = $products->limit(20)->orderby('id', 'asc')->first();
        $products = $products->limit(20)->orderby('id', 'desc')->get();

        $data = [
            'data'    => $products,
            'last_id' => ($product_last_id) ? $product_last_id->id : 0,
        ];

        return $data;
    }

    public function findByCartId($cart_id)
    {
        return $this->orders->where('cart_id', $cart_id)->first();
    }

    public function findDetailByIdProduct($order_id, $product_id)
    {
        return $this->orderDetail->where('order_id', $order_id)->where('product_id', $product_id)->first();
    }
}
