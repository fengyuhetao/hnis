<?php
/**
 * Created by PhpStorm.
 * User: HT
 * Date: 2017/03/30
 * Time: 22:13
 */

namespace App\Repository\Eloquent;

use App\Models\Admin\Category;
use App\Repository\Contracts\CategoryRepository;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;

class CategoryRepositoryEloquent extends BaseRepository implements CategoryRepository
{
    public function model()
    {
        return Category::class;
    }

    public function deleteByIds($ids)
    {
        $data = DB::table('hnis_category')->whereIn('cate_id', $ids)->delete();
        return $data;
    }
}