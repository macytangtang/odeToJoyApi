<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

/**
 * 会议室接口
 *
 * 所有会议室接口相关操作放在本类
 * @package V1
 */
class RoomsController extends Controller
{
    //
    /**
     * 创建会议室
     * @param string $token (必填)
     * @param string $title (必填)
     * @param string $room_code (必填,会议室编号)
     * @param string $location (必填，位置)
     * @param string $seats_num (必填,坐席数)
     * @param string $manager_id (必填，负责人id)
     * @param string $img_map (必填，图片url)
     * @param int $status (选填,1有效，0无效)
     * @return data 200成功
     */
    public function createRooms()
    {
        $data = $this->getPost($_POST);
        $data['create_time'] = date('Y-m-d H:i:s',time());
        $data['update_time'] = date('Y-m-d H:i:s',time());
        $res = DB::table('rooms')->insert($data);
        if ($res){
            $this->returnJson($res);
        }else{
            $this->error(-1,'新增会议室失败');
        }
    }
    /**
     * 更新会议室
     * @param string $token (必填)
     * @param string $title (必填)
     * @param string $room_code (必填,会议室编号)
     * @param string $location (必填，位置)
     * @param string $seats_num (必填,坐席数)
     * @param string $manager_id (必填，负责人)
     * @param string $img_map (必填，图片url)
     * @param int $status (选填,1有效，0无效)
     * @param int $room_id (必填,会议室ID)
     * @return data 200成功
     */
    public function updateRooms()
    {
        $data = $this->getPost($_POST);
        $data['update_time'] = date('Y-m-d H:i:s',time());
        $room_id = $data['room_id'];
        unset($data['room_id']);

        $res = DB::table('rooms')->where('room_id',$room_id)->update($data);
        if ($res){
            $this->returnJson($res);
        }else{
            $this->error(-1,'更新会议室失败');
        }
    }
    /**
     * 删除会议室
     * @param string $token (必填)
     * @param int $room_id (必填,会议室ID)
     * @return data 200成功
     */
    public function deleteRooms()
    {
        $data = $this->getPost($_POST);

        $res = DB::table('rooms')->where('room_id',$data['room_id'])->update(array('status'=>-1));
        if ($res){
            $this->returnJson($res);
        }else{
            $this->error(-1,'删除会议室失败');
        }
    }
    /**
     * 获取会议室列表
     * @param string $token (必填)
     * @param int $page (必填,页数)
     * @return data 200成功
     */
    public function getRoomsList()
    {
        $data = $this->getPost($_POST);
//        if ($data['page'] == 1){
//            $pageCountRecord = 0;
//        }else{
//            $pageCountRecord = ($data['page']-1) * 20;
//        }
        $res = DB::table('rooms')
            //->offset($pageCountRecord)
            //->limit(20)
            ->orderBy('update_time','desc')
            ->get();

        $count = DB::table('rooms')->where('status','>',-1)->orderBy('update_time','desc')->count();

        if ($res && $count){
            $this->returnJson(array('list'=>$res,'count'=>$count));
        }else{
            $this->returnJson(array());
        }
    }
    /**
     * 获取会议室详情
     * @param string $token (必填)
     * @param int $room_id (必填)
     * @return data 200成功
     */
    public function getRoomsInfo()
    {
        $data = $this->getPost($_POST);
        $res = DB::table('rooms')->where('room_id',$data['room_id'])->first();
        if ($res){
            $this->returnJson($res);
        }else{
            $this->error(-1,'获取会议室详情失败');
        }
    }
    /**
     * 创建会议室配置
     * @param string $token (必填)
     * @param string $title (必填,配置名称)
     * @param string $description (必填,会议室备注)
     * @param int $config_type (必填,配置类型 1 services 如：茶水 2 function 如：投影)
     * @param int $status (选填,1有效，0无效)
     * @return data 200成功
     */
    public function createRoomsConfig()
    {
        $data = $this->getPost($_POST);
        $data['create_time'] = date('Y-m-d H:i:s',time());
        $data['update_time'] = date('Y-m-d H:i:s',time());
        $res = DB::table('room_configs')->insert($data);
        if ($res){
            $this->returnJson($res);
        }else{
            $this->error(-1,'新增会议室配置失败');
        }
    }
    /**
     * 更新会议室配置
     * @param string $token (必填)
     * @param string $title (必填,配置名称)
     * @param int $config_id (必填,会议室配置id)
     * @param string $description (必填,会议室备注)
     * @param int $config_type (必填,配置类型 1 services 如：茶水 2 function 如：投影)
     * @param int $status (必填,1有效，0无效)
     * @return data 200成功
     */
    public function updateRoomsConfig()
    {
        $data = $this->getPost($_POST);
        $data['update_time'] = date('Y-m-d H:i:s',time());
        $config_id = $data['config_id'];
        unset($data['config_id']);

        $res = DB::table('room_configs')->where('config_id',$config_id)->update($data);
        if ($res){
            $this->returnJson($res);
        }else{
            $this->error(-1,'更新会议室配置失败');
        }
    }
    /**
     * 获取会议室配置详情
     * @param string $token (必填)
     * @param int $config_id (必填)
     * @return data 200成功
     */
    public function getRoomsConfigInfo()
    {
        $data = $this->getPost($_POST);
        $res = DB::table('room_configs')->where('config_id',$data['config_id'])->first();
        if ($res){
            $this->returnJson($res);
        }else{
            $this->error(-1,'获取会议室配置详情失败');
        }
    }
    /**
     * 获取会议室配置列表
     * @param string $token (必填)
     * @param int $page (必填,页数)
     * @return data 200成功
     */
    public function getRoomsConfigList()
    {
        $data = $this->getPost($_POST);
//        if ($data['page'] == 1){
//            $pageCountRecord = 0;
//        }else{
//            $pageCountRecord = ($data['page']-1) * 20;
//        }
        $res = DB::table('room_configs')
            //->offset($pageCountRecord)
            //->limit(20)
            ->where('status','>',-1)
            ->orderBy('update_time','desc')
            ->get();

        $count = DB::table('room_configs')->where('status','>',-1)->orderBy('update_time','desc')->count();

        if ($res && $count){
            $this->returnJson(array('list'=>$res,'count'=>$count));
        }else{
            $this->returnJson(array());
        }
    }
    /**
     * 删除会议室配置
     * @param string $token (必填)
     * @param int $config_id (必填,会议室配置ID)
     * @return data 200成功
     */
    public function deleteRoomsConfig()
    {
        $data = $this->getPost($_POST);

        $res = DB::table('room_configs')->where('config_id',$data['config_id'])->update(array('status'=>-1));
        if ($res){
            $this->returnJson($res);
        }else{
            $this->error(-1,'删除会议室配置失败');
        }
    }
    /**
     * 创建会议室坐席
     * @param string $token (必填)
     * @param int $room_id (必填,会议室ID)
     * @param string $seat_code (必填,坐席编号)
     * @param string $seat_ip (必填,坐席IP)
     * @param int $status (必填,状态 0 无效 1有效)
     * @return data 200成功
     */
    public function createRoomsSeats()
    {
        $data = $this->getPost($_POST);
        $data['create_time'] = date('Y-m-d H:i:s',time());
        $data['update_time'] = date('Y-m-d H:i:s',time());
        $res = DB::table('seats')->insert($data);
        if ($res){
            $this->returnJson($res);
        }else{
            $this->error(-1,'新增会议坐席失败');
        }
    }
    /**
     * 更新会议室坐席
     * @param string $token (必填)
     * @param int $seat_id (必填)
     * @param int $room_id (必填,会议室ID)
     * @param string $seat_code (必填,坐席编号)
     * @param string $seat_ip (必填,坐席IP)
     * @param int $status (必填,状态 0 无效 1有效)
     * @return data 200成功
     */
    public function updateRoomsSeats()
    {
        $data = $this->getPost($_POST);
        $data['update_time'] = date('Y-m-d H:i:s',time());
        $seat_id = $data['seat_id'];
        unset($data['seat_id']);

        $res = DB::table('seats')->where('seat_id',$seat_id)->update($data);
        if ($res){
            $this->returnJson($res);
        }else{
            $this->error(-1,'更新会议坐席失败');
        }
    }
    /**
     * 获取会议室坐席详情
     * @param string $token (必填)
     * @param int $seat_id (必填)
     * @return data 200成功
     */
    public function getRoomsSeatsInfo()
    {
        $data = $this->getPost($_POST);
        $res = DB::table('seats')->where('seat_id',$data['seat_id'])->first();
        if ($res){
            $this->returnJson($res);
        }else{
            $this->error(-1,'获取会议坐席详情失败');
        }
    }
    /**
     * 获取会议室坐席列表
     * @param string $token (必填)
     * @param int $page (必填,页数)
     * @return data 200成功
     */
    public function getRoomsSeatsList()
    {
        $data = $this->getPost($_POST);
//        if ($data['page'] == 1){
//            $pageCountRecord = 0;
//        }else{
//            $pageCountRecord = ($data['page']-1) * 20;
//        }
        $res = DB::table('room_configs')
            //->offset($pageCountRecord)
            //->limit(20)
            ->where('status','>',-1)
            ->orderBy('update_time','desc')
            ->get();

        $count = DB::table('seats')->where('status','>',-1)->orderBy('update_time','desc')->count();

        if ($res && $count){
            $this->returnJson(array('list'=>$res,'count'=>$count));
        }else{
            $this->returnJson(array());
        }
    }
    /**
     * 删除会议室坐席配置
     * @param string $token (必填)
     * @param int $seat_id (必填,会议坐席ID)
     * @return data 200成功
     */
    public function deleteRoomsSeats()
    {
        $data = $this->getPost($_POST);

        $res = DB::table('seats')->where('seat_id',$data['seat_id'])->update(array('status'=>-1));
        if ($res){
            $this->returnJson($res);
        }else{
            $this->error(-1,'删除会议室坐席失败');
        }
    }
    private function test(){

    }
}
