<?php

namespace App\Services\Roles;

use App\Services\IDefault;

interface IRole extends IDefault
{
    public function getActive();
    public function listRole($keyword, $start, $length, $order);
}
