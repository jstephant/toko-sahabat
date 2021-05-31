<?php

namespace App\Services\Inventory;

use App\Models\OrderProduct;
use App\Models\PurchaseProduct;
use App\Models\Satuan;
use App\Services\Inventory\IInventory;

class SInventory implements IInventory
{
    private $purchaseProduct;
    private $satuan;
    private $orderProduct;

    public function __construct(Satuan $satuan, PurchaseProduct $purchaseProduct, OrderProduct $orderProduct)
    {
        $this->purchaseProduct = $purchaseProduct;
        $this->satuan = $satuan;
        $this->orderProduct = $orderProduct;
    }

    public function getStockIn($product_id, $satuan_id)
    {
        $satuan_request = $this->satuan->where('id', $satuan_id)->first();
        $qty_request = $satuan_request->qty;

        $stock_in = 0;
        $stock_purchase = 0;
        $purchases = $this->purchaseProduct
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
        return $stock_in;
    }

    public function getStockOut($product_id, $satuan_id)
    {
        $satuan_request = $this->satuan->where('id', $satuan_id)->first();
        $qty_request = $satuan_request->qty;

        $stock_out = 0;
        $stock_order = 0;
        $orders = $this->orderProduct
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
        return $stock_out;
    }

    public function getStock($product_id, $satuan_id)
    {
        $in = $this->getStockIn($product_id, $satuan_id);
        $out = $this->getStockOut($product_id, $satuan_id);

        return $in - $out;
    }
}
