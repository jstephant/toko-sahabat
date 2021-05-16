<?php

namespace App\Http\Controllers;

use App\Http\Requests\user\CreateUserRequest;
use App\Http\Requests\User\EditUserRequest;
use App\Services\Roles\SRole;
use App\Services\SGlobal;
use App\Services\User\SUser;
use Illuminate\Http\Request;
use Hash;

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
        $password = $this->sGlobal->passwordEncrpt($request->password);
        $role = $request->role;

        $input = array(
            'name'      => $name,
            'user_name' => $username,
            'email'     => $email,
            'password'  => $password,
            'role_id'   => $role
        );
        $created = $this->sUser->create($input);
        if(!$created['status'])
        {
            return redirect()->back()->with('error', $created['message']);
        }

        return redirect()->route('user.index')->with('success', 'User berhasil dibuat');
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

    public function doUpdate(EditUserRequest $request)
    {
        $validated = $request->validated();

        $id = $request->user_id;
        $name = $request->name;
        $email = $request->email;
        $role = $request->role;

        $input = array(
            'name'       => $name,
            'email'      => $email,
            'role_id'    => $role,
            'updated_at' => date('Y-m-d H:i:s')
        );

        $updated = $this->sUser->update($id, $input);
        if(!$updated['status'])
        {
            return redirect()->back()->with('error', $updated['message']);
        }

        return redirect()->route('user.index')->with('success', 'Data berhasil diupdate');
    }

    public function doDelete($id)
    {
        $deleted = $this->sUser->delete($id);
        if(!$deleted['status'])
        {
            return redirect()->back()->with('error', $deleted['message']);
        }
        return redirect()->route('user.index')->with('success', 'Data berhasil dihapus');
    }
}
