<?php

namespace App\Services\Feature;

interface IFeature
{
    public function getActiveByRole($role_id);
    public function getMenuByRole($role_id, $parent_id=0);
    public function getUserPermission($role_id, $feature_id, $action=null);
    public function getMenuByParent($parent_id=0);
}