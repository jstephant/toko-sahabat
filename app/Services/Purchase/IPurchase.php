<?php

namespace App\Services\Purchase;

use App\Services\IDefault;

interface IPurchase extends IDefault
{
    public function listPurchase($start_date, $end_date, $keyword, $start, $length, $order);
    public function generateCode($type, $length=4);

    // purchase detail
    public function createDetail($input);
    public function updateDetail($purchase_id, $product_id, $input);
    public function deleteDetail($purchase_id, $product_id);
    public function deleteDetailAll($purchase_id);
    public function findDetailById($purchase_id);
    public function findDetailByProduct($purchase_id, $product_id);

}
