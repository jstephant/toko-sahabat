<?php

namespace App\Services\Roles;

use App\Models\FeatureRole;
use App\Models\Features;
use App\Models\Roles;
use App\Services\Roles\IRole;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class SRole implements IRole
{
    private $roles;
    private $features;
    private $featureRole;

    public function __construct(Roles $roles, Features $features, FeatureRole $featureRole)
    {
        $this->roles = $roles;
        $this->features = $features;
        $this->featureRole = $featureRole;
    }

    public function create($input)
    {
        $data = array(
            'status'  => false,
            'message' => '',
            'id'      => null,
        );

        try {
            DB::beginTransaction();
            $role = Roles::create($input);
            DB::commit();
            $data['status'] = true;
            $data['message'] = 'OK';
            $data['id'] = $role->id;
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $data['message'] = $e->getMessage();
        }

        return $data;
    }

    public function update($id, $input)
    {
        $data = array(
            'status'  => false,
            'message' => ''
        );

        try {
            DB::beginTransaction();
            $role = Roles::where('id', $id)->where('restricted', 0)->update($input);
            DB::commit();
            $data['status'] = true;
            $data['message'] = 'OK';
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $data['message'] = $e->getMessage();
        }

        return $data;
    }

    public function delete($id)
    {
        $data = array(
            'status'  => false,
            'message' => ''
        );

        try {
            DB::beginTransaction();
            $role = Roles::where('id', $id)->where('restricted', 0)->first();
            $role->is_active = 0;
            $role->save();
            DB::commit();
            $data['status'] = true;
            $data['message'] = 'OK';
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $data['message'] = $e->getMessage();
        }

        return $data;
    }

    public function findById($id)
    {
        return $this->roles->where('id', $id)->first();
    }

    public function createDetail($input)
    {
        $data = array(
            'status'  => false,
            'message' => ''
        );

        try {
            DB::beginTransaction();
            $created = FeatureRole::create($input);
            DB::commit();
            $data['status'] = true;
            $data['message'] = 'OK';
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $data['message'] = $e->getMessage();
        }

        return $data;
    }

    public function updateDetail($role_id, $feature_id, $input)
    {
        $data = array(
            'status'  => false,
            'message' => ''
        );

        try {
            DB::beginTransaction();
            $updated = FeatureRole::where('role_id', $role_id)->where('feature_id', $feature_id)->update($input);
            DB::commit();
            $data['status'] = true;
            $data['message'] = 'OK';
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $data['message'] = $e->getMessage();
        }

        return $data;
    }

    public function deleteDetail($role_id, $feature_id = null)
    {
        $data = array(
            'status'  => false,
            'message' => ''
        );

        try {
            DB::beginTransaction();
            if($feature_id)
                $deleted = FeatureRole::where('role_id', $role_id)->where('feature_id', $feature_id)->delete();
            else $deleted = FeatureRole::where('role_id', $role_id)->delete();
            DB::commit();
            $data['status'] = true;
            $data['message'] = 'OK';
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $data['message'] = $e->getMessage();
        }

        return $data;
    }

    public function findDetailById($role_id, $feature_id = null)
    {
        if($feature_id)
            return $this->featureRole->where('role_id', $role_id)->where('feature_id', $feature_id)->first();
        else return $this->featureRole->where('role_id', $role_id)->get();
    }

    public function getActive($keyword=null)
    {
        $roles = $this->roles->where('is_active', 1);

        if($keyword)
        {
            $roles = $roles->where('name', 'like', '%'.$keyword.'%');
        }

        return $roles->orderby('name', 'asc')->get();
    }

    public function listRole($keyword, $start, $length, $order)
    {
        $roles = $this->roles->with(['created_user', 'updated_user'])->where('restricted', 0);

        if($keyword)
        {
            $roles = $roles->where('name', 'like', '%'.$keyword.'%');
        }

        $count = $roles->count();

        if($length!=-1) {
            $roles = $roles->offset($start)->limit($length);
        }

        if(count($order)>0)
        {
            switch ($order[0]['column']) {
                case 0:
                    $roles = $roles->orderby('name', $order[0]['dir']);
                    break;
                case 2:
                    $roles = $roles->orderby('created_at', $order[0]['dir']);
                    break;
                default:
                    $roles = $roles->orderby('created_at', $order[0]['dir']);
                    break;
            }
        }

        $roles = $roles->get();

        $data = [
            'recordsTotal'    => $count,
            'recordsFiltered' => $count,
            'data'	          => $roles->toArray(),
        ];

        return $data;
    }



    public function listPermission($role_id, $start, $length, $order)
    {
        if($length==-1)
            $result = $this->featureRole->with(['feature' => function($q){ $q->orderby('parent_id', 'asc')->orderby('sequence', 'asc');}])
                                        ->where('role_id', $role_id);

        $count = $result->count();

        $result = $result->get();
        $data = array(
            'recordsTotal'    => $count,
            'recordsFiltered' => $count,
            'data'            => $result->toArray()
        );

        return $data;
    }

    public function getAll()
    {
        return $this->role->get();
    }

    public function getAllFeatureRoleActive()
    {
        $result = $this->featureRole->with(['feature' => function($q){ $q->where('is_active', 1)->orderby('parent_id', 'asc')->orderby('sequence', 'asc');}])
                                    ->orderby('role_id', 'asc')
                                    ->get();
        return $result;
    }
}
