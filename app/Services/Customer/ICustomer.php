<?php

namespace App\Services\Customer;

use App\Services\IDefault;

interface ICustomer extends IDefault
{
    public function getActive();
    public function getActiveByName($name);
    public function list($keyword, $start, $length, $order);
}
