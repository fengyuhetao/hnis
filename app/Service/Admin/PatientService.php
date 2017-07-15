<?php
/**
 * Created by PhpStorm.
 * User: HT
 * Date: 2017/03/31
 * Time: 20:08
 */

namespace App\Service\Admin;

use App\Repository\Eloquent\PatientRepositoryEloquent;
use Exception;
use Illuminate\Support\Facades\Hash;

class PatientService
{
    private $patient;

    public function __construct(PatientRepositoryEloquent $patient)
    {
        $this->patient = $patient;
    }

    /**
     * 更新医生信息
     * @param $attributes
     * @param $doc_id
     * @return array
     */
    public function updatePatient($attributes, $pat_id, $file)
    {
        $data = array(
            'code' => 1
        );

        $path = array();
//        上传图片
//        判断是否上传了图片
        if($file != null) {
            $path = upload_pic($file, 'pat_face');

            if(isset($path['failed'])) {
                $data['code'] = 0;
                $data['result'] = "图片上传失败";
                return $data;
            }

            $attributes['pat_face'] = $path['pat_face'];
        }

        foreach ($attributes as $k => $v) {
            if($v == "") {
                unset($attributes[$k]);
            }
        }
        try {
            if(!($result = $this->patient->update($attributes, $pat_id))) {
                $data['code'] = 0;
                $data['result'] = $result;
            }
        } catch (Exception $e) {
//            echo $e->getMessage();
            // 错误信息发送邮件
            $data['code'] = 0;
            $data['result'] = "发生未知错误";
        }

        return $data;
    }

    /**
     * 添加医生
     * @param $attributes
     * @return array
     */
    public function addPatient($attributes, $file = null)
    {
        $data = array(
            'code' => 1
        );

        $path = array();
//        上传图片
//        判断是否上传了图片
        if($file != null) {
            $path = upload_pic($file, 'pat_face');

            if(isset($path['failed'])) {
                $data['code'] = 0;
                $data['result'] = "图片上传失败";
                return $data;
            }

            $attributes['pat_face'] = $path['pat_face'];
        }

        $attributes['pat_addtime'] = date("Y-m-d H:i:s");
        $attributes['pat_password'] = Hash::make("root");

        if(!$node = $this->patient->create($attributes)) {
            $data['code'] = 0;
            $data['result'] = $result;
        }

        $data['cate_id'] = $node['pat_id'];

        return $data;
    }

    /**
     * 添加到回收站
     * @param $doc_id
     * @return mixed
     */
    public function destroyPatient($pat_id)
    {
        $data = $this->patient->update(array('pat_is_delete' => 1), $pat_id);
        if($data) {
            $data = array('code' => 1);
        } else {
            $data = array('code' => 0);
        }
        return $data;
    }

    /**
     * 从回收站彻底删除
     * @param $doc_id
     */
    public function destroyPatientTrue($pat_id)
    {

    }

    /**
     * @param $params       start:开始记录  limit:每一页记录数   page:当前页码
     */
    public function getPatientList($params)
    {
        $return = array();
//        查询全部记录
        $total = $this->patient->getTotalNumber();
        $patients = $this->patient->getPatientList($params);
        $patients = $this->object_array($patients);

        $return['total'] = $total;

//        处理$Patients
        foreach ($patients as $k => $v) {
            if($v['pat_face']) {
                $patients[$k]['pat_face'] = show_face($v['pat_face'], 50, 50);
            }

            $patients[$k]['pat_is_delete'] = show_is_delete($v['pat_is_delete']);
            $patients[$k]['actions'] = show_actions($v['pat_id'], "patient");
        }

        $return['data'] = $patients;
        return $return;
    }

    private function object_array($array) {
        if(is_object($array)) {
            $array = (array)$array;
        }

        if(is_array($array)) {
            foreach($array as $key => $value) {
                $array[$key] = $this->object_array($value);
            }
        }
        return $array;
    }

    public function getPatientById($pat_id)
    {
        return $this->patient->find($pat_id)->toArray();
    }

    public function ajaxGetPatientFollows($page, $pat_id, $limit)
    {
        return $this->patient->ajaxGetPatientFollows($page, $pat_id, $limit);
    }

    public function ajaxGetPatientComments($page, $pat_id, $limit)
    {
        return $this->patient->ajaxGetPatientComments($page, $pat_id, $limit);
    }

    public function getFollowTotalNumber($pat_id)
    {
        return $this->patient->getFollowTotalNumber($pat_id);
    }

    public function getComentsTotalNumber($pat_id)
    {
        return $this->patient->getCommentsTotalNumber($pat_id);
    }

    public function getCommentsByPatId($page, $pat_id, $limit)
    {
        return $this->patient->ajaxGetPatientComments($page, $pat_id, $limit);
    }

    public function patientResetPassword($attributes, $pat_id)
    {
        $return = array('code' => 1);
        $doctor = $this->getPatientById($doc_id);
        $password = $doctor['pat_password'];
        if(Hash::check($attributes['current_password'], $password)) {
            $data = $this->updatePatient(['pat_password' => Hash::make($attributes['new_password'])], $doc_id);
        } else {
            $return['code'] = 0;
            $return['fail_reason'] = "原密码输入不正确";
        }

        return $return;
    }
}