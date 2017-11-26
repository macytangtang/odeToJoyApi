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
            $this->error(-1,'新增会议失败');
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
            $this->error(-1,'更新会议失败');
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
            $this->error(-1,'删除会议失败');
        }
    }
    /**
     * 获取会议列表
     * @param string $token (必填)
     * @param int $page (必填,页数)
     * @return data 200成功
     */
    public function getRoomsList()
    {
        $data = $this->getPost($_POST);
        if ($data['page'] == 1){
            $pageCountRecord = 0;
        }else{
            $pageCountRecord = ($data['page']-1) * 20;
        }
        $res = DB::table('rooms')
            ->offset($pageCountRecord)
            ->limit(20)
            ->orderBy('update_time','desc')
            ->get();

        $count = DB::table('rooms')->orderBy('update_time','desc')->count();

        if ($res && $count){
            $this->returnJson(array('list'=>$res,'count'=>$count));
        }else{
            $this->error(-1,'无数据');
        }
    }
    /**
     * 获取会议详情
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
            $this->error(-1,'获取会议详情失败');
        }
    }
}
