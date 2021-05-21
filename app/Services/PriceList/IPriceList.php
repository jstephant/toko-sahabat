<?php

namespace App\Services\PriceList;

use App\Services\IDefault;

interface IPriceList extends IDefault
{
    public function findByDate($date);
    public function findItemByDate($date, $product_id);
}
