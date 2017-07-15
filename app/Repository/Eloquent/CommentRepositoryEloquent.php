<?php
/**
 * Created by PhpStorm.
 * User: HT
 * Date: 2017/03/30
 * Time: 22:13
 */

namespace App\Repository\Eloquent;

use App\Models\Admin\Comment;
use App\Repository\Contracts\CommentRepository;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;

class CommentRepositoryEloquent extends BaseRepository implements CommentRepository
{
    public function model()
    {
        return Comment::class;
    }

    public function getDoctorComments($doc_id, $limit)
    {
        return DB::table('hnis_comment')->join('hnis_patient', 'hnis_comment.pat_id', '=', 'hnis_patient.pat_id')
            ->where(['hnis_comment.doc_id' => $doc_id])->orderBy('hnis_comment.com_addtime', 'desc')->limit($limit)->get()->toArray();
    }

    public function ajaxGetDoctorComments($page, $doc_id, $limit)
    {
        $offset = ($page - 1) * $limit;
        return DB::table('hnis_comment')->join('hnis_patient', 'hnis_comment.pat_id', '=', 'hnis_patient.pat_id')
            ->where(['hnis_comment.doc_id' => $doc_id])->orderBy('hnis_comment.com_addtime', 'desc')->offset($offset)->limit($limit)->get()->toArray();
    }

    public function ajaxGetDoctorDiagnoses($page, $doc_id, $limit)
    {
        $offset = ($page - 1) * $limit;
        return DB::table('hnis_diagnose')->join('hnis_patient', 'hnis_diagnose.pat_id', '=', 'hnis_patient.pat_id')
            ->where(['hnis_diagnose.doc_id' => $doc_id])->orderBy('hnis_diagnose.begin_time', 'desc')->offset($offset)->limit($limit)->get()->toArray();
    }

    public function ajaxGetDoctorFolloweds($page, $doc_id, $limit)
    {
        $offset = ($page - 1) * $limit;
        return DB::table('hnis_follow')->join('hnis_patient', 'hnis_follow.pat_id', '=', 'hnis_patient.pat_id')
            ->where(['hnis_follow.doc_id' => $doc_id])->offset($offset)->limit($limit)->get()->toArray();
    }
}