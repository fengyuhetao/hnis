<?php
/**
 * Created by PhpStorm.
 * User: HT
 * Date: 2017/03/30
 * Time: 22:13
 */

namespace App\Repository\Eloquent;

use App\Models\Admin\Doctor;
use App\Repository\Contracts\DoctorRepository;
use Illuminate\Support\Facades\DB;
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

    public function getTotalNumber()
    {
        $total = DB::table('hnis_doctor')->count();
        return $total;
    }

     public function getDoctorList($params)
    {
        $offset = ($params['page'] - 1) * $params['limit'];
        $doctors = DB::table('hnis_doctor')->select('doc_id', 'doc_name', 'doc_sm_face', 'doc_score', 'doc_seo_keyword', 'doc_seo_description', 'doc_sort_num', 'doc_tel', 'doc_follow_number', 'doc_admire_number', 'doc_hate_number', 'doc_is_new', 'doc_is_online', 'doc_is_delete', 'doc_addtime')
            ->offset($offset)->limit($params['limit'])->get()->toArray();
        return $doctors;
    }
}