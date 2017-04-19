<?php
/**
 * Created by PhpStorm.
 * User: HT
 * Date: 2017/03/26
 * Time: 19:34
 */

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class PrivilegeRequest extends FormRequest
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
            $rules['pri_parent_id']     = 'required|numeric';
            $rules['pri_name'] = 'required';
        }

        // 如果是修改操作
        if(request()->isMethod('PUT')) {
            $rules['pri_id']        = 'required|numeric';
            $rules['pri_name']      = 'sometimes|required';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'required'   => ":attribute 不能为空",
            'numeric'    => ":attribute 应该是一个整数",
            'max'        => [
                'string' => ":attribute 最大不超过:max个字符"
            ],
            'min' => [
                'string' => ":attribute 最小不能少于:min个字符"
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
            'pri_id'   => "权限ID",
            'pri_name'   => "权限名称",
            'pri_url'       => "权限路由地址",
            'pri_icon'         => "权限图标"
        ];
    }
}