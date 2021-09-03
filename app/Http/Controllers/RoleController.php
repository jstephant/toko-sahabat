<?php

namespace App\Http\Controllers;

use App\Http\Requests\Role\RoleRequest;
use App\Services\Feature\SFeature;
use App\Services\Roles\SRole;
use App\Services\SGlobal;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    private $sGlobal;
    private $sRole;
    private $sFeature;

    public  function __construct(SGlobal $sGlobal, SRole $sRole, SFeature $sFeature)
    {
        $this->sGlobal = $sGlobal;
        $this->sRole = $sRole;
        $this->sFeature = $sFeature;
    }

    public function index()
    {
        $data = array(
            'title'       => 'Roles',
            'active_menu' => 'Roles',
            'edit_mode'   => 0
        );

        if(!Session::has('user_id'))
        {
            return redirect('/');
        }

        $my_menu = $this->sGlobal->getDetailActiveMenu($this->feature_id);

        $roles = $this->sRole->getAll();

        $feature_roles = $this->sRole->getAllFeatureRoleActive();

        $data = array(
            'title'         => 'Role',
            'active_menu'   => 'Role',
            'edit_mode'     => 0,
            'my_menu'       => collect($my_menu),
            'roles'         => $roles,
            'feature_roles' => $feature_roles
        );

        return $this->sGlobal->view('role.index', $data);

        return $this->sGlobal->view('role.index', $data);
    }

    public function listRole(Request $request)
    {
        $roles = $this->sRole->listRole($request->keyword, $request->start, $request->length, $request->order);
        $roles['draw'] = $request->draw;

        return $roles;
    }

    public function listPermission(Request $request)
    {
        $role = $this->sRole->findDetailById($request->id);
        if(count($role)==0)
        {
            $roles = array(
                'recordsTotal'    => 0,
                'recordsFiltered' => 0,
                'data'            => [],
                'draw'            => $request->draw
            );
            return $roles;
        }

        $menu = array();
        $features = $this->sFeature->getMenuByParent();

        foreach ($features as $value) {
			$detail = $this->sRole->findDetailById($request->id, $value->id);
            $menu[] = array(
				'id' 		         => $value->id,
				'name' 		         => $value->name,
				'parent_id'          => $value->parent_id,
				'is_access'	         => $value->is_access,
				'is_create'	         => $value->is_create,
				'is_edit'	         => $value->is_edit,
				'is_delete'	         => $value->is_delete,
				'is_approval'        => $value->is_approval,
                'is_landing_page'    => $value->is_landing_page,
                'detail_is_access'   => ($detail) ? $detail->is_access : false,
                'detail_is_create'   => ($detail) ? $detail->is_create : false,
                'detail_is_edit'     => ($detail) ? $detail->is_edit : false,
                'detail_is_delete'   => ($detail) ? $detail->is_delete : false,
                'detail_is_approval' => ($detail) ? $detail->is_approval : false,
                'detail_is_landing_page' => ($detail) ? $detail->is_landing_page : false
            );
            if($value->has_sub_menu===true)
            {
                $sub_menu = $this->sFeature->getMenuByParent($value->id);
                foreach ($sub_menu as  $value2) {
                    $detail2 = $this->sRole->findDetailById($request->id, $value2->id);
                    $menu[] = array(
                        'id' 		         => $value2->id,
                        'name' 		         => $value2->name,
                        'parent_id'          => $value2->parent_id,
						'is_access'	         => $value2->is_access,
                        'is_create'	         => $value2->is_create,
                        'is_edit'	         => $value2->is_edit,
                        'is_delete'	         => $value2->is_delete,
                        'is_approval'        => $value2->is_approval,
                        'is_landing_page'    => $value2->is_landing_page,
                        'detail_is_access'   => ($detail2) ? $detail2->is_access : false,
                        'detail_is_create'   => ($detail2) ? $detail2->is_create : false,
                        'detail_is_edit'     => ($detail2) ? $detail2->is_edit : false,
                        'detail_is_delete'   => ($detail2) ? $detail2->is_delete : false,
                        'detail_is_approval' => ($detail2) ? $detail2->is_approval : false,
                        'detail_is_landing_page' => ($detail2) ? $detail2->is_landing_page : false
                    );
                }
            }
        }

        $roles = array(
            'recordsTotal'    => count($menu),
            'recordsFiltered' => count($menu),
            'data'            => $menu,
            'draw'            => $request->draw
        );
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
