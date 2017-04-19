<?php
/**
 * Created by PhpStorm.
 * User: HT
 * Date: 2017/03/26
 * Time: 23:36
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service\Admin\AdminService;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    private $adminService;
    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    //图片上传
    public function uploadFile(Request $request)
    {
        $admin_id = $request->input("admin_id");
        $file = $request->file('admin_pic');
        $this->adminService->deletePicByAdminId($admin_id);
        if($file -> isValid()){
            $entension = $file -> getClientOriginalExtension(); //上传文件的后缀.
//            判断后缀是否符合规则

            $newName = date('YmdHis').mt_rand(100,999).'.'.$entension;
            $path = $file -> move(base_path().'/uploads',$newName);
            $filepath = url("/") .'/uploads/'.$newName;
            $attributes = ['admin_pic' => $filepath];
            // 调用service里面的方法
            $this->adminService->updateAdmin($attributes, $admin_id);
            return json_encode($attributes);
        } else {
            echo "失败";
        }
    }

    //图片上传
    public function upload(Request $request)
    {
        $admin_id = $request->input("admin_id");
        $file = $request->file('admin_pic');
        $attributes = upload_pic($file);
        if(!isset($attributes['failed'])) {
            $this->adminService->deletePicByAdminId($admin_id);
            $this->adminService->updateAdmin($attributes, $admin_id);
        }
        return json_encode($attributes);
    }
}