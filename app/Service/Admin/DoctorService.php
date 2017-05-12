<?php
/**
 * Created by PhpStorm.
 * User: HT
 * Date: 2017/03/31
 * Time: 20:08
 */

namespace App\Service\Admin;


use App\Repository\Eloquent\DoctorRepositoryEloquent;
use Exception;

class DoctorService
{
    private $doctor;

    public function __construct(DoctorRepositoryEloquent $doctor)
    {
        $this->doctor = $doctor;
    }

    /**
     * 根据医生ID获取医生信息
     * @param $doc_id
     */
    public function getCategoryById($doc_id)
    {
    }

    /**
     * 更新医生信息
     * @param $attributes
     * @param $doc_id
     * @return array
     */
    public function updateDoctor($attributes, $doc_id)
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
            if(!($result = $this->doctor->update($attributes, $doc_id))) {
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
    public function addDoctor($attributes)
    {
        $data = array(
            'code' => 1
        );

        if(!$node = $this->doctor->create($attributes)) {
            $data['code'] = 0;
            $data['result'] = $result;
        }

        $data['cate_id'] = $node['cate_id'];

        return $data;
    }

    /**
     * 添加到回收站
     * @param $doc_id
     * @return mixed
     */
    public function destroyDoctor($doc_id)
    {
        $data = $this->doctor->update(array('doc_is_delete' => 1), $doc_id);
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
    public function destroyDoctorTrue($doc_id)
    {

    }

    /**
     * @param $params       start:开始记录  limit:每一页记录数   page:当前页码
     */
    public function getdoctorList($params)
    {
        $return = array();
//        查询全部记录
        $total = $this->doctor->getTotalNumber();
        $doctors = $this->doctor->getDoctorList($params);
        $doctors = $this->object_array($doctors);

        $return['total'] = $total;

//        处理$doctors
        foreach ($doctors as $k => $v) {
            if($v['doc_sm_face']) {
                $doctors[$k]['doc_sm_face'] = show_face($v['doc_sm_face'], 50, 50);
            }

            $doctors[$k]['doc_is_new'] = show_is_new($v['doc_is_new']);
            $doctors[$k]['doc_is_online'] = show_is_online($v['doc_is_online']);
            $doctors[$k]['doc_is_delete'] = show_is_delete($v['doc_is_delete']);
            $doctors[$k]['actions'] = show_actions($v['doc_id'], "doctor");
        }

        $return['data'] = $doctors;
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
}