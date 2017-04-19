<?php
/**
 * Created by PhpStorm.
 * User: HT
 * Date: 2017/03/30
 * Time: 21:24
 */

namespace App\Models\Admin;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = "hnis_role";
    protected $primaryKey = "role_id";
    public $timestamps = false;
    protected $fillable = ['role_name', 'role_desc', 'role_addtime'];

    public function privileges()
    {
        return $this->belongsToMany("App\Models\Admin\Privilege", "hnis_role_privilege", "role_id", "pri_id");
    }

    public function admins()
    {
        return $this->belongsToMany('App\Models\Admin\Admin', 'hnis_admin_role', 'role_id', 'admin_id');
    }
}