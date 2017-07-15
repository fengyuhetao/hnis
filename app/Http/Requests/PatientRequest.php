<?php
/**
 * Created by PhpStorm.
 * User: HT
 * Date: 2017/03/26
 * Time: 19:34
 */

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class PatientRequest extends FormRequest
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
            $rules['pat_name']              = 'required';
            $rules['pat_nickname']          = 'required';
            $rules['pat_tel']               = 'required';
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
            'pat_id'   => "用户ID",
            'pat_name'   => "用户名称",
            'pat_nickname'       => "用户昵称",
            'pat_tel'         => "用户电话号码"
        ];
    }
}