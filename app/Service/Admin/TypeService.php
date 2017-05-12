<?php
/**
 * Created by PhpStorm.
 * User: HT
 * Date: 2017/03/31
 * Time: 20:08
 */

namespace App\Service\Admin;


use App\Repository\Eloquent\TypeRepositoryEloquent;
use Exception;

class TypeService
{
    private $type;

    public function __construct(TypeRepositoryEloquent $type)
    {
        $this->type = $type;
    }

    public function getTypeList($params)
    {
        $return = array();
//        查询全部记录
        $total = $this->type->getTotalNumber();
        $types = $this->type->getTypeList($params);
        $types = object_array($types);

        $return['total'] = $total;

//        处理$types
        foreach ($types as $k => $v) {
            $types[$k]['actions'] = show_actions($v['type_id'], "type");
        }

        $return['data'] = $types;
        return $return;
    }

    public function getTypeById($type_id)
    {
        return $this->type->find($type_id)->toArray();
    }

    public function updateType($attributes, $type_id)
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
            if(!($result = $this->type->update($attributes, $type_id))) {
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

    public function addType($attributes)
    {
        $data = array(
            'code' => 1
        );

        if(!$node = $this->type->create($attributes)) {
            $data['code'] = 0;
            $data['result'] = $result;
        }

        $data['type_id'] = $node['type_id'];

        return $data;
    }

    public function destroyType($type_id)
    {
        $return = array('code' => 1);

        try {
            $ids[] = $type_id;

            if(!$number = $this->type->deleteByIds($ids)){
                $return['code'] = 0;
                $return['result'] = "发生未知错误";
            }
        } catch (Exception $e) {
//            echo $e->getMessage();
            // 错误信息发送邮件
            $return['code'] = 0;
            $return['result'] = "发生未知错误";
        }

        return $return;
    }
}