<?php

namespace App\Services\Supplier;

use App\Services\IDefault;

interface ISupplier extends IDefault
{
    public function getActive($keyword=null);
    public function getActiveByName($name);
    public function listSupplier($keyword, $start, $length, $order);
}
