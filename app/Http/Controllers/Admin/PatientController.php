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
        $data = $this->patientService->addPatient($request->except(['_token']));
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
        $data = $this->patientService->updatePatient($request->except('_token', '_method', 'method', 'uri', 'ip', 'pri_id'), $pat_id);
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

    public function getPatientById()
    {
        $pat_id = Input::get('pat_id');
//        return json_encode($this->patientService->getPatientById($pat_id));
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

}