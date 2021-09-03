<?php

namespace App\Services\Feature;

use App\Models\Features;
use App\Models\FeatureRole;
use App\Services\Feature\IFeature;
use Illuminate\Support\Facades\DB;

class SFeature implements IFeature
{
    private $features;
    private $featureRole;

    public function __construct(Features $features, FeatureRole $featureRole)
    {
        $this->features = $features;
        $this->featureRole = $featureRole;    
    }

    public function getActiveByRole($role_id)
    {
        return  DB::table('feature_role')
                    ->select('feature_role.role_id', 'feature_role.feature_id', 'feature_role.is_access', 'feature_role.is_create', 'feature_role.is_edit', 'feature_role.is_delete', 
                        'feature_role.is_approval', 'feature_role.is_landing_page', 'features.parent_id', 'features.link')
                    ->leftjoin('features', 'feature_role.feature_id', 'features.id')
                    ->where('role_id', $role_id)
                    ->where('is_active', true)
                    ->orderby('parent_id', 'asc')
                    ->orderby('features.sequence', 'asc')
                    ->get();
    }

    public function getMenuByRole($role_id, $parent_id=0)
    {
        return  DB::table('feature_role')
                    ->leftjoin('features', 'feature_role.feature_id', 'features.id')
                    ->where('role_id', $role_id)
                    ->where('is_active', true)
                    ->where('is_main_menu', true)
                    ->where('parent_id', $parent_id)
                    ->orderby('parent_id', 'asc')
                    ->orderby('features.sequence', 'asc')
                    ->get();
    }

    public function getUserPermission($role_id, $feature_id, $action = null)
    {
        $feature_role =  $this->featureRole
                              ->where('role_id', $role_id)
                              ->where('feature_id', $feature_id);
        if($action)
        {
            $feature_role = $feature_role->where($action, true);
        }

        return $feature_role->first();
    }

    public function getMenuByParent($parent_id=0)
    {
        return $this->features->where('is_active', true)->where('parent_id', $parent_id)->orderby('sequence', 'asc')->get();
    }
}