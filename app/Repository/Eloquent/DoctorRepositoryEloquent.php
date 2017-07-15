<?php
/**
 * Created by PhpStorm.
 * User: HT
 * Date: 2017/03/30
 * Time: 22:13
 */

namespace App\Repository\Eloquent;

use App\Models\Admin\Doctor;
use App\Models\Admin\Patient;
use App\Repository\Contracts\DoctorRepository;
use Illuminate\Support\Facades\DB;
use PhpParser\Comment\Doc;
use Prettus\Repository\Eloquent\BaseRepository;

class DoctorRepositoryEloquent extends BaseRepository implements DoctorRepository
{
    public function model()
    {
        return Doctor::class;
    }

    public function deleteByIds($ids)
    {
        $data = DB::table('hnis_doctor')->whereIn('doc_id', $ids)->delete();
        return $data;
    }

    public function getTotalNumber($adeparts = [])
    {
        if($adeparts) {
            $total = DB::table('hnis_doctor')->whereIn('cate_id', $adeparts)->count();
        } else {
            $total = DB::table('hnis_doctor')->count();
        }
        return $total;
    }

     public function getDoctorList($params)
    {
        $offset = ($params['page'] - 1) * $params['limit'];
        $doctors = DB::table('hnis_doctor')->select('doc_id', 'doc_name', 'doc_face', 'doc_score', 'doc_seo_keyword', 'doc_seo_description', 'doc_sort_num', 'doc_tel', 'doc_follow_number', 'doc_admire_number', 'doc_hate_number', 'doc_is_new', 'doc_is_online', 'doc_is_delete', 'doc_portal_show', 'doc_addtime')
            ->offset($offset)->limit($params['limit'])->get()->toArray();
        return $doctors;
    }

    public function getCarousels($limit)
    {
        $carousels = Db::table('hnis_doctor')->where(['doc_portal_show' => 1])->limit($limit)->get()->toArray();
        return $carousels;
    }

    public function getDoctorsByCategory($achildDeparts, $limit, $offset = 0)
    {
        if($offset) {
            return DB::table('hnis_doctor')->whereIn('cate_id', $achildDeparts)->orderBy('doc_sort_num', 'desc')->offset($offset)->limit($limit)->get()->toArray();
        }
        return DB::table('hnis_doctor')->whereIn('cate_id', $achildDeparts)->orderBy('doc_sort_num', 'desc')->limit($limit)->get()->toArray();
    }

    public function getDoctorPatients($doc_id)
    {
        return Doctor::find($doc_id)->patients()->get()->toArray();
    }

    public function follow($doc_id, $pat_id)
    {
        DB::table('hnis_follow')->insert(['pat_id' => $pat_id, 'doc_id' => $doc_id]);
        return DB::table('hnis_doctor')->where(['doc_id' => $doc_id])->increment('doc_follow_number');
    }

    public function zan($doc_id)
    {
        return DB::table('hnis_doctor')->where(['doc_id' => $doc_id])->increment('doc_admire_number');
    }

    public function hate($doc_id)
    {
        return DB::table('hnis_doctor')->where(['doc_id' => $doc_id])->increment('doc_hate_number');
    }

    public function getDoctorsByCateId($cate_id, $doc_id)
    {
        return DB::table('hnis_doctor')->where([['cate_id', '=', $cate_id], ['doc_id', '<>', $doc_id]], ['doc_is_online', '=', 1])->get()->toArray();
    }

    public function getDoctorCommentsTotalNumber($doc_id)
    {
        $total_number = DB::table('hnis_comment')->where(['doc_id' => $doc_id])->count();
        return $total_number;
    }

    public function getDiangnoseTotalNumber($doc_id)
    {
        return DB::table('hnis_diagnose')->where(['doc_id' => $doc_id])->count();
    }

    public function getFollowedTotalNumber($doc_id)
    {
        return DB::table('hnis_follow')->where(['doc_id' => $doc_id])->count();
    }
}