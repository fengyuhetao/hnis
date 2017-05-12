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
    protected $fillable = ['pat_name', 'pat_nickname', 'pat_email', 'pat_email_code', 'pat_tel', 'pat_password', 'pat_money', 'pat_is_delete'];
}