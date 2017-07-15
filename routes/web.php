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

//\Debugbar::enable();

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

    //category
    Route::get('category/list', 'CategoryController@ajaxGetCategoryList');
    Route::get('category/getCategoryById', 'CategoryController@getCategoryById');
    Route::resource('category', 'CategoryController');

    Route::get('doctor/show', 'DoctorController@ajaxGetdoctorList');
    Route::get('doctor/list', 'DoctorController@ajaxGetdoctorList');

    Route::resource('doctor', 'DoctorController');

    Route::get('patient/show', 'PatientController@ajaxGetPatientList');
    Route::get('patient/list', 'PatientController@ajaxGetPatientList');

    Route::resource('patient', 'PatientController');

    Route::get('type/show', 'TyperController@ajaxGetTypeList');
    Route::get('type/list', 'TypeController@ajaxGetTypeList');

    Route::resource('type', 'TypeController');

    Route::resource('comment', 'CommentController');
});

//接口
Route::group(['namespace' => 'Admin'], function() {
    Route::get('patient/regist', 'PatientController@regist');
    Route::get('doctor/regist', 'DoctorController@regist');
    Route::get('slevelcategory', 'CategoryController@getSecondLevelCategory');
    Route::get('getcategorysbypid', 'CategoryController@getCategorysByParentId');
    Route::get('getportaldata', 'DoctorController@getPortalData');
    Route::get('getdoctorsybywhere', 'DoctorController@getDoctorsByWhere');
    Route::get('getDoctorAllInfoById', 'DoctorController@getDoctorAllInfoById');
    Route::get('getDoctorPartInfoById', 'DoctorController@getDoctorPartInfoById');
    Route::get('follow', 'DoctorController@follow');
    Route::get('zan', 'DoctorController@zan');
    Route::get('hate', 'DoctorController@hate');
    Route::get('ajaxGetDoctorComments', "DoctorController@ajaxGetDoctorComments");
    Route::get('getdoctorById', "DoctorController@getdoctorById");
    Route::get('getCategorys', "CategoryController@ajaxGetCategoryList");
    Route::get('ajaxUpdateDoctor', "DoctorController@ajaxUpdateDoctor");
    Route::get('doctorResetPassword', "DoctorController@doctorResetPassword");
    Route::get('getDiagnoseInfo', "DoctorController@ajaxGetDoctorDiagnoses");
    Route::get('getDiagnoseInfo', "DoctorController@getDiagnoseInfo");
    Route::get('ajaxGetDoctorDiagnoses', "DoctorController@ajaxGetDoctorDiagnoses");
    Route::get('getFollowedInfo', "DoctorController@getFollowedInfo");
    Route::get('getDoctorFolloweds', "DoctorController@ajaxGetDoctorFolloweds");
    Route::get('getFollowInfo', "PatientController@getFollowInfo");
    Route::get('getMyFollows', "PatientController@ajaxGetPatientFollows");
    Route::get('getCommentInfo', "PatientController@getCommentInfo");
    Route::get('ajaxGetComments', "PatientController@getCommentsByPatId");
    Route::get('getpatientById', "PatientController@getpatientById");
    Route::get('ajaxUpdatePatient', "PatientController@ajaxUpdatePatient");
    Route::get('patientResetPassword', "PatientController@patientResetPassword");
    Route::get('changeOnline', "DoctorController@changeOnline");
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