<?php
/**
 * Created by PhpStorm.
 * User: HT
 * Date: 2017/03/30
 * Time: 21:44
 */

namespace App\Models\Admin;


use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = "hnis_type";
    protected $primaryKey = "type_id";
    public $timestamps = false;
    protected $fillable = ['type_name'];
}