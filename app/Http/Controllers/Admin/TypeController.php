<?php
/**
 * Created by PhpStorm.
 * User: HT
 * Date: 2017/03/31
 * Time: 20:09
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\TypeRequest;
use App\Service\Admin\TypeService;
use Illuminate\Support\Facades\Input;

class TypeController extends Controller
{
    private $typeService;

    public function __construct(TypeService $typeService)
    {
        $this->typeService = $typeService;
    }

    // get.admin/Category
    public function index()
    {
//            throw new HttpException(303, "haha1");
//            考虑到管理员数目不会很多，所以就不分页了
        return view('admin.type.list');
    }

    //get.admin/Category/create      添加权限界面
    public function create()
    {

    }

    //post.admin/Category    添加权限提交
    public function store(TypeRequest $request)
    {
        $data = $this->typeService->addType($request->except(['_token']));
        return json_encode($data);
    }

    // get.admin/Category/{Category}/edit     编辑用户信息界面
    public function edit($cate_id)
    {
//            form_editable.html
    }

    // put.admin/Category/{Type}       更新用户信息
    public function update(TypeRequest $request, $type_id)
    {
        $data = $this->typeService->updateType($request->except('_token', '_method', 'method', 'uri', 'ip', 'pri_id'), $type_id);
        return json_encode($data);
    }

    // delete.admin/Category/{type}
    public function destroy($type_id)
    {
        $data = $this->typeService->destroyType($type_id);
        return json_encode($data);
    }

    public function ajaxGetTypeList()
    {
        $params = Input::except('_token', '_');
        return json_encode($this->typeService->getTypeList($params));
    }

    public function getTypeById()
    {
        $cate_id = Input::get('type_id');
        return json_encode($this->typeService->getTypeById($cate_id));
    }
}