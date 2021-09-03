<?php

namespace App\Services\Purchase;

use App\Models\Purchase;
use App\Models\PurchaseDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class SPurchase implements IPurchase
{
    private $purchase;
    private $purchaseDetail;

    public function __construct(Purchase $purchase, PurchaseDetail $purchaseDetail)
    {
        $this->purchase = $purchase;
        $this->purchaseDetail = $purchaseDetail;
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
                                'transaction_status',
                                'created_user'    => function($q) { $q->select('id', 'name'); },
                                'updated_user'    => function($q) { $q->select('id', 'name'); },
                            ])
                          ->whereBetween('purchase_date', [$start_date, $end_date])
                          ->where('status_id', 2);
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

    public function createDetail($input)
    {
        $data = array(
            'status'  => false,
            'message' => '',
        );

        try {
            DB::beginTransaction();
            $new = PurchaseDetail::create($input);
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
            $update = PurchaseDetail::where('purchase_id', $id)->where('product_id', $item_id)->update($input);
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

    public function deleteDetail($id, $item_id=null)
    {
        $data = array(
            'status'  => false,
            'message' => ''
        );

        try {
            DB::beginTransaction();
            if($item_id)
                $deleted = PurchaseDetail::where('purchase_id', $id)->where('product_id', $item_id)->delete();
            else $deleted = PurchaseDetail::where('purchase_id', $id)->delete();
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

    public function findDetailById($id, $item_id=null)
    {
        if($item_id)
        {
            return $this->purchaseDetail
                    ->with(['product', 'satuan'])
                    ->where('purchase_id', $id)
                    ->where('product_id', $item_id)
                    ->first();
        }

        return $this->purchaseDetail
                    ->with(['product', 'satuan'])
                    ->where('purchase_id', $id)
                    ->get();
    }

    public function findDetailByProduct($purchase_id, $product_id)
    {
        return $this->purchaseDetail
                    ->with(['product', 'satuan'])
                    ->where('purchase_id', $purchase_id)
                    ->where('product_id', $product_id)
                    ->first();
    }
}
