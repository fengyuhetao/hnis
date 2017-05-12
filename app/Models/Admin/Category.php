<?php
/**
 * Created by PhpStorm.
 * User: HT
 * Date: 2017/03/30
 * Time: 21:44
 */

namespace App\Models\Admin;


use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "hnis_category";
    protected $primaryKey = "cate_id";
    public $timestamps = false;
    protected $fillable = ['cate_name', 'cate_sort_num', 'cate_parent_id'];

    public function roles()
    {
        return $this->belongsToMany("App\Models\Admin\Category", "hnis_doc_cate", "cate_id", "doc_id");
    }
}