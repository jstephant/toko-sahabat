<?php

namespace App\Services\Roles;

use App\Services\IDefault;
use App\Services\IDefaultDetail;

interface IRole extends IDefault, IDefaultDetail
{
    public function getActive($keyword=null);
    public function listRole($keyword, $start, $length, $order);
    public function listPermission($role_id, $start, $length, $order);
    public function getAll();

    // feature role
    public function getAllFeatureRoleActive();
}
