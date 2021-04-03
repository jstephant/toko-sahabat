<?php

namespace App\Services\Satuan;

use App\Services\IDefault;

interface ISatuan extends IDefault
{
    public function getActive();
    public function listSatuan($keyword, $start, $length, $order);
    public function findData($field, $keyword);
}
