<?php
/**
 * Created by PhpStorm.
 * User: HT
 * Date: 2017/04/07
 * Time: 19:51
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Service\Admin\PrivilegeService;
use App\Service\Admin\RoleService;
use Illuminate\Support\Facades\Input;

class RoleController extends Controller
{
    private $roleService;
    private $privilegeService;

    public function __construct(RoleService $roleService, PrivilegeService $privilegeService)
    {
        $this->roleService = $roleService;
        $this->privilegeService = $privilegeService;
    }

//    get.admin/role
    public function index()
    {
        $data = $this->roleService->getRoleList();
        return view('admin.role.list')->with(compact('data'));
    }

//    get.admin/role/create
    public function create()
    {
        $data = null;
//        获取所有权限
        $data = $this->privilegeService->getPrivilegeList();
        if (isset($data['children'])) {
            $data = $data['children'];
        }
        return view('admin.role.add')->with(compact('data'));
    }

//    post.admin/role
    public function store(RoleRequest $request)
    {
        $this->roleService->insertRole($request->except('_token', 'pris'), $request->get('pris'));
        return redirect('admin/role');
    }

//    get.admin/role/{roleId}/edit
    public function edit($roleId)
    {
        $data = null;
        $roledata = null;
        $rolePris = null;

//        获取角色相关信息
        $roledata = $this->roleService->getRoleByRoleId($roleId);

        $rolePris = $this->roleService->getPrivilegesByRole($roledata);

//        获取所有权限
        $data = $this->privilegeService->getPrivilegeList();

        if (isset($data['children'])) {
            $data = $data['children'];
        }
        return view('admin.role.edit')->with(compact('roledata', 'data', 'rolePris'));
    }

//    put.admin/role/{roleId}
    public function update(RoleRequest $request, $roleId)
    {
        $attributes = $request->except('_token', '_method', 'pris');
        $pris = $request->get('pris');
        $data = $this->roleService->updateRole($roleId, $attributes, $pris);
        return redirect('admin/role');
    }

//    delete.admin/role/{roleId}
    public function destroy($role_id)
    {
        $data = $this->roleService->deleteRole($role_id);
        return json_encode($data);
    }

    public function ajaxGetRolesByRoleId()
    {
        $role_id = Input::get('role_id');
        $data = $this->roleService->getPrivlegesByRoleId($role_id);
        $data = $this->privilegeService->priListToTreePart($data);

        return json_encode($data);
    }
}