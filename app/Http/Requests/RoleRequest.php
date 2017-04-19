<?php
/**
 * Created by PhpStorm.
 * User: HT
 * Date: 2017/03/26
 * Time: 19:34
 */

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
            $rules['role_name']     = 'required|max:30|min:1';
            $rules['role_desc']     = 'required|max:30|min:1';
        }

        // 如果是修改操作
        if(request()->isMethod('PUT')) {
            $rules['role_id']        = 'sometimes|required|numeric';
            $rules['role_name']      = 'sometimes|required|max:30|min:1';
            $rules['role_desc']      = 'sometimes|required|max:30|min:1';
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
            'role_id'       => "角色ID",
            'role_name'     => "角色名称",
            'role_desc'     => "角色描述"
        ];
    }
}