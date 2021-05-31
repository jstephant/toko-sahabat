<?php

namespace App\Services\Product;

use App\Services\IDefault;

interface IProduct extends IDefault
{
    public function getActive($keyword=null);
    public function listProduct($keyword, $start, $length, $order);

    public function createSubCategory($input);
    public function deleteSubCategory($product_id);
    public function setSubCategory($product_id, $sub_categories);

    public function createProductSatuan($input);
    public function deleteProductSatuan($product_id);
    public function setProductSatuan($product_id, $satuan);
    public function getProductSatuanById($product_id);
    public function getDetailProductSatuan($product_id, $satuan_id);
}
