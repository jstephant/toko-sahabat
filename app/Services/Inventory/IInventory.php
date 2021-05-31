<?php

namespace App\Services\Inventory;

interface IInventory
{
    public function getStockIn($product_id, $satuan_id);
    public function getStockOut($product_id, $satuan_id);
    public function getStock($product_id, $satuan_id);
}
