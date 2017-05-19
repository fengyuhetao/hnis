<?php
/**
 * Created by PhpStorm.
 * User: HT
 * Date: 2017/03/31
 * Time: 20:09
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Service\Admin\CommentService;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    private $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    // get.admin/Comment
    public function index()
    {
    }

    //get.admin/Comment/create
    public function create()
    {

    }

    //post.admin/Comment
    public function store(Request $request)
    {
        $data = $this->commentService->addComment($request->all());

        return json_encode($data);
    }

    public function edit($com_id)
    {
//            form_editable.html
    }

    public function update(Request $request, $com_id)
    {

    }

    // delete.admin/Comment/{com_id}
    public function destroy($com_id)
    {
        return $this->commentService->destroyComment($com_id);
    }
}