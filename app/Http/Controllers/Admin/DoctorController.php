<?php
/**
 * Created by PhpStorm.
 * User: HT
 * Date: 2017/03/31
 * Time: 20:09
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\DoctorRequest;
use App\Service\Admin\CategoryService;
use App\Service\Admin\CommentService;
use App\Service\Admin\DoctorService;
use App\Service\Admin\TypeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class DoctorController extends Controller
{
    private $doctorService;
    private $commentService;
    private $typeService;
    private $categoryService;

    public function __construct(DoctorService $doctorService, CommentService $commonService, TypeService $typeService, CategoryService $categoryService)
    {
        $this->doctorService = $doctorService;
        $this->commentService = $commonService;
        $this->typeService = $typeService;
        $this->categoryService = $categoryService;
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
        //        查询所有分类
        $categorys = $this->categoryService->getAllCategorys();
//        查询所有类型
        $types = $this->typeService->getAllType();

        return view('admin.doctor.add')->with(compact('categorys', 'types'));
    }

    //post.admin/doctor    添加权限提交
    public function store(DoctorRequest $request)
    {

        $file = null != $request->file('doc_face') ? $request->file('doc_face') : null;
        $data = $this->doctorService->adddoctor($request->except(['_token']), $file);
        if(strpos($request->server('HTTP_REFERER'), 'add') !== false) {
            return redirect('admin/doctor');
        }
        return json_encode($data);
    }

    // get.admin/doctor/{doctor}/edit     编辑用户信息界面
    public function edit($doc_id)
    {
//        查询所有分类
        $categorys = $this->categoryService->getAllCategorys();
//        查询所有类型
        $types = $this->typeService->getAllType();
        $doctor = $this->doctorService->getDoctorById($doc_id);
        return view('admin.doctor.edit')->with(compact('doctor', 'types', 'categorys'));
    }

    // put.admin/doctor/{doc_id}       更新用户信息
    public function update(doctorRequest $request, $doc_id)
    {
        $file = null != $request->file('doc_face') ? $request->file('doc_face') : null;
        $data = $this->doctorService->updateDoctor($request->except('_token', '_method'), $doc_id, $file);
        if(strpos($request->server('HTTP_REFERER'), 'edit') !== false) {
            return redirect('admin/doctor');
        }
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
        $doc_id = Input::get('doc_id');
        return json_encode($this->doctorService->getDoctorById($doc_id));
    }

    public function getPortalData()
    {
        $carousels = $this->doctorService->getCarousels();
//        从二级分类下获取医生
//        外科获取7个医生
        $doctors = $this->doctorService->getPortalDoctors();

        $data = array(
            'carousels' => $carousels,
            'portalDoctors' => $doctors
        );

        return json_encode($data);
    }

    public function getDoctorsByWhere(Request $request)
    {
        $doctors = $this->doctorService->getDoctorsByWhere($request->all());
        return json_encode($doctors);
    }

    public function getDoctorAllInfoById(Request $request)
    {
        $doc_id = $request->get('doc_id');
        // 获取医生的个人信息
        $doctor = $this->doctorService->getDoctorById($request->get('doc_id'));

        //获取医生的4条最近评论
        $comments = $this->doctorService->getDoctorComments($doc_id);

//         获取医生的最近的4个诊断患者
        $patients = $this->doctorService->getDoctorPatients($doc_id);

        $data['doctor'] = $doctor;
        $data['comments'] = $comments;
        $data['patient'] = $patients;

        return json_encode($data);
    }

    public function follow(Request $request)
    {
        $doc_id = $request->get('doc_id');
        $pat_id= $request->get('pat_id');
        $result = $this->doctorService->follow($doc_id, $pat_id);
        return $result;
    }
    public function zan(Request $request)
    {
        $doc_id = $request->get('doc_id');
        $result = $this->doctorService->zan($doc_id);
        return $result;
    }

    public function hate(Request $request)
    {
        $doc_id = $request->get('doc_id');
        $result = $this->doctorService->hate($doc_id);
        return $result;
    }

    public function getDoctorPartInfoById(Request $request)
    {
        $doc_id = $request->get('doc_id');
        // 获取医生的个人信息
        $doctor = $this->doctorService->getDoctorById($request->get('doc_id'));

//        获取与该医生相同科室的其他医生
        $doctors = $this->doctorService->getDoctorByCateId($doctor['cate_id'], $doc_id);

        $total_number = $this->doctorService->getDoctorCommentsTotalNumber($doc_id);

        //        获取评论的页数
        $total_page = ceil($total_number / 6);
        $data['doctor'] = $doctor;
        $data['doctors'] = $doctors;
        $data['total_page'] = $total_page;
        $data['total_number'] = $total_number;
        return json_encode($data);
    }

    public function ajaxGetDoctorComments(Request $request)
    {
        $limit = 6;
        $page = $request->get('page');
        $doc_id = $request->get('doc_id');
        $data = $this->doctorService->ajaxGetDoctorComments($page, $doc_id, 6);
        return "my(".json_encode($data).")";
    }

    public function ajaxUpdateDoctor(Request $request) {
        $doc_id = $request->get('doc_id');
        $data= $this->doctorService->updateDoctor($request->except('doc_id', 'callback', '_'), $doc_id);
        return json_encode($data);
    }

    public function doctorResetPassword(Request $request) {
        $doc_id = $request->get('doc_id');
        $data = $this->doctorService->doctorResetPassword($request->except('doc_id', 'callback', '_'), $doc_id);
        return "my(".json_encode($data) .")";
    }

    public function ajaxGetDoctorDiagnoses(Request $request)
    {
        $limit = 6;
        $page = $request->get('page');
        $doc_id = $request->get('doc_id');
        $data = $this->doctorService->ajaxGetDoctorDiagnoses($page, $doc_id, 6);
        return "my(".json_encode($data).")";
    }

    public function ajaxGetDoctorFolloweds(Request $request)
    {
        $limit = 6;
        $page = $request->get('page');
        $doc_id = $request->get('doc_id');
        $data = $this->doctorService->ajaxGetDoctorFolloweds($page, $doc_id, 6);
        return "my(".json_encode($data).")";
    }

    public function getDiagnoseInfo(Request $request)
    {
//        获取所有诊断数目
        $total_number = $this->doctorService->getDiangnoseTotalNumber($request->get('doc_id'));
//        获取所有页数
        $page = ceil($total_number / 6);

//        获取医生信息
        $doctor = $this->doctorService->getDoctorById($request->get('doc_id'));
        $data['total_number'] = $total_number;
        $data['page'] = $page;
        $data['doctor'] = $doctor;
        return json_encode($data);
    }

    public function getFollowedInfo(Request $request)
    {
        //        获取所有追随者数目
        $total_number = $this->doctorService->getFollowedTotalNumber($request->get('doc_id'));
//        获取所有页数
        $page = ceil($total_number / 6);

//        获取医生信息
        $doctor = $this->doctorService->getDoctorById($request->get('doc_id'));
        $data['total_number'] = $total_number;
        $data['page'] = $page;
        $data['doctor'] = $doctor;
        return json_encode($data);
    }

    public function changeOnline(Request $request) {
        $doc_id = $request->get('doc_id');
        $is_online = $request->get('is_online');
        return $this->doctorService->changeOnline($doc_id, $is_online);
    }
}