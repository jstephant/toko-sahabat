<?php

namespace App\Services\Category;

use App\Services\IDefault;

interface ICategory extends IDefault
{
    public function getActive();
    public function list($keyword, $start, $length, $order);
    public function deleteSubCategory($category_id);
}
