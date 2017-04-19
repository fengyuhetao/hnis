<?php
/**
 * Created by PhpStorm.
 * User: HT
 * Date: 2017/03/21
 * Time: 15:56
 */

namespace App\Service\Admin;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Repository\Eloquent\AdminRepositoryEloquent;

class AdminService
{
    private $admin;

    private $return;

    function __construct(AdminRepositoryEloquent $admin)
    {
        $this->admin = $admin;
        $this->return['code'] = 1;
    }

    function checkLogin($input)
    {
        $return = array(
            'failReason' => ''
        );
        $adminInfo = $this->admin->findByField('admin_username', $input['username'])->first();
        if(null !== $adminInfo && Hash::check($input['password'], $adminInfo->admin_password)) {
                return $adminInfo;
        } else {
            $return['failReason'] = '用户名或密码错误';
            return $return;
        }
    }

    function getAdminList()
    {
        return $this->admin->orderBy('admin_id', 'desc')->all();
    }

    function deleteAdmin($admin_id)
    {
        $admin = $this->admin->find($admin_id);

        $admin->roles()->detach();

        if(!($result = $this->admin->deleteWhere(array('admin_id' => $admin_id)))) {
            $this->return['code'] = 0;
            $this->return['result'] = $result;
            return $this->return;
        }

        return $this->return;
    }

    function updateAdmin($attributes, $admin_id, $roles = null, $file = null)
    {
        $result = null;
        $path = array();
//        上传图片
//        判断是否上传了图片
        if($file != null) {
            $path = upload_pic($file);

            if(isset($path['failed'])) {
                $this->return['code'] = 0;
                $this->return['result'] = "图片上传失败";
                return $this->return;
            }

            $attributes['admin_pic'] = $path['admin_pic'];
        }

//        修改最近修改时间
        $attributes['admin_updatetime'] = date("Y-m-d H:i:s");
        try {
            if(!($result = $this->admin->update($attributes, $admin_id))) {
                $this->return['code'] = 0;
                $this->return['result'] = $result;
                return $this->return;
            }

            $result->roles()->detach();
            $result->roles()->attach($roles);

        } catch (Exception $e) {
            // 错误信息发送邮件
            $this->return['code'] = 0;
            $this->return['result'] = "发生未知错误";
        }

        return $this->return;
    }

    /**
     * 通过adminId删除员工图片
     */
    function deletePicByAdminId($admin_id) {
        $admin = $this->admin->find($admin_id, ['admin_pic']);
//        移除该用户所有角色
        $admin->roles()->detach();
        if($admin->admin_pic) {
//        获取地址
            $pic = substr($admin->admin_pic, strlen(url("/")) + 1);
            @unlink($pic);
        }
    }

    function getAdminById($admin_id)
    {
        return $this->admin->find($admin_id);
    }

    public function getRolesOfAdminById($admin_id)
    {
        return $this->admin->find($admin_id)->roles;
    }

    public function getRolesByAdmin($admindata)
    {
        $data = $admindata->roles->toArray();
        $array = array();
        foreach ($data as $v) {
            $array[] = $v['role_id'];
        }

        return $array;
    }

    public function insertAdmin($attributes, $roles, $file = null)
    {
        $path = array();
//        上传图片
//        判断是否上传了图片
        if($file != null) {
            $path = upload_pic($file);

            if(isset($path['failed'])) {
                $this->return['code'] = 0;
                $this->return['result'] = "图片上传失败";
                return $this->return;
            }

            $attributes['admin_pic'] = $path['admin_pic'];
        }

        $attributes['admin_addtime'] = date('Y-m-d H:i:s');
        $attributes['admin_updatetime'] = date('Y-m-d H:i:s');
        $attributes['admin_adder'] = session('user')->admin_name;

        $admin = $this->admin->create($attributes);

        if(!$admin) {
            $this->return['code'] = 0;
            $this->return['result'] = "数据库插入失败";
            return $this->return;
        }

        $admin->roles()->attach($roles);

        return $this->return;
    }
}