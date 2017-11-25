<?php
/**
 * 2017-05-22
 * 路由命名规则，Api+文件名+函数名
 * lingJH
 **/
/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/', function () {
    return 111;
});


Route::group(['namespace' => 'Doc'], function () {
    Route::resource('doc/index', 'DocController@index');
    Route::resource('doc/create', 'DocController@create');
});

/**
 * 防止路由冲突，各自开发均有自己独立的路由
 * 路由命名规则如下
 *      Route::post("api/Index/index","IndexController@index");
 * 注解：Route::post("api/控制器(不包含Controller)/方法名","控制器文件名@方法");
 **/
/**--- ling ---**/
include 'Route/route1.php';
/**--- end ---**/

/**--- macy ---**/
include 'Route/route2.php';
/**--- end ---**/

/**--- yi hui ---**/
include 'Route/route3.php';
/**--- end ---**/