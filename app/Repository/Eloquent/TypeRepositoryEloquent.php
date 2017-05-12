<?php
/**
 * Created by PhpStorm.
 * User: HT
 * Date: 2017/03/30
 * Time: 22:13
 */

namespace App\Repository\Eloquent;

use App\Models\Admin\Type;
use App\Repository\Contracts\TypeRepository;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;

class TypeRepositoryEloquent extends BaseRepository implements TypeRepository
{
    private static $table = 'hnis_type';

    private static $key = 'type_id';

    public function model()
    {
        return Type::class;
    }

    public function deleteByIds($ids)
    {
        $data = DB::table(self::$table)->whereIn(self::$key, $ids)->delete();
        return $data;
    }

    public function getTypeList($params)
    {
        $offset = ($params['page'] - 1) * $params['limit'];
        $types = DB::table(self::$table)->select('type_id', 'type_name')
            ->offset($offset)->limit($params['limit'])->get()->toArray();
        return $types;
    }

    public function getTotalNumber()
    {
        $total = DB::table(self::$table)->count();
        return $total;
    }
}