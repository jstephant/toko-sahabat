<?php

namespace App\Services\Customer;

use App\Services\IDefault;

interface ICustomer extends IDefault
{
    public function getActive($keyword=null);
    public function getActiveByName($name);
    public function listCustomer($keyword, $start, $length, $order);
}
