<?php
/**
 * Created by PhpStorm.
 * User: HT
 * Date: 2017/03/26
 * Time: 22:44
 */
if(! function_exists('object_array')) {
    function object_array($array) {
        if(is_object($array)) {
            $array = (array)$array;
        }

        if(is_array($array)) {
            foreach($array as $key => $value) {
                $array[$key] =          object_array($value);
            }
        }
        return $array;
    }
}


//显示头像
if (! function_exists('show_face')) {
    function show_face($imagePath, $width = 200, $height = 200) {
        return "<image src='". $imagePath ."' width=". $width ." height=". $height .">";
    }
}

//显示是否新人
if(! function_exists('show_is_new')) {
    function show_is_new($is_new) {
        if($is_new) {
            return "<span class=\"label label-sm label-info\"> 新 </span>";
        } else {
            return "<span class=\"label label-sm label-warning\"> 老 </span>";
        }
    }
}

//医生是否首页轮播显示
if(! function_exists('doc_portal_show')) {
    function doc_portal_show($doc_portal_show) {
        if($doc_portal_show) {
            return "<span class=\"label label-sm label-info\"> yes </span>";
        } else {
            return "<span class=\"label label-sm label-warning\"> no </span>";
        }
    }
}

//显示是否在线
if(! function_exists('show_is_online')) {
    function show_is_online($is_online) {
        if($is_online) {
            return "<span class=\"label label-sm label-info\"> 在线 </span>";
        } else {
            return "<span class=\"label label-sm label-warning\"> 离线 </span>";
        }
    }
}

//显示是否删除
if(! function_exists('show_is_delete')) {
    function show_is_delete($is_delete) {
        if(!$is_delete) {
            return "<span class=\"label label-sm label-info\"> 正常 </span>";
        } else {
            return "<span class=\"label label-sm label-warning\"> 删除 </span>";
        }
    }
}

if(! function_exists('show_actions')) {
    function show_actions($id, $table) {
        $html = "";
        if($table != 'type') {
            $html = "<a href=\"" .url('admin/'.$table.'/show') . "\"><i title=\"查看\" class=\"fa fa-eye\"></i></a>&nbsp";
        }
        $html .= "<a href=\"" .url('admin/'.$table.''). "/". $id ."/edit\"><i title=\"修改\" class=\"fa fa-edit\"></i></a>&nbsp";
        $html .= "<a href=\"javascript:;\" id=\"delete_confirm\" onclick=\"doDelete(".$id.")\"><i title=\"删除\" class=\"fa fa-trash\"></i></a>";
        return $html;
    }
}

if(! function_exists("re_sort"))
{
    function re_sort($data, $parent_id = 0, $level = 0, $isClear = TRUE)
    {
        static $ret = array();
        if ($isClear)
            $ret = array();
        foreach ($data as $k => $v) {
            if ($v['pri_parent_id'] == $parent_id) {
                $v['level'] = $level;
                $ret[] = $v;
                re_sort($data, $v['pri_id'], $level + 1, FALSE);
            }
        }
        return $ret;
    }
}

if(! function_exists("get_tree"))
{
    function get_tree($data, $field_name, $field_id = 'pri_id', $field_pid = 'pri_parent_id', $pid = 0)
    {
        $arr = array();
        foreach ($data as $k => $v) {
            if ($v[$field_pid] == $pid) {
                $data[$k]["_" . $field_name] = $data[$k][$field_name];
                $arr[] = $data[$k];
                foreach ($data as $m => $n) {
                    if ($n[$field_pid] == $v[$field_id]) {
                        $data[$m]["_" . $field_name] = '├─ ' . $data[$m][$field_name];
                        $arr[] = $data[$m];
                    }
                }
            }
        }
        return $arr;
    }
}
if(! function_exists("get_children"))
{
    function get_children($data, $parent_id = 0, $isClear = TRUE)
    {
        static $ret = array();
        if ($isClear)
            $ret = array();
        foreach ($data as $k => $v) {
            if ($v['pri_parent_id'] == $parent_id) {
                $ret[] = $v['pri_id'];
                get_children($data, $v['pri_id'], FALSE);
            }
        }
        return $ret;
    }
}

if(! function_exists("upload_pic"))
{
    function upload_pic($file, $name = "admin_pic")
    {
        if($file -> isValid()){
            $entension = $file -> getClientOriginalExtension(); //上传文件的后缀.
//            判断后缀是否符合规则

            $newName = date('YmdHis').mt_rand(100,999).'.'.$entension;
            $path = $file->move(base_path().'/uploads', $newName);
            $filepath = url("/") .'/uploads/'.$newName;
            $attributes = [$name => $filepath];
            return $attributes;
        } else {
            return ['failed' => "上传失败"];
        }
    }
}

if(! function_exists("array_remove"))
{
    function array_remove(&$arr, $offset)
    {
        array_splice($arr, $offset, 1);
    }
}