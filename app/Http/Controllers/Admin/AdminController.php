<?php
    namespace App\Http\Controllers\Admin;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\AdminRequest;
    use App\Service\Admin\AdminService;
    use App\Service\Admin\RoleService;
    use Illuminate\Support\Facades\Log;

    class AdminController extends Controller
    {
        private $adminService;

        private $roleService;

        public function __construct(AdminService $adminService, RoleService $roleService)
        {
            $this->adminService = $adminService;
            $this->roleService = $roleService;
        }

        // get.admin/admin
        public function index()
        {
//            Log::info('This is some useful1 information.');
//            throw new HttpException(303, "haha1");
//            考虑到管理员数目不会很多，所以就不分页了
            $data = $this->adminService->getAdminList();
            return view('admin.admin.list')->with(compact('data'));
        }

        //get.admin/admin/create      添加用户界面
        public function create()
        {
//            获取所有角色
            $roles = $this->roleService->getRoleList();
            return view('admin.admin.add')->with(compact('roles'));
        }

        //post.admin/admin    添加用户提交
        public function store(AdminRequest $request)
        {
            $file = null != $request->file('admin_pic') ? $request->file('admin_pic') : null;

            $this->adminService->insertAdmin($request->except('token', 'roles'), $request->get('roles'), $file);

            return redirect('admin/admin');
        }

        // get.admin/admin/{article}/edit     编辑管理员信息界面
        public function edit($admin_id)
        {
//            获取该管理员信息
            $admindata = $this->adminService->getAdminById($admin_id);

//            获取该管理员所属角色
            $adminRoles = $this->adminService->getRolesByAdmin($admindata);

//            获取所有角色
            $roles = $this->roleService->getRoleList();

            return view('admin.admin.edit')->with(compact('admindata', 'adminRoles', 'roles'));
        }

        // put.admin/admin/{admin_id}       更新用户信息
        public function update(AdminRequest $request, $admin_id)
        {
            $file = null != $request->file('admin_pic') ? $request->file('admin_pic') : null;
            $roles = null != $request->get('roles') ? $request->get('roles') : null;
            $data = $this->adminService->updateAdmin($request->except('_token', '_method', 'value', 'pk', 'name', 'roles', 'admin_pic'), $admin_id, $roles, $file);
            if(strpos($request->server('HTTP_REFERER'), 'edit') !== false) {
                return redirect('admin/admin');
            }
            return json_encode($data);
        }

        // delete.admin/admin/{article}
        public function destroy($admin_id)
        {
            $data = $this->adminService->deleteAdmin($admin_id);
            return json_encode($data);
        }
    }