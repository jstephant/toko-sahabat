<?php

namespace App\Services\Satuan;

use App\Services\IDefault;

interface ISatuan extends IDefault
{
    public function getActive();
    public function list($keyword, $start, $length, $order);
}
