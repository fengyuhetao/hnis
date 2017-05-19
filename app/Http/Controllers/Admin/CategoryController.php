<?php
/**
 * Created by PhpStorm.
 * User: HT
 * Date: 2017/03/31
 * Time: 20:09
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Service\Admin\CategoryService;
use Illuminate\Support\Facades\Input;

class CategoryController extends Controller
{
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    // get.admin/Category
    public function index()
    {
//            throw new HttpException(303, "haha1");
//            考虑到管理员数目不会很多，所以就不分页了
        return view('admin.category.list');
    }

    //get.admin/Category/create      添加权限界面
    public function create()
    {

    }

    //post.admin/Category    添加权限提交
    public function store(CategoryRequest $request)
    {
        $data = $this->categoryService->addCategory($request->except(['_token']));
        return json_encode($data);
    }

    // get.admin/Category/{Category}/edit     编辑用户信息界面
    public function edit($cate_id)
    {
//            form_editable.html
    }

    // put.admin/Category/{cate}       更新用户信息
    public function update(CategoryRequest $request, $cate_id)
    {
        $data = $this->categoryService->updateCategory($request->except('_token', '_method', 'method', 'uri', 'ip', 'pri_id'), $cate_id);
        return json_encode($data);
    }

    // delete.admin/Category/{cate}
    public function destroy($cate_id)
    {
        $data = $this->categoryService->destroyCategory($cate_id);
        return json_encode($data);
    }

    public function ajaxGetCategoryList()
    {
        return json_encode($this->categoryService->getCategoryList());
    }

    public function getCategoryById()
    {
        $cate_id = Input::get('cate_id');
        return json_encode($this->categoryService->getCategoryById($cate_id));
    }

    public function getCategorysByParentId()
    {
        $cate_pid = Input::get('cate_pid');
        return json_encode($this->categoryService->getCategorysByParentId($cate_pid));
    }

    public function getSecondLevelCategory()
    {
        $data = $this->categoryService->getSecondLevelCategory();
        return json_encode($data);
    }
}