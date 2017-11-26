<?php
/**
 * Created by PhpStorm.
 * User: lingjianhua
 * Date: 2017/11/25
 * Time: 下午2:18
 */
/**----  V1版本  ---**/
Route::group(['namespace' => 'V1'],function (){
    Route::post("api/User/login","UserController@login");
});
Route::group(['namespace' => 'V1','middleware' => ['adminApi']], function () {
    Route::post("api/Index/index","IndexController@index");
    Route::post("api/User/createUser","UserController@createUser");
    Route::post("api/User/createAministrators","UserController@createAministrators");
    Route::post("api/User/updateUser","UserController@updateUser");
    Route::post("api/User/getUserInfo","UserController@getUserInfo");
    Route::post("api/User/deleteUser","UserController@deleteUser");
    Route::post("api/User/getUserList","UserController@getUserList");
    Route::post("api/User/deleteUser","UserController@deleteUser");



    Route::post("api/Rooms/createRooms","RoomsController@createRooms");
    Route::post("api/Rooms/updateRooms","RoomsController@updateRooms");
    Route::post("api/Rooms/deleteRooms","RoomsController@deleteRooms");
    Route::post("api/Rooms/getRoomsList","RoomsController@getRoomsList");
    Route::post("api/Rooms/getRoomsInfo","RoomsController@getRoomsInfo");

    Route::post("api/Rooms/createRooms","RoomsController@createRooms");
    Route::post("api/Rooms/createRooms","RoomsController@createRooms");
});