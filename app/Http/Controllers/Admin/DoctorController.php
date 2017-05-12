<?php
/**
 * Created by PhpStorm.
 * User: HT
 * Date: 2017/03/31
 * Time: 20:09
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\doctorRequest;
use App\Service\Admin\DoctorService;
use Illuminate\Support\Facades\Input;

class DoctorController extends Controller
{
    private $doctorService;

    public function __construct(DoctorService $doctorService)
    {
        $this->doctorService = $doctorService;
    }

    // get.admin/doctor
    public function index()
    {
//            throw new HttpException(303, "haha1");
//            考虑到管理员数目不会很多，所以就不分页了
        return view('admin.doctor.list');
    }

    //get.admin/doctor/create      添加医生界面
    public function create()
    {
        return view('admin.doctor.add');
    }

    //post.admin/doctor    添加权限提交
    public function store(doctorRequest $request)
    {
        $data = $this->doctorService->adddoctor($request->except(['_token']));
        return json_encode($data);
    }

    // get.admin/doctor/{doctor}/edit     编辑用户信息界面
    public function edit($cate_id)
    {
        return view('admin.doctor.edit');
    }

    // put.admin/doctor/{cate}       更新用户信息
    public function update(doctorRequest $request, $cate_id)
    {
        $data = $this->doctorService->updatedoctor($request->except('_token', '_method', 'method', 'uri', 'ip', 'pri_id'), $cate_id);
        return json_encode($data);
    }

    // delete.admin/doctor/{cate}
    public function destroy($cate_id)
    {
        $data = $this->doctorService->destroydoctor($cate_id);
        return json_encode($data);
    }

    public function ajaxGetdoctorList()
    {
        $params = Input::except('_token', '_');
        return json_encode($this->doctorService->getdoctorList($params));
    }

    public function getdoctorById()
    {
        $cate_id = Input::get('cate_id');
        return json_encode($this->doctorService->getdoctorById($cate_id));
    }

}