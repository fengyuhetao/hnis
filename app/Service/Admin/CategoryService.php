<?php
/**
 * Created by PhpStorm.
 * User: HT
 * Date: 2017/03/31
 * Time: 20:08
 */

namespace App\Service\Admin;


use App\Repository\Eloquent\CategoryRepositoryEloquent;
use Exception;

class CategoryService
{
    private $category;

    public function __construct(CategoryRepositoryEloquent $category)
    {
        $this->category = $category;
    }

    public function cateListToTreeAll($data)
    {
        $array = array();
        if($data) {
            $array['id'] = $data[0]['cate_id'];
            $array['text'] = $data[0]['cate_name'];
            $array['icon'] = "";
            $array['state'] = array("opened" => true, "disabled" => true);
            foreach ($data as $k => $v) {
                if($v['cate_parent_id'] == $array['id']) {
                    $temp = array();
                    $temp['id'] = $v['cate_id'];
                    $temp['text'] = $v['cate_name'];
                    $temp['icon'] = "";
                    $temp['state'] = array("opened" => true);
                    $array['children'][] = $temp;
                }
            }

            if (isset($array['children'])) {
                foreach ($array['children'] as $k => $v) {
                    foreach ($data as $k1 => $v1) {
                        if($v1['cate_parent_id'] == $v['id']) {
                            $temp = array();
                            $temp['id'] = $v1['cate_id'];
                            $temp['text'] = $v1['cate_name'];
                            $temp['icon'] = "";
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
                                if($v2['cate_parent_id'] == $v1['id']) {
                                    $temp = array();
                                    $temp['id'] = $v2['cate_id'];
                                    $temp['text'] = $v2['cate_name'];
                                    $temp['icon'] = "";
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

    public function cateListToTreePart($data) {
        $array = array();
        if($data) {
            foreach ($data as $k => $v) {
                if($v['cate_parent_id'] == 1) {
                    $array[] = $v;
                }
            }

            foreach ($array as $k => $v) {
                foreach ($data as $k1 => $v1) {
                    if($v1['cate_parent_id'] == $v['cate_id']) {
                        $array[$k]['children'][] = $v1;
                    }
                }
            }

            foreach ($array as $k => $v) {
                if(isset($v['children'])) {
                    foreach ($v['children'] as $k1 => $v1) {
                        foreach ($data as $k2 => $v2) {
                            if($v2['cate_parent_id'] == $v1['cate_id']) {
                                $array[$k]['children'][$k1]['children'][] = $v2;
                            }
                        }
                    }
                }
            }
        }
        return $array;
    }

    public function getCategoryList()
    {
        $data = $this->category->orderBy('cate_sort_num', "desc")->all(['cate_id', 'cate_name', 'cate_sort_num', 'cate_parent_id'])->toArray();

        $array = $this->cateListToTreeAll($data);

        return $array;
    }

    public function getCategoryById($cate_id)
    {
        return $this->category->find($cate_id)->toArray();
    }

    public function updateCategory($attributes, $cate_id)
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
            if(!($result = $this->category->update($attributes, $cate_id))) {
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

    public function addCategory($attributes)
    {
        $data = array(
            'code' => 1
        );

        $attributes['cate_sort_num'] = isset($attributes['cate_sort_num']) ? $attributes['cate_sort_num'] : 100;
        if(!$node = $this->category->create($attributes)) {
            $data['code'] = 0;
            $data['result'] = $result;
        }

        $data['cate_id'] = $node['cate_id'];

        return $data;
    }

    public function destroyCategory($cate_id)
    {
        $return = array('code' => 1);

        //        判断该节点是否是叶子节点
        $data = $this->category->all(['cate_id', 'cate_parent_id'])->toArray();

        $children = get_children($data, $cate_id);

        try {
            $ids = array();
            // 不是叶子节点
            if ($children) {
                $ids = $children;
            }
            $ids[] = $cate_id;

            if(!$number = $this->category->deleteByIds($ids)){
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

    public function getSecondLevelCategory()
    {
        $data = $this->category->findWhere(['cate_parent_id' => 1, 'cate_is_show' => 1], ['cate_id', 'cate_name'])->toArray();
        return $data;
    }

    public function getCategorysByParentId($cate_pid)
    {
        $data = $this->category->findWhere(['cate_parent_id' => $cate_pid], ['cate_id', 'cate_name'])->toArray();
        return $data;
    }

    public function getAllCategorys()
    {
        return $this->category->all()->toArray();
    }
}