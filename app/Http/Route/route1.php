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

    Route::post("api/Upload/imgUpload","UploadController@imgUpload");
    Route::post("api/Upload/excelUpload","UploadController@excelUpload");
    Route::post("api/Upload/filesUpload","UploadController@filesUpload");


});
Route::group(['namespace' => 'V1','middleware' => ['adminApi']], function () {
    Route::post("api/Index/index","IndexController@index");
    Route::post("api/User/createAministrators","UserController@createAministrators");
    Route::post("api/User/createUser","UserController@createUser");
    Route::post("api/User/updateUser","UserController@updateUser");
    Route::post("api/User/getUserInfo","UserController@getUserInfo");
    Route::post("api/User/deleteUser","UserController@deleteUser");
    Route::post("api/User/getUserList","UserController@getUserList");

    Route::post("api/User/createUserConferees","UserController@createUserConferees");
    Route::post("api/User/updateUserConferees","UserController@updateUserConferees");
    Route::post("api/User/getUserConfereesInfo","UserController@getUserConfereesInfo");
    Route::post("api/User/deleteUserConferees","UserController@deleteUserConferees");
    Route::post("api/User/getUserConfereesList","UserController@getUserConfereesList");
    Route::post("api/User/getUserConfereesListFile","UserController@getUserConfereesListFile");


    Route::post("api/Rooms/createRooms","RoomsController@createRooms");
    Route::post("api/Rooms/updateRooms","RoomsController@updateRooms");
    Route::post("api/Rooms/deleteRooms","RoomsController@deleteRooms");
    Route::post("api/Rooms/getRoomsList","RoomsController@getRoomsList");
    Route::post("api/Rooms/getRoomsInfo","RoomsController@getRoomsInfo");

    Route::post("api/Rooms/createRoomsConfig","RoomsController@createRoomsConfig");
    Route::post("api/Rooms/updateRoomsConfig","RoomsController@updateRoomsConfig");
    Route::post("api/Rooms/getRoomsConfigInfo","RoomsController@getRoomsConfigInfo");
    Route::post("api/Rooms/getRoomsConfigList","RoomsController@getRoomsConfigList");
    Route::post("api/Rooms/deleteRoomsConfig","RoomsController@deleteRoomsConfig");

    Route::post("api/Rooms/createRoomsSeats","RoomsController@createRoomsSeats");
    Route::post("api/Rooms/updateRoomsSeats","RoomsController@updateRoomsSeats");
    Route::post("api/Rooms/getRoomsSeatsInfo","RoomsController@getRoomsSeatsInfo");
    Route::post("api/Rooms/getRoomsSeatsList","RoomsController@getRoomsSeatsList");
    Route::post("api/Rooms/deleteRoomsSeats","RoomsController@deleteRoomsSeats");

    Route::post("api/Rooms/getSeatsList","RoomsController@getSeatsList");

    Route::post("api/Meeting/createMeeting","MeetingController@createMeeting");
    Route::post("api/Meeting/updateMeeting","MeetingController@updateMeeting");
    Route::post("api/Meeting/deleteMeeting","MeetingController@deleteMeeting");
    Route::post("api/Meeting/getMeetingList","MeetingController@getMeetingList");
    Route::post("api/Meeting/getMeetingInfo","MeetingController@getMeetingInfo");

    Route::post("api/Meeting/createAgenda","MeetingController@createAgenda");
    Route::post("api/Meeting/updateAgenda","MeetingController@updateAgenda");
    Route::post("api/Meeting/deleteAgenda","MeetingController@deleteAgenda");
    Route::post("api/Meeting/getAgendaList","MeetingController@getAgendaList");
    Route::post("api/Meeting/getAgendaInfo","MeetingController@getAgendaInfo");

    Route::post("api/Meeting/createVote","MeetingController@createVote");
    Route::post("api/Meeting/updateVote","MeetingController@updateVote");
    Route::post("api/Meeting/deleteVote","MeetingController@deleteVote");
    Route::post("api/Meeting/getVoteList","MeetingController@getVoteList");
    Route::post("api/Meeting/getVoteInfo","MeetingController@getVoteInfo");
    Route::post("api/Meeting/endMeeting","MeetingController@endMeeting");

    Route::post("api/Meeting/createAttachment","MeetingController@createAttachment");
    Route::post("api/Meeting/updateAttachment","MeetingController@updateAttachment");
    Route::post("api/Meeting/deleteAttachment","MeetingController@deleteAttachment");
    Route::post("api/Meeting/getAttachmentList","MeetingController@getAttachmentList");
    Route::post("api/Meeting/getAttachmentInfo","MeetingController@getAttachmentInfo");


    Route::post("api/Meeting/signUserList","MeetingController@signUserList");
    Route::post("api/Meeting/getMeetingAuth","MeetingController@getMeetingAuth");
    Route::post("api/Meeting/sendEmail","MeetingController@sendEmail");

    Route::get("api/Upload/getExcelSeats","UploadController@getExcelSeats");
    Route::get("api/Upload/getExcelUser","UploadController@getExcelUser");

});

