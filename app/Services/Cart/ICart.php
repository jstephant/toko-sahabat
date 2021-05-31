<?php

namespace App\Services\Cart;

use App\Services\IDefault;
use App\Services\IDefaultDetail;

interface ICart extends IDefault, IDefaultDetail
{
    public function findDetailByIdProduct($cart_id, $product_id);
    public function findPendingByDate($date, $user_id);
    public function hitungTotal($id);
}
