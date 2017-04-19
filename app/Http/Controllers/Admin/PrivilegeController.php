<?php
/**
 * Created by PhpStorm.
 * User: HT
 * Date: 2017/03/31
 * Time: 20:09
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\PrivilegeRequest;
use App\Service\Admin\PrivilegeService;
use Illuminate\Support\Facades\Input;

class PrivilegeController extends Controller
{
    private $privilegeService;

    public function __construct(PrivilegeService $privilegeService)
    {
        $this->privilegeService = $privilegeService;
    }

    // get.admin/privilege
    public function index()
    {
//            throw new HttpException(303, "haha1");
//            考虑到管理员数目不会很多，所以就不分页了
        return view('admin.privilege.list');
    }

    //get.admin/privilege/create      添加权限界面
    public function create()
    {

    }

    //post.admin/privilege    添加权限提交
    public function store(PrivilegeRequest $request)
    {
        $data = $this->privilegeService->addPrivilege($request->except(['_token']));
        return json_encode($data);
    }

    // get.admin/privilege/{privilege}/edit     编辑用户信息界面
    public function edit($admin_id)
    {
//            form_editable.html
    }

    // put.admin/privilege/{pri}       更新用户信息
    public function update(PrivilegeRequest $request, $pri_id)
    {
        $data = $this->privilegeService->updatePrivilege($request->except('_token', '_method', 'method', 'uri', 'ip', 'pri_id'), $pri_id);
        return json_encode($data);
    }

    // delete.admin/privilege/{pri}
    public function destroy($pri_id)
    {
        $data = $this->privilegeService->destroyPrivilege($pri_id);
        return json_encode($data);
    }

    public function ajaxGetPrivilegeList()
    {
        return json_encode($this->privilegeService->getPrivilegeList());
    }

    public function getPrivilegeById()
    {
        $pri_id = Input::get('pri_id');
        return json_encode($this->privilegeService->getPrivilegeById($pri_id));
    }
}