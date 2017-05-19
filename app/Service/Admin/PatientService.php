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
    public function updatePatient($attributes, $doc_id)
    {
        $data = array(
            'code' => 1
        );

        foreach ($attributes as $k => $v) {
            if($v == "") {
                unset($attributes[$k]);
            }
        }
        try {
            if(!($result = $this->patient->update($attributes, $doc_id))) {
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
    public function addPatient($attributes)
    {
        $data = array(
            'code' => 1
        );

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
            if($v['pat_sm_face']) {
                $patients[$k]['pat_sm_face'] = show_face($v['pat_sm_face'], 50, 50);
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
        return $this->patient->find($pat_id);
    }
}