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
}