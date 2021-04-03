<?php

namespace App\Http\Controllers;

use App\Services\Roles\SRole;
use App\Services\SGlobal;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    private $sGlobal;
    private $sRole;

    public  function __construct(SGlobal $sGlobal, SRole $sRole)
    {
        $this->sGlobal = $sGlobal;
        $this->sRole = $sRole;
    }

    public function index()
    {
        $data = array(
            'title'       => 'Roles',
            'active_menu' => 'Roles',
            'edit_mode'   => 0
        );

        return $this->sGlobal->view('role.index', $data);
    }

    public function listRole(Request $request)
    {
        $roles = $this->sRole->listRole($request->keyword, $request->start, $request->length, $request->order);
        $roles['draw'] = $request->draw;

        return $roles;
    }

    public function doSave(Request $request)
    {
        $mode = $request->mode;
        $role_id = $request->role_id;
        $name = $request->name;
        $status = $request->status;

        if($mode=='create')
        {
            $input = array(
                'name' => $name
            );

            $created = $this->sRole->create($input);
            if(!$created['status'])
            {
                alert()->error('Error', $created['message']);
                return redirect()->back()->withInput();
            }
        } elseif($mode=='edit')
        {
            $input = array(
                'name'       => $name,
                'is_active'  => $status,
                'updated_at' => date('Y-m-d H:i:s')
            );

            $updated = $this->sRole->update($role_id, $input);
            if(!$updated['status'])
            {
                alert()->error('Error', $updated['message']);
                return redirect()->back()->withInput();
            }
        }

        alert()->success('Success', 'Data updated successfully');
        return redirect()->route('role.index');
    }

    public function checkData($field, $keyword)
    {
        $role = $this->sRole->findData($field, $keyword);
        return ($role) ? 0 : 1;
    }
}
