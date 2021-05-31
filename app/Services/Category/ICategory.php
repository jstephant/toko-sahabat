<?php

namespace App\Services\Category;

use App\Services\IDefault;

interface ICategory extends IDefault
{
    public function getActive($keyword=null);
    public function listCategory($keyword, $start, $length, $order);
    public function deleteSubCategory($category_id);
}
