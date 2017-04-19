<?php
/**
 * Created by PhpStorm.
 * User: HT
 * Date: 2017/03/30
 * Time: 21:44
 */

namespace App\Models\Admin;


use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    protected $table = "hnis_privilege";
    protected $primaryKey = "pri_id";
    public $timestamps = false;
    protected $fillable = ['pri_name', 'pri_url', 'pri_parent_id'];

    public function roles()
    {
        return $this->belongsToMany("App\Models\Admin\Role", "hnis_role_privilege", "pri_id", "role_id");
    }
}