<?php
/**
 * Created by PhpStorm.
 * User: HT
 * Date: 2017/03/31
 * Time: 20:08
 */

namespace App\Service\Admin;


use App\Repository\Eloquent\PrivilegeRepositoryEloquent;
use Exception;

class PrivilegeService
{
    private $privilege;

    public function __construct(PrivilegeRepositoryEloquent $privilege)
    {
        $this->privilege = $privilege;
    }

    public function priListToTreeAll($data)
    {
        $array = array();
        if($data) {
            $array['id'] = $data[0]['pri_id'];
            $array['text'] = $data[0]['pri_name'];
            $array['icon'] = $data[0]['pri_icon'];
            $array['state'] = array("opened" => true, "disabled" => true);
            foreach ($data as $k => $v) {
                if($v['pri_parent_id'] == $array['id']) {
                    $temp = array();
                    $temp['id'] = $v['pri_id'];
                    $temp['text'] = $v['pri_name'];
                    $temp['icon'] = $v['pri_icon'];
                    $temp['state'] = array("opened" => true);
                    $array['children'][] = $temp;
                }
            }

            if (isset($array['children'])) {
                foreach ($array['children'] as $k => $v) {
                    foreach ($data as $k1 => $v1) {
                        if($v1['pri_parent_id'] == $v['id']) {
                            $temp = array();
                            $temp['id'] = $v1['pri_id'];
                            $temp['text'] = $v1['pri_name'];
                            $temp['icon'] = $v1['pri_icon'];
                            $temp['state'] = array("opened" => true);
                            $array['children'][$k]['children'][] = $temp;
                        }
                    }
                }

                foreach ($array['children'] as $k => $v) {
                    if(isset($v['children']))
                    {
                        foreach ($v['children'] as $k1 => $v1) {
                            foreach ($data as $k2 => $v2) {
                                if($v2['pri_parent_id'] == $v1['id']) {
                                    $temp = array();
                                    $temp['id'] = $v2['pri_id'];
                                    $temp['text'] = $v2['pri_name'];
                                    $temp['icon'] = $v2['pri_icon'];
                                    $temp['state'] = array("opened" => true);
                                    $array['children'][$k]['children'][$k1]['children'][] = $temp;
                                }
                            }
                        }
                    }
                }
            }
        }
        return $array;
    }

    public function priListToTreePart($data) {
        $array = array();
        if($data) {
            foreach ($data as $k => $v) {
                if($v['pri_parent_id'] == 1) {
                    $array[] = $v;
                }
            }

            foreach ($array as $k => $v) {
                foreach ($data as $k1 => $v1) {
                    if($v1['pri_parent_id'] == $v['pri_id']) {
                        $array[$k]['children'][] = $v1;
                    }
                }
            }

            foreach ($array as $k => $v) {
                if(isset($v['children'])) {
                    foreach ($v['children'] as $k1 => $v1) {
                        foreach ($data as $k2 => $v2) {
                            if($v2['pri_parent_id'] == $v1['pri_id']) {
                                $array[$k]['children'][$k1]['children'][] = $v2;
                            }
                        }
                    }
                }
            }
        }
        return $array;
    }

    public function getPrivilegeList()
    {
        $data = $this->privilege->all(['pri_id', 'pri_name', 'pri_parent_id', 'pri_icon'])->toArray();

        $array = $this->priListToTreeAll($data);

        return $array;
    }

    public function getPrivilegeById($pri_id)
    {
        return $this->privilege->find($pri_id)->toArray();
    }

    public function updatePrivilege($attributes, $pri_id)
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
            if(!($result = $this->privilege->update($attributes, $pri_id))) {
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

    public function addPrivilege($attributes)
    {
        $data = array(
            'code' => 1
        );

        if(!$node = $this->privilege->create($attributes)) {
            $data['code'] = 0;
            $data['result'] = $result;
        }

        $data['pri_id'] = $node['pri_id'];

        return $data;
    }

    public function destroyPrivilege($pri_id)
    {
        $return = array('code' => 1);

        //        判断该节点是否是叶子节点
        $data = $this->privilege->all(['pri_id', 'pri_parent_id'])->toArray();

        $children = get_children($data, $pri_id);

        try {
            $ids = array();
            // 不是叶子节点
            if ($children) {
                $ids = $children;
            }
            $ids[] = $pri_id;

            if(!$number = $this->privilege->deleteByIds($ids)){
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