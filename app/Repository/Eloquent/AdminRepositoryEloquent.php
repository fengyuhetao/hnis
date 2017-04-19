<?php
/**
 * Created by PhpStorm.
 * User: HT
 * Date: 2017/03/21
 * Time: 15:42
 */

namespace App\Repository\Eloquent;


use App\Models\Admin\Admin;
use App\Repository\Contracts\AdminRepository;
use Prettus\Repository\Eloquent\BaseRepository;

class AdminRepositoryEloquent extends BaseRepository implements AdminRepository
{
    public function model()
    {
        return Admin::class;
    }
}