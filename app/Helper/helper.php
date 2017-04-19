<?php
/**
 * Created by PhpStorm.
 * User: HT
 * Date: 2017/03/26
 * Time: 22:44
 */

//显示头像
if (! function_exists('show_face')) {
    function show_face($imagePath, $width = 200, $height = 200) {
        return "<image src='". $imagePath ."' width=". $width ." height=". $height .">";
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
    function upload_pic($file)
    {
        if($file -> isValid()){
            $entension = $file -> getClientOriginalExtension(); //上传文件的后缀.
//            判断后缀是否符合规则

            $newName = date('YmdHis').mt_rand(100,999).'.'.$entension;
            $path = $file -> move(base_path().'/uploads',$newName);
            $filepath = url("/") .'/uploads/'.$newName;
            $attributes = ['admin_pic' => $filepath];
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