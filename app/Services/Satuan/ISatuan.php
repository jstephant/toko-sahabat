<?php

namespace App\Services\Satuan;

use App\Services\IDefault;

interface ISatuan extends IDefault
{
    public function getActive($keyword=null);
    public function listSatuan($keyword, $start, $length, $order);
}
