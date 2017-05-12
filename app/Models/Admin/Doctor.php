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
    protected $fillable = ['doc_name', 'doc_is_delete'];

    public function categorys()
    {
        return $this->belongsToMany("App\Models\Admin\Category", "hnis_doc_cate", "cate_id", "doc_id");
    }
}