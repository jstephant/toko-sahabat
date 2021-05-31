<?php

namespace App\Services\Orders;

use App\Services\IDefault;
use App\Services\IDefaultDetail;

interface IOrder extends IDefault, IDefaultDetail
{
    public function listOrder($start_date, $end_date, $status, $keyword, $start, $length, $order);
    public function listProduct($sub_category, $keyword, $start, $length);
    public function findByCartId($cart_id);
    public function findDetailByIdProduct($order_id, $product_id);
}
