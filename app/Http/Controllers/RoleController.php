<?php

namespace App\Http\Controllers;

use App\Http\Requests\Role\RoleRequest;
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

    public function doSave(RoleRequest $request)
    {
        $validated = $request->validated();

        $data = array(
            'status'  => true,
            'message' => ''
        );

        $mode = $request->mode;
        $role_id = $request->role_id;
        $name = $request->name;
        $status = $request->status;
        $active_user = $request->session()->get('id');

        if($mode=='create')
        {
            $input = array(
                'name'       => $name,
                'created_by' => $active_user
            );

            $created = $this->sRole->create($input);
            if(!$created['status'])
            {
                $data['status'] = $created['status'];
                $data['message'] = $created['message'];
                return response()->json($data, 200);
            }
        } elseif($mode=='edit')
        {
            $input = array(
                'name'       => $name,
                'is_active'  => $status,
                'updated_by' => $active_user,
                'updated_at' => date('Y-m-d H:i:s')
            );

            $updated = $this->sRole->update($role_id, $input);
            if(!$updated['status'])
            {
                $data['status'] = $updated['status'];
                $data['message'] = $updated['message'];
                return response()->json($data, 200);
            }
        }

        $request->session()->put('success', 'Data berhasil diupdate');
        return response()->json($data, 200);
    }

    public function doDelete($id)
    {
        $deleted = $this->sRole->delete($id);
        if(!$deleted['status'])
        {
            return redirect()->back()->with('error', $deleted['message']);
        }
        return redirect()->route('role.index')->with('success', 'Data berhasil dihapus');
    }
}
