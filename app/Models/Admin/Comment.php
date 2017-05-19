<?php
/**
 * Created by PhpStorm.
 * User: HT
 * Date: 2017/03/30
 * Time: 21:44
 */

namespace App\Models\Admin;


use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = "hnis_comment";
    protected $primaryKey = "com_id";
    public $timestamps = false;
    protected $fillable = ['com_content', 'com_addtime', 'pat_id', 'com_is_delete', 'doc_id'];
}