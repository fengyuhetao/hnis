<?php
/**
 * Created by PhpStorm.
 * User: HT
 * Date: 2017/03/21
 * Time: 15:56
 */

namespace App\Service\Admin;

use App\Repository\Eloquent\RoleRepositoryEloquent;

class RoleService
{
    private $role;

    private $return;

    function __construct(RoleRepositoryEloquent $role)
    {
        $this->role = $role;
        $this->return['code'] = 1;
    }

    public function getRoleList()
    {
        $data = $this->role->all()->toArray();

        return $data;
    }

    public function getRoleByRoleId($roleId)
    {
        $data = $this->role->find($roleId);
        return $data;
    }

    /**
     * @param $role
     * @return array
     */
    public function getPrivilegesByRole($role)
    {
        $data = $role->privileges->toArray();
//        处理一下$data
        $array = array();
        if($data) {
            foreach ($data as $v) {
                $array[] = $v['pri_id'];
            }
        }
        return $array;
    }

    public function getPrivlegesByRoleId($role_id)
    {
        $data = $this->role->find($role_id)->privileges->toArray();
        return $data;
    }

    public function deleteRole($role_id)
    {
        $role = $this->role->find($role_id);
        $role->privileges()->detach();
        $role->admins()->detach();
        if (!($result = $this->role->deleteWhere(array('role_id' => $role_id)))) {
            $this->return['code'] = 0;
            $this->return['result'] = "出现异常";
        }

        return $this->return;
    }

    public function insertRole($attributes, $pris)
    {
        $attributes['role_addtime'] = date('Y-m-d H:i:s');
//        添加角色
        if(!($role = $this->role->create($attributes))) {
            $this->return['code'] = 0;
            $this->return['result'] = "出现异常";
            return $this->return;
        }

//        为角色添加权限
        $role->privileges()->attach($pris);
//        添加角色相关的权限
        return $this->return;
    }

    public function updateRole($roleId, $attributes, $pris)
    {
        $role = null;
        if(!($role = $this->role->update($attributes, $roleId))) {
            $this->return['code'] = 0;
            $this->return['result'] = "出现异常";
            return $this->return;
        }

        // 清除原来所有的权限
        $role->privileges()->detach();

        // 添加新的权限
        $role->privileges()->attach($pris);

        return $this->return;
    }

}