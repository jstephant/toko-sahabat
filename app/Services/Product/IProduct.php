<?php

namespace App\Services\Product;

use App\Services\IDefault;

interface IProduct extends IDefault
{
    public function getActive($keyword=null);
    public function listProduct($keyword, $start, $length, $order);
    public function generateCode($type, $length=4);

    public function createSubCategory($input);
    public function deleteSubCategory($product_id, $sub_category_id);
    public function setSubCategory($product_id, $sub_categories);
}
