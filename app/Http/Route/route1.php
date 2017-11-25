<?php
/**
 * Created by PhpStorm.
 * User: lingjianhua
 * Date: 2017/11/25
 * Time: 下午2:18
 */
/**----  V1版本  ---**/
Route::group(['namespace' => 'V1','middleware' => ['adminApi']], function () {
    Route::post("api/Index/index","IndexController@index");
    Route::post("api/User/createUser","UserController@createUser");
});