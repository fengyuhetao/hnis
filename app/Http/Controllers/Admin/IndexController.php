<?php
/**
 * Created by PhpStorm.
 * User: HT
 * Date: 2017/03/17
 * Time: 19:41
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;

class IndexController extends Controller
{
    public function index() {
        return view('admin.index');
    }
}