<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

\Debugbar::enable();

Route::get('/', function () {
    return view('welcome');
});

Route::any('admin/login', 'Admin\LoginController@login');
Route::get('admin/code', 'Admin\LoginController@getCode');
Route::get('admin/lang', 'Admin\LoginController@testMutilLang');
Route::get('admin/test', 'Admin\LoginController@test');

Route::group(['middleware' => 'admin.check.login', 'prefix'=>'admin', 'namespace' => 'Admin'], function() {
    Route::get('index', 'IndexController@index');
    Route::get('logout', 'LoginController@logOut');
    Route::get('lockscreen', 'LoginController@lockScreen');

    //admin
    Route::resource('admin', 'AdminController');

    //privilege
    Route::get('privilege/list', 'PrivilegeController@ajaxGetPrivilegeList');
    Route::get('privilege/getPrivilegeById', 'PrivilegeController@getPrivilegeById');
    Route::resource('privilege', 'PrivilegeController');

    //role
    Route::resource('role', 'RoleController');
    Route::get('ajaxGetRolesByRoleId', 'RoleController@ajaxGetRolesByRoleId');

    //common
    Route::any('upload', 'CommonController@upload');
});

// 后台系统日志
Route::group(['prefix' => 'admin/log','middleware' => []],function ($router)
{
    $router->get('/','\Arcanedev\LogViewer\Http\Controllers\LogViewerController@index')->name('log.dash');
    $router->get('list','\Arcanedev\LogViewer\Http\Controllers\LogViewerController@listLogs')->name('log.index');
    $router->post('delete','\Arcanedev\LogViewer\Http\Controllers\LogViewerController@delete')->name('log.destroy');
    $router->get('/{date}','\Arcanedev\LogViewer\Http\Controllers\LogViewerController@show')->name('log.show');
    $router->get('/{date}/download','\Arcanedev\LogViewer\Http\Controllers\LogViewerController@download')->name('log.download');
    $router->get('/{date}/{level}','\Arcanedev\LogViewer\Http\Controllers\LogViewerController@showByLevel')->name('log.filter');

});