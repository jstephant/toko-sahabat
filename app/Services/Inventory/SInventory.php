<?php

namespace App\Services\Inventory;

use App\Models\OrderDetail;
use App\Models\PurchaseDetail;
use App\Models\Satuan;
use App\Services\Inventory\IInventory;

class SInventory implements IInventory
{
    private $purchaseDetail;
    private $satuan;
    private $orderDetail;

    public function __construct(Satuan $satuan, PurchaseDetail $purchaseDetail, OrderDetail $orderDetail)
    {
        $this->purchaseDetail = $purchaseDetail;
        $this->satuan = $satuan;
        $this->orderDetail = $orderDetail;
    }

    public function getStockIn($product_id, $satuan_id)
    {
        $satuan_request = $this->satuan->where('id', $satuan_id)->first();
        $qty_request = $satuan_request->qty;

        $stock_in = 0;
        $stock_purchase = 0;
        $purchases = $this->purchaseDetail
                         ->with('purchase')
                         ->where('product_id', $product_id)
                         ->wherehas('purchase', function($q) {
                                $q->where('status_id', 2);
                            })
                         ->get();

        if($purchases)
        {
            foreach ($purchases as $item) {
                $satuan = $this->satuan->where('id', $item->satuan_id)->first();
                $qty_std = $satuan->qty;
                $stock_purchase += ($item->qty * $qty_std);
            }
            $stock_in = $stock_purchase / $qty_request;
        }
        return ceil($stock_in);
    }

    public function getStockOut($product_id, $satuan_id)
    {
        $satuan_request = $this->satuan->where('id', $satuan_id)->first();
        $qty_request = $satuan_request->qty;

        $stock_out = 0;
        $stock_order = 0;
        $orders = $this->orderDetail
                         ->with('orders')
                         ->where('product_id', $product_id)
                         ->wherehas('orders', function($q) {
                                $q->where('status_id', 2)->where('payment_status_id', 2);
                            })
                         ->get();

        if($orders)
        {
            foreach ($orders as $item) {
                $satuan = $this->satuan->where('id', $item->satuan_id)->first();
                $qty_std = $satuan->qty;
                $stock_order += ($item->qty * $qty_std);
            }
            $stock_out = $stock_order / $qty_request;
        }
        return ceil($stock_out);
    }

    public function getStock($product_id, $satuan_id)
    {
        $in = $this->getStockIn($product_id, $satuan_id);
        $out = $this->getStockOut($product_id, $satuan_id);

        return $in - $out;
    }
}
