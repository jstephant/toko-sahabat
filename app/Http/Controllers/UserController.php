<?php

namespace App\Http\Controllers;

use App\Http\Requests\user\CreateUserRequest;
use App\Services\Roles\SRole;
use App\Services\SGlobal;
use App\Services\User\SUser;
use Illuminate\Http\Request;
use UxWeb\SweetAlert\SweetAlert;
use Validator;

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
            'title'       => 'User',
            'active_menu' => 'User'
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
            'roles'       => $roles
        );

        return $this->sGlobal->view('user.create', $data);
    }

    public function doCreate(CreateUserRequest $request)
    {
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
            return redirect()->back();
        }
        $user_id = $created['id'];

        foreach($roles as $value)
        {
            $user_role = $this->sUser->setUserRole($user_id, $value);
        }
        SweetAlert::success('Success', 'New user created successfully');
        return redirect()->route('user.index');
    }

    public function edit()
    {
        $roles = $this->sRole->getActive();

        $data = array(
            'title' => 'Create User',
            'roles' => $roles
        );
        return $this->sGlobal->view('user.create', $data);
    }

    public function doUpdate(Request $request)
    {

    }
}
