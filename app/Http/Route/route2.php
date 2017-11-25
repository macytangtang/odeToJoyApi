<?php
/**
 * Created by PhpStorm.
 * User: lingjianhua
 * Date: 2017/11/25
 * Time: 下午2:19
 */
/**----  V1版本  ---**/
Route::group(['namespace' => 'V1','middleware' => ['adminApi']], function () {
    Route::get("api/index_2","IndexController@index");
});