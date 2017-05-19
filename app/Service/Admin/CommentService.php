<?php
/**
 * Created by PhpStorm.
 * User: HT
 * Date: 2017/03/31
 * Time: 20:08
 */

namespace App\Service\Admin;


use App\Repository\Eloquent\CategoryRepositoryEloquent;
use App\Repository\Eloquent\CommentRepositoryEloquent;
use Exception;

class CommentService
{
    private $comment;

    public function __construct(CommentRepositoryEloquent $comment)
    {
        $this->comment = $comment;
    }

    public function getCommentList()
    {
        $data = $this->comment->orderBy('com_addtime', "desc")->all()->toArray();

        return $data;
    }

    public function addComment($attributes)
    {
        $data = array(
            'code' => 1
        );

        $attributes['com_addtime'] = date('Y-m-d H:i:s');
        $result = $this->comment->create($attributes);
        return $data;
    }

    public function destroyComment($com_id)
    {
        return $this->comment->deleteWhere(['com_id' => $com_id]);
    }
}