<?php

namespace App\Services\Purchase;

use App\Models\Purchase;
use App\Models\PurchaseProduct;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class SPurchase implements IPurchase
{
    private $purchase;
    private $purchaseProduct;

    public function __construct(Purchase $purchase, PurchaseProduct $purchaseProduct)
    {
        $this->purchase = $purchase;
        $this->purchaseProduct = $purchaseProduct;
    }

    public function create($input)
    {
        $data = array(
            'status'  => false,
            'message' => '',
            'id'      => null
        );

        try {
            DB::beginTransaction();
            $new = Purchase::create($input);
            DB::commit();
            $data['status'] = true;
            $data['message'] = 'OK';
            $data['id'] = $new->id;
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
            $update = Purchase::where('id', $id)->update($input);
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
            $deleted = Purchase::where('id', $id)->first();
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
        return $this->purchase->where('id', $id)->first();
    }

    public function listPurchase($start_date, $end_date, $keyword, $start, $length, $order)
    {
        $purchases = $this->purchase
                          ->with([
                                'supplier'        => function($q){ $q->select('id', 'name'); },
                                'purchase_status',
                                'created_user'    => function($q) { $q->select('id', 'name'); },
                                'updated_user'    => function($q) { $q->select('id', 'name'); },
                            ])
                          ->whereBetween('purchase_date', [$start_date, $end_date]);
        if($keyword)
        {
            $purchases = $purchases->where('purchase_number', 'like', '%'. $keyword .'%');
        }

        $count = $purchases->count();

        if($length!=-1) {
            $purchases = $purchases->offset($start)->limit($length);
        }

        $purchases = $purchases->get();

        $data = [
            'recordsTotal'    => $count,
            'recordsFiltered' => $count,
            'data'	          => $purchases->toArray(),
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

        $check = $this->purchase->where($type, $randomString)->first();

        if((isset($check->id) && $check->id != null) || strlen(intval($randomString))<$length){
            $randomString = $this->generateCode($type, $length);
        }

        return $randomString;
    }

    public function createDetail($input)
    {
        $data = array(
            'status'  => false,
            'message' => '',
        );

        try {
            DB::beginTransaction();
            $new = PurchaseProduct::create($input);
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

    public function updateDetail($purchase_id, $product_id, $input)
    {
        $data = array(
            'status'  => false,
            'message' => ''
        );

        try {
            DB::beginTransaction();
            $update = PurchaseProduct::where('purchase_id', $purchase_id)->where('product_id', $product_id)->update($input);
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

    public function deleteDetail($purchase_id, $product_id)
    {
        $data = array(
            'status'  => false,
            'message' => ''
        );

        try {
            DB::beginTransaction();
            $deleted = PurchaseProduct::where('purchase_id', $purchase_id)->where('product_id', $product_id)->delete();
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

    public function deleteDetailAll($purchase_id)
    {
        $data = array(
            'status'  => false,
            'message' => ''
        );

        try {
            DB::beginTransaction();
            $deleted = PurchaseProduct::where('purchase_id', $purchase_id)->delete();
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

    public function findDetailById($purchase_id)
    {
        return $this->purchaseProduct
                    ->with(['product', 'satuan'])
                    ->where('purchase_id', $purchase_id)
                    ->get();
    }

    public function findDetailByProduct($purchase_id, $product_id)
    {
        return $this->purchaseProduct
                    ->with(['product', 'satuan'])
                    ->where('purchase_id', $purchase_id)
                    ->where('product_id', $product_id)
                    ->first();
    }
}
