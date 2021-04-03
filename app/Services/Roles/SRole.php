<?php

namespace App\Services\Roles;

use App\Models\Roles;
use App\Services\Roles\IRole;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class SRole implements IRole
{
    private $roles;

    public function __construct(Roles $roles)
    {
        $this->roles = $roles;
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

    public function getActive()
    {
        return $this->roles->where('is_active', 1)->get();
    }

    public function listRole($keyword, $start, $length, $order)
    {
        $roles = $this->roles->where('restricted', 0);

        if($keyword)
        {
            $roles = $roles->where('name', 'like', '%'.$keyword.'%');
        }

        $count = $roles->count();

        if($length!=-1) {
            $roles = $roles->offset($start)->limit($length);
        }

        $roles = $roles->get();

        $data = [
            'recordsTotal'    => $count,
            'recordsFiltered' => $count,
            'data'	          => $roles->toArray(),
        ];

        return $data;
    }

    public function findData($field, $keyword)
    {
        return $this->roles->where($field, $keyword)->first();
    }
}
