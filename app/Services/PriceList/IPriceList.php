<?php

namespace App\Services\PriceList;

use App\Services\IDefault;

interface IPriceList extends IDefault
{
    public function findByDate($date, $product_id);
    public function findItemByDate($product_id);
    public function getProductPriceBySatuan($product_id, $satuan_id);
    public function deleteByIdDate($id, $date);
}
