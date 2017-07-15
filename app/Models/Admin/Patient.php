<?php
/**
 * Created by PhpStorm.
 * User: HT
 * Date: 2017/03/30
 * Time: 21:44
 */

namespace App\Models\Admin;


use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table = "hnis_patient";
    protected $primaryKey = "pat_id";
    public $timestamps = false;
    protected $fillable = ['pat_face', 'pat_name', 'pat_nickname', 'pat_addtime', 'pat_email', 'pat_email_code', 'pat_tel', 'pat_password', 'pat_money', 'pat_is_delete'];

    public function doctors()
    {
        return $this->belongsToMany("App\Models\Admin\Doctor", "hnis_diagnose", 'pat_id', 'doc_id');
    }
}