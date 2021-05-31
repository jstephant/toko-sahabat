<?php

namespace App\Services\Purchase;

use App\Services\IDefault;
use App\Services\IDefaultDetail;

interface IPurchase extends IDefault, IDefaultDetail
{
    public function listPurchase($start_date, $end_date, $keyword, $start, $length, $order);
    public function findDetailByProduct($purchase_id, $product_id);
}
