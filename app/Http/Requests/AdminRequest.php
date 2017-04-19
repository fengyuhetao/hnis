<?php
/**
 * Created by PhpStorm.
 * User: HT
 * Date: 2017/03/26
 * Time: 19:34
 */

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
            $rules['admin_name']     = 'required|max:30|min:1';
            $rules['admin_username'] = 'required|max:30|min:1|unique:hnis_admin';
            $rules['admin_password'] = 'required|max:60|min:6|confirmed';
            $rules['admin_email']    = 'required|email';
            $rules['admin_password_confirmation'] = 'required';
            $rules['admin_tel']      = array('required', 'regex:/^1[34578][0-9]{9}$/');
            $rules['admin_sex']      = 'required|in:"男","女"';
            $rules['roles']          = 'required';
        }

        // 如果是修改操作
        if(request()->isMethod('PUT')) {
            $rules['admin_id'] = 'sometimes|required|numeric';
            $rules['admin_name'] = 'sometimes|required|max:30|min:1';
            $rules['admin_username'] = 'sometimes|required|max:30|min:1';
            $rules['admin_is_use'] = 'sometimes|required|in:1,0';
            $rules['admin_is_delete'] = 'sometimes|required|in:1,0';
            $rules['admin_email'] = 'sometimes|required|email';
            $rules['admin_tel'] = array('sometimes', 'required', 'regex:/^1[34578][0-9]{9}$/');
            $rules['admin_sex'] = 'sometimes|required|in:"男","女"';
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
            'regex'      => ":attribute 不符合规则",
            'confirmed'  => "两次密码输入不相同",
        ];
    }

    public function attributes()
    {
        return [
            'admin_username'   => "管理员账号",
            'admin_password'   => "管理员密码",
            'admin_name'       => "管理员真实姓名",
            'admin_id'         => "管理员ID",
            'admin_sex'        => "管理员性别",
            'admin_tel'        => "管理员电话",
            'admin_is_use'     => "管理员状态",
            'admin_is_delete'  => "管理员是否删除",
            'admin_email'      => "管理员邮箱",
            'admin_password_confirmation' => "重复密码"
        ];
    }
}