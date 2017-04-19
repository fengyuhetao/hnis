<?php
/**
 * Created by PhpStorm.
 * User: HT
 * Date: 2017/04/07
 * Time: 19:46
 */

namespace App\Repository\Eloquent;

use App\Models\Admin\Role;
use App\Repository\Contracts\RoleRepository;
use Prettus\Repository\Eloquent\BaseRepository;

class RoleRepositoryEloquent extends BaseRepository implements RoleRepository
{
    public function model()
    {
        return Role::class;
    }
}