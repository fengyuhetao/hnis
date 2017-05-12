<?php
/**
 * Created by PhpStorm.
 * User: HT
 * Date: 2017/03/26
 * Time: 19:34
 */

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class TypeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = array();
        //        如果是添加操作
        if(request()->isMethod('POST')) {
            $rules['type_name']     = 'required';
        }

        // 如果是修改操作
        if(request()->isMethod('PUT')) {
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'required'   => ":attribute 不能为空",
            'numeric'    => ":attribute 应该是一个整数",
            'max'        => [
                'string' => ":attribute 最大不超过:max"
            ],
            'min' => [
                'string' => ":attribute 最小不能少于:min"
            ],
            'email'      => ":attribute 不是email格式",
            'in'         => ":attribute 不是有效的选项",
            'unique'     => ":attribute 不是唯一值",
            'regex'      => ":attribute 不符合规则"
        ];
    }

    public function attributes()
    {
        return [
            'cate_id'   => "分类ID",
            'cate_name'   => "分类名称",
            'cate_parent_id'       => "分类父ID",
            'cate_sort_num'         => "分类排序"
        ];
    }
}