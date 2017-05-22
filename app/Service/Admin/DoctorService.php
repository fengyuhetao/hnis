<?php
/**
 * Created by PhpStorm.
 * User: HT
 * Date: 2017/03/31
 * Time: 20:08
 */

namespace App\Service\Admin;


use App\Repository\Eloquent\CategoryRepositoryEloquent;
use App\Repository\Eloquent\CommentRepositoryEloquent;
use App\Repository\Eloquent\DoctorRepositoryEloquent;
use Exception;

class DoctorService
{
    private $doctor;
    private $category;
    private $comment;

    public function __construct(DoctorRepositoryEloquent $doctor, CategoryRepositoryEloquent $category, CommentRepositoryEloquent $comment)
    {
        $this->doctor = $doctor;
        $this->category = $category;
        $this->comment = $comment;
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
            $doctors[$k]['doc_portal_show'] = doc_portal_show($v['doc_portal_show']);
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

    public function getCarousels()
    {
        return $this->doctor->getCarousels(10);
    }

    public function getPortalDoctors()
    {
        $data = array();
//        查询所有科室
        $allDeparts = $this->category->findWhere(['cate_parent_id' => 1])->toArray();
        foreach ($allDeparts as $v) {
//            查询该科室下所有子科室
            $childDeparts = $this->category->findWhere(['cate_parent_id' => $v['cate_id']], ['cate_id'])->toArray();
            $achildDeparts = [];
            foreach ($childDeparts as $v1) {
                $achildDeparts[] = $v1['cate_id'];
            }

//            查询属于这些科室的医生
            if($v['cate_name'] == "内科") {
                $doctors = $this->doctor->getDoctorsByCategory($achildDeparts, 7);
                $v['doctors'] = $doctors;
                array_unshift($data, $v);
            } else {
                $doctors = $this->doctor->getDoctorsByCategory($achildDeparts, 5);
                $v['doctors'] = $doctors;
                $data[] = $v;
            }
        }

        return $data;
    }

    public function getDoctorsByWhere($where)
    {
        $adeparts = [];
        if($where['cate_cid']) {
            $adeparts[] = $where['cate_cid'];
        } else {
            //            查询该科室下所有子科室
            $childDeparts = $this->category->findWhere(['cate_parent_id' => $where['cate_id']], ['cate_id'])->toArray();
            foreach ($childDeparts as $v) {
                $adeparts[] = $v['cate_id'];
            }
        }

//        查询这下部门下所有医生数目
        $total = $this->doctor->getTotalNumber($adeparts);
//        一页15个医生
        $limit = 15;

        $data = array();
//        总页数
        $page_number = ceil($total / 15);
        $data['page_number'] = $page_number;

        if($where['page'] > $page_number) {
            $where['page'] = $page_number;
        }

        if($where['page'] < 1) {
            $where['page'] = 1;
        }

//        判断是否有上一页
        $data['prev'] = $where['page'] == 1 ? 0 : 1;
//        判断是否有下一页
        $data['next'] = $where['page'] < $page_number ? 1 : 0;

//        获取医生数据
        $offset = ($where['page'] - 1) * $limit;
        $doctors = $this->doctor->getDoctorsByCategory($adeparts, $limit, $offset);
        $data['doctors'] = $doctors;
        $data['cate_id'] = $where['cate_id'];
        $data['cate_cid'] = $where['cate_cid'];
        $data['page'] = $where['page'];
        return $data;
    }

    public function getDoctorById($doc_id)
    {
        return $this->doctor->find($doc_id)->toArray();
    }

    public function getDoctorComments($doc_id, $number = 4)
    {
        return $this->comment->getDoctorComments($doc_id, 4);
    }

    public function getDoctorPatients($doc_id)
    {
        return $this->doctor->getDoctorPatients($doc_id);
    }

    public function follow($doc_id, $pat_id)
    {
        return $this->doctor->follow($doc_id, $pat_id);
    }

    public function zan($doc_id)
    {
        return $this->doctor->zan($doc_id);
    }

    public function hate($doc_id)
    {
        return $this->doctor->hate($doc_id);
    }

    public function getDoctorByCateId($cate_id, $doc_id)
    {
        return $this->doctor->getDoctorsByCateId($cate_id, $doc_id);
    }

    public function getDoctorCommentsTotalPage($doc_id)
    {
        $total_page = $this->doctor->getDoctorCommentsTotalNumber($doc_id);
        return ceil($total_page / 6);
    }

    public function ajaxGetDoctorComments($page, $doc_id, $limit)
    {
        return $this->comment->ajaxGetDoctorComments($page, $doc_id, $limit);
    }

    public function getDoctorCommentsTotalNumber($doc_id)
    {
        return $this->doctor->getDoctorCommentsTotalNumber($doc_id);
    }
}