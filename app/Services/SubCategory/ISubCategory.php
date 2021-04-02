<?php

namespace App\Services\SubCategory;

use App\Services\IDefault;

interface ISubCategory extends IDefault
{
    public function getActive();
    public function getActiveByCategoryId($id);
    public function list($keyword, $start, $length, $order);
}
