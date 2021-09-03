<?php

namespace App\Services\Orders;

use App\Services\IDefault;
use App\Services\IDefaultDetail;

interface IOrder extends IDefault, IDefaultDetail
{
    public function listOrder($start_date, $end_date, $staff, $keyword, $start, $length, $order);
    public function listProduct($category, $keyword, $last_id=null);
    public function findByCartId($cart_id);
    public function listDetailProduct($order_id, $start, $length, $order);
}
