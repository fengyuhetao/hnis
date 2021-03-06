<?php
/**
 * Created by PhpStorm.
 * User: HT
 * Date: 2017/03/30
 * Time: 21:44
 */

namespace App\Models\Admin;


use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $table = "hnis_doctor";
    protected $primaryKey = "doc_id";
    public $timestamps = false;
    protected $fillable = ['doc_name', 'doc_is_online', 'doc_is_delete', 'doc_tel', 'doc_seo_keyword', 'doc_seo_description', 'doc_desc', 'doc_room_title', 'doc_simple_desc', 'cate_id', 'doc_face', 'doc_password', 'doc_addtime'];

    public function categorys()
    {
        return $this->belongsToMany("App\Models\Admin\Category", "hnis_doc_cate", "doc_id", "cate_id");
    }

    public function comments()
    {
        return $this->hasMany("App\Models\Admin\Comment", "doc_id", "doc_id");
    }

    public function patients()
    {
        return $this->belongsToMany("App\Models\Admin\Patient", "hnis_diagnose", 'doc_id', 'pat_id');
    }
}