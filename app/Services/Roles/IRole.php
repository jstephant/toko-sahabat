<?php

namespace App\Services\Roles;

use App\Services\IDefault;

interface IRole extends IDefault
{
    public function getActive($keyword=null);
    public function listRole($keyword, $start, $length, $order);
}
