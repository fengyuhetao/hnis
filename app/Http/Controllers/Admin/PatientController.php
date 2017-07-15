<?php
/**
 * Created by PhpStorm.
 * User: HT
 * Date: 2017/03/31
 * Time: 20:09
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\patientRequest;
use App\Service\Admin\PatientService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class PatientController extends Controller
{
    private $patientService;

    public function __construct(PatientService $patientService)
    {
        $this->patientService = $patientService;
    }

    // get.admin/patient
    public function index()
    {
        return view('admin.patient.list');
    }

    //get.admin/patient/create      添加医生界面
    public function create()
    {
        return view('admin.patient.add');
    }

    //post.admin/patient    添加患者提交
    public function store(PatientRequest $request)
    {
        $file = null != $request->file('pat_face') ? $request->file('pat_face') : null;
        $data = $this->patientService->addPatient($request->except(['_token']), $file);
        if(strpos($request->server('HTTP_REFERER'), 'add') !== false) {
            return redirect('admin/patient');
        }

        return json_encode($data);
    }

    // get.admin/patient/{patient}/edit     编辑用户信息界面
    public function edit($pat_id)
    {
        $patient = $this->patientService->getPatientById($pat_id);
        return view('admin.patient.edit')->with(compact('patient'));
    }

    // put.admin/patient/{cate}       更新用户信息
    public function update(patientRequest $request, $pat_id)
    {
        $file = null != $request->file('pat_face') ? $request->file('pat_face') : null;
        $data = $this->patientService->updatePatient($request->except('_token', '_method'), $pat_id, $file);
        if(strpos($request->server('HTTP_REFERER'), 'edit') !== false) {
            return redirect('admin/doctor');
        }
        return json_encode($data);
    }

    // delete.admin/patient/{patient}
    public function destroy($pat_id)
    {
        $data = $this->patientService->destroyPatient($pat_id);
        return json_encode($data);
    }

    public function ajaxGetPatientList()
    {
        $params = Input::except('_token', '_');
        return json_encode($this->patientService->getPatientList($params));
    }

    public function getpatientById()
    {
        $pat_id = Input::get('pat_id');
        return json_encode($this->patientService->getPatientById($pat_id));
    }


    public function regist(Request $request)
    {
        $attributes = array();
        $attributes['pat_nickname'] = $request->get('username');
        $attributes['pat_tel'] = $request->get('tel');
        $attributes['pat_password'] = $request->get('password');
        $attributes['pat_addtime'] = date('Y-m-d h:i:s');

        $data = $this->patientService->addPatient($attributes);
        return $request->get('callback') ."(". json_encode($data).")";
    }

    public function ajaxGetPatientFollows(Request $request)
    {
        $limit = 6;
        $page = $request->get('page');
        $pat_id = $request->get('pat_id');
        $data = $this->patientService->ajaxGetPatientFollows($page, $pat_id, 6);
        return "my(".json_encode($data).")";
    }

    public function ajaxGetPatientComments(Request $request)
    {
        $limit = 6;
        $page = $request->get('page');
        $pat_id = $request->get('$pat_id');
        $data = $this->patientService->ajaxGetPatientComments($page, $pat_id, 6);
        return "my(".json_encode($data).")";
    }

    public function getFollowInfo(Request $request)
    {
//        获取所有诊断数目
        $total_number = $this->patientService->getFollowTotalNumber($request->get('pat_id'));
//        获取所有页数
        $page = ceil($total_number / 6);

//        获取医生信息
        $patient = $this->patientService->getPatientById($request->get('pat_id'));
        $data['total_number'] = $total_number;
        $data['page'] = $page;
        $data['patient'] = $patient;
        return json_encode($data);
    }

    public function getCommentInfo(Request $request)
    {
        //        获取所有评论数目
        $total_number = $this->patientService->getComentsTotalNumber($request->get('pat_id'));
//        获取所有页数
        $page = ceil($total_number / 6);

//        获取患者信息
        $patient = $this->patientService->getPatientById($request->get('pat_id'));
        $data['total_number'] = $total_number;
        $data['page'] = $page;
        $data['patient'] = $patient;
        return json_encode($data);
    }

    public function getCommentsByPatId(Request $request)
    {
        $limit = 6;
        $page = $request->get('page');
        $pat_id = $request->get('pat_id');
        $data = $this->patientService->getCommentsByPatId($page, $pat_id, 6);
        return "my(".json_encode($data).")";
    }

    public function ajaxUpdatePatient(Request $request)
    {
        $pat_id = $request->get('pat_id');
        $data = $this->patientService->updatePatient($request->except( 'pat_id'), $pat_id);
        return json_encode($data);
    }

    public function patientResetPassword(Request $request)
    {
        $pat_id = $request->get('pat_id');
        $data = $this->patientService->patientResetPassword($request->except('pat_id', 'callback', '_'), $pat_id);
        return "my(".json_encode($data) .")";
    }
}