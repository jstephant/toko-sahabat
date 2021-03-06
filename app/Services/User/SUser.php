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
        $data = array(
            'status'  => false,
            'message' => '',
            'data'    => null
        );

        $user = $this->users->where('user_name', $username)->where('password', $password)->first();
        if($user)
        {
            $data['status'] = true;
            $data['message'] = 'OK';
            $data['data'] = array(
                'id'      => $user->id,
                'name'    => $user->name,
                'role_id' => $user->role_id
            );
        }
        return $data;
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
        return $this->users->with('role')->where('id', $id)->first();
    }

    public function findByUsername($username)
    {
        return $this->users->where('user_name', $username)->first();
    }

    public function findByEmail($email)
    {
        return $this->users->where('email', $email)->first();
    }

    public function getActive($keyword=null)
    {
        $users = $this->users
                      ->where('is_active', 1)
                      ->where('restricted', 0)
                      ->select('id', 'name', 'user_name', 'email');

        if($keyword)
        {
            $users = $users->where('name', 'like', '%'.$keyword.'%');
        }

        return $users->orderby('name', 'asc')->get();
    }

    public function list($keyword, $start, $length, $order)
    {
        $users = $this->users->with('role')->where('restricted', 0);

        if($keyword)
        {
            $users = $users->where('name', 'like', '%'.$keyword.'%')
                           ->orwhere('email', 'like', '%'.$keyword.'%')
                           ->orwhere('user_name', 'like', '%'.$keyword.'%');
        }

        $count = $users->count();

        if($length!=-1) {
            $users = $users->offset($start)->limit($length);
        }

        if(count($order)>0)
        {
            switch ($order[0]['column']) {
                case 0:
                    $users = $users->orderby('name', $order[0]['dir']);
                    break;
                case 1:
                    $users = $users->orderby('user_name', $order[0]['dir']);
                    break;
                case 2:
                    $users = $users->orderby('email', $order[0]['dir']);
                    break;
                case 5:
                    $users = $users->orderby('created_at', $order[0]['dir']);
                    break;
                default:
                    $users = $users->orderby('created_at', $order[0]['dir']);
                    break;
            }
        }

        $users = $users->get();

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

    public function setUserRole($user_id, $roles)
    {
        $status = array();
        $type = array();
        $message = array();

        foreach ($roles as $value) {
            $user_role = $this->userRole->where('user_id', $user_id)->where('role_id', $value)->first();
            if($user_role)
            {
                $deleted = $this->deleteUserRole($user_id, $value);
                array_push($status, $deleted['status']);
                array_push($type, 'deleted');
                array_push($message, $deleted['message']);
            }

            $input = array('user_id' => $user_id, 'role_id' => $value);
            $created = $this->createUserRole($input);
            array_push($status, $created['status']);
            array_push($type, 'created');
            array_push($message, $created['message']);
        }

        $data = array(
            'status'  => true,
            'message' => 'OK'
        );
        for ($i=0; $i < count($roles) ; $i++) {
            if($status[$i]==false)
            {
                $data = array(
                    'status'  => $status[$i],
                    'message' => 'Error in '. $type[$i] . ': ' . $message[$i]
                );
                break;
            }
        }

        return $data;
    }
}
