<?php
/**
 * Created by PhpStorm.
 * User: HT
 * Date: 2017/03/30
 * Time: 22:13
 */

namespace App\Repository\Eloquent;

use App\Models\Admin\Patient;
use App\Repository\Contracts\CategoryRepository;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;

class PatientRepositoryEloquent extends BaseRepository implements CategoryRepository
{
    private static $table = "hnis_patient";
    private static $key_id = "pat_id";

    public function model()
    {
        return Patient::class;
    }

    public function deleteByIds($ids)
    {
        $data = DB::table(self::$table)->whereIn(self::$key_id, $ids)->delete();
        return $data;
    }

    public function getTotalNumber()
    {
        $total = DB::table(self::$table)->count();
        return $total;
    }

    public function getPatientList($params)
    {
        $offset = ($params['page'] - 1) * $params['limit'];
        $doctors = DB::table(self::$table)->select('pat_id', 'pat_name', 'pat_nickname', 'pat_face', 'pat_tel', 'pat_addtime', 'pat_email', 'pat_is_delete')
            ->offset($offset)->limit($params['limit'])->get()->toArray();
        return $doctors;
    }

    public function ajaxGetPatientFollows($page, $pat_id, $limit)
    {
        $offset = ($page - 1) * $limit;
        return DB::table('hnis_follow')->join('hnis_doctor', 'hnis_follow.doc_id', '=', 'hnis_doctor.doc_id')
            ->where(['hnis_follow.pat_id' => $pat_id])->offset($offset)->limit($limit)->get()->toArray();
    }

    public function ajaxGetPatientComments($page, $pat_id, $limit)
    {
        $offset = ($page - 1) * $limit;
        return DB::table('hnis_comment')->join('hnis_doctor', 'hnis_comment.doc_id', '=', 'hnis_doctor.doc_id')
            ->where(['hnis_comment.pat_id' => $pat_id])->offset($offset)->limit($limit)->get()->toArray();
    }

    public function getFollowTotalNumber($pat_id)
    {
        return DB::table('hnis_follow')->where(['pat_id' => $pat_id])->count();
    }

    public function getCommentsTotalNumber($pat_id)
    {
        return DB::table('hnis_comment')->where(['pat_id' => $pat_id])->count();
    }
}