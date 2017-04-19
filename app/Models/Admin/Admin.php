<?php
/**
 * Created by PhpStorm.
 * User: HT
 * Date: 2017/03/17
 * Time: 16:31
 */

namespace App\Models\Admin;


use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'hnis_admin';
    protected $primaryKey = 'admin_id';
    public $timestamps = false;
    protected $fillable = ['admin_username', 'admin_sex', 'admin_name', 'admin_email', 'admin_tel', 'admin_adder', 'admin_pic', 'admin_is_use', 'admin_addtime', 'admin_updatetime', 'admin_password'];

    public function roles()
    {
        return $this->belongsToMany('App\Models\Admin\Role', 'hnis_admin_role', 'admin_id', 'role_id');
    }
}