<?php

namespace App\Services\Cart;

use App\Models\Cart;
use App\Models\CartDetail;
use App\Services\Cart\ICart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SCart implements ICart
{
    private $cart;
    private $cartDetail;

    public function __construct(Cart $cart, CartDetail $cartDetail)
    {
        $this->cart = $cart;
        $this->cartDetail = $cartDetail;
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
            $cart = Cart::create($input);
            DB::commit();
            $data['status'] = true;
            $data['message'] = 'OK';
            $data['id'] = $cart->id;
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
            $update = Cart::where('id', $id)->update($input);
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
            $deleted = Cart::where('id', $id)->first();
            $deleted->status_id = 3;
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
        return $this->cart->where('id', $id)->first();
    }

    public function createDetail($input)
    {
        $data = array(
            'status'  => false,
            'message' => '',
        );

        try {
            DB::beginTransaction();
            $new = CartDetail::create($input);
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
            $update = CartDetail::where('cart_id', $id)->where('product_id', $item_id)->update($input);
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
            $deleted = CartDetail::where('cart_id', $id)->where('product_id', $item_id)->delete();
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
            $deleted = CartDetail::where('cart_id', $id)->delete();
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
        return $this->cartDetail
                    ->with(['product', 'satuan'])
                    ->where('cart_id', $id)
                    ->get();
    }

    public function findDetailByIdProduct($cart_id, $product_id)
    {
        return $this->cartDetail->with('satuan')->where('cart_id', $cart_id)->where('product_id', $product_id)->first();
    }

    public function findPendingByDate($date, $user_id)
    {
        return $this->cart->with([
                                'customer' => function($q) { $q->select('id', 'name', 'mobile_phone'); },
                                'cart_detail.product.product_sub_category',
                                'cart_detail.satuan'
                            ])
                          ->where('created_by', $user_id)
                          ->where('status_id', 1)
                          ->whereDate('order_date', $date)
                          ->first();
    }

    public function hitungTotal($id)
    {
        $sub_total = 0;
        $disc_price = 0;
        $total = 0;
        $cart = $this->findDetailById($id);
        if($cart)
        {
            foreach ($cart as $value) {
                $sub_total += $value->sub_total;
                $disc_price += $value->disc_price;
                $total += $value->total;
            }

        }
        return array(
            'sub_total'  => $sub_total,
            'disc_price' => $disc_price,
            'total'      => $total
        );
    }
}
