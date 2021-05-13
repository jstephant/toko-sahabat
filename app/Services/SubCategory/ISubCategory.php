<?php

namespace App\Services\SubCategory;

use App\Services\IDefault;

interface ISubCategory extends IDefault
{
    public function getActive($keyword=null);
    public function getActiveByCategoryId($id);
    public function listSubCategory($category, $keyword, $start, $length, $order);
}
