<?php

namespace App\Http\Controllers;

use App\Http\Requests\user\CreateUserRequest;
use App\Services\Roles\SRole;
use App\Services\SGlobal;
use App\Services\User\SUser;
use Illuminate\Http\Request;
use UxWeb\SweetAlert\SweetAlert;

class UserController extends Controller
{
    private $sGlobal;
    private $sUser;
    private $sRole;

    public function __construct(
        SGlobal $sGlobal,
        SUser $sUser,
        SRole $sRole
    )
    {
        $this->sGlobal = $sGlobal;
        $this->sUser   = $sUser;
        $this->sRole   = $sRole;
    }

    public function index()
    {
        $data = array(
            'title'     => 'User',
            'edit_mode' => 0
        );

        return $this->sGlobal->view('user.index', $data);
    }

    public function listUser(Request $request)
    {
        $users = $this->sUser->list($request->keyword, $request->start, $request->length, $request->order);
        $users['draw'] = $request->draw;

        return $users;
    }

    public function create()
    {
        $roles = $this->sRole->getActive();

        $data = array(
            'title'       => 'Create User',
            'active_menu' => 'Create User',
            'edit_mode'   => 1,
            'roles'       => $roles
        );

        return $this->sGlobal->view('user.create', $data);
    }

    public function doCreate(CreateUserRequest $request)
    {
        $validated = $request->validated();

        $name = $request->name;
        $username = $request->username;
        $email = $request->email;
        $password = bcrypt($request->password);
        $roles = $request->role;

        $input = array(
            'name'      => $name,
            'user_name' => $username,
            'email'     => $email,
            'password'  => $password
        );
        $created = $this->sUser->create($input);
        if(!$created['status'])
        {
            SweetAlert::error('Error', $created['message']);
            return redirect()->back()->withInput();
        }
        $user_id = $created['id'];

        $user_role = $this->sUser->setUserRole($user_id, $roles);
        if(!$user_role)
        {
            SweetAlert::error('Error', $user_role['message']);
            return redirect()->back()->withInput();
        }

        SweetAlert::success('Success', 'New user created successfully');
        return redirect()->route('user.index');
    }

    public function edit($id)
    {
        $roles = $this->sRole->getActive();
        $user  = $this->sUser->findById($id);

        $data = array(
            'title'       => 'Edit User',
            'active_menu' => 'Edit User',
            'edit_mode'   => 1,
            'roles'       => $roles,
            'user'        => $user
        );

        return $this->sGlobal->view('user.edit', $data);
    }

    public function doUpdate(Request $request)
    {
        $id = $request->user_id;
        $name = $request->name;
        $email = $request->email;
        $roles = $request->role;

        $input = array(
            'name'       => $name,
            'email'      => $email,
            'updated_at' => date('Y-m-d H:i:s')
        );

        $updated = $this->sUser->update($id, $input);
        if(!$updated['status'])
        {
            SweetAlert::error('Error', $updated['message']);
            return redirect()->back()->withInput();
        }

        $user_role = $this->sUser->setUserRole($id, $roles);
        if(!$user_role)
        {
            alert()->error('Error', $user_role['message']);
            return redirect()->back()->withInput();
        }

        alert()->success('Success', 'Data updated successfully');
        return redirect()->route('user.index');
    }

    public function checkData($field, $keyword)
    {
        $user = $this->sUser->findData($field, $keyword);
        return ($user) ? 0 : 1;
    }
}
