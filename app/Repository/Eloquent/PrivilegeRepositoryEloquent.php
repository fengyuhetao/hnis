<?php
/**
 * Created by PhpStorm.
 * User: HT
 * Date: 2017/03/30
 * Time: 22:13
 */

namespace App\Repository\Eloquent;

use App\Models\Admin\Privilege;
use App\Repository\Contracts\PrivilegeRepository;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;

class PrivilegeRepositoryEloquent extends BaseRepository implements PrivilegeRepository
{
    public function model()
    {
        return Privilege::class;
    }

    public function deleteByIds($ids)
    {
        $data = DB::table('hnis_privilege')->whereIn('pri_id', $ids)->delete();
        return $data;
    }
}