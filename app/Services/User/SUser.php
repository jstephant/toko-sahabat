<?php

namespace App\Services\User;

use App\Models\UserRole;
use App\Models\Users;
use App\Services\User\IUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Exception;

class SUser implements IUser
{
    private $users;
    private $userRole;

    public function __construct(Users $users, UserRole $userRole)
    {
        $this->users = $users;
        $this->userRole = $userRole;
    }

    public function login($username, $password)
    {
        return $this->users->where('user_name', $username)->where('password', $password)->first();
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
            $user = Users::create($input);
            DB::commit();
            $data['status'] = true;
            $data['message'] = 'OK';
            $data['id'] = $user->id;
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
            $user = Users::where('id', $id)->update($input);
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
            $user = Users::where('id', $id)->first();
            $user->is_active = 0;
            $user->save();
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

    public function changePassword($id, $new_password)
    {
        $data = array(
            'status'  => false,
            'message' => ''
        );

        try {
            DB::beginTransaction();
            $user = Users::where('id', $id)->first();
            $user->password = Hash::make($new_password);
            $user->save();
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
        return $this->users->where('id', $id)->first();
    }

    public function findByUsername($username)
    {
        return $this->users->where('user_name', $username)->first();
    }

    public function findByEmail($email)
    {
        return $this->users->where('email', $email)->first();
    }

    public function getActive()
    {
        return $this->users->where('is_active', 1)->select('id', 'name', 'user_name', 'email')->get();
    }

    public function list($keyword, $start, $length, $order)
    {
        $users = $this->users->with('user_role', 'user_role.role');

        if($keyword)
        {
            $users = $users->where('name', 'like', '%'.$keyword.'%');
        }

        $count = $users->count();

        if($length!=-1) {
            $users = $users->offset($start)->limit($length);
        }

        $users = $users->get();
        foreach ($users as $value) {
            $role_name = array();
            foreach ($value->user_role as $value2) {
                array_push($role_name, $value2->role->name);
            }

            $value->role_name = implode(', ', $role_name);
        }

        $data = [
            'recordsTotal'    => $count,
            'recordsFiltered' => $count,
            'data'	          => $users->toArray(),
        ];

        return $data;
    }

    public function createUserRole($input)
    {
        $data = array(
            'status'  => false,
            'message' => ''
        );

        try {
            DB::beginTransaction();
            $user = UserRole::create($input);
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

    public function deleteUserRole($user_id, $role_id)
    {
        $data = array(
            'status'  => false,
            'message' => ''
        );

        try {
            DB::beginTransaction();
            $user = UserRole::where('user_id', $user_id)->where('role_id', $role_id)->first();
            $user->delete();
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

    public function setUserRole($user_id, $role_id)
    {
        $user_role = $this->userRole->where('user_id', $user_id)->where('role_id', $role_id)->first();
        if($user_role)
        {
            $deleted = $this->deleteUserRole($user_id, $role_id);
            if(!$deleted['status'])
            {
                return $deleted;
            }
        }

        $input = array('user_id' => $user_id, 'role_id' => $role_id);
        $created = $this->createUserRole($input);

        return $created;
    }
}
