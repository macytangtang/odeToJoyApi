<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
/**
 * 会议接口
 *
 * 所有会议室接口相关操作放在本类
 * @package V1
 */
class MeetingController extends Controller
{
    //
    /**
     * 创建会议
     * @param string $token (必填)
     * @param string $title (必填)
     * @param int $is_secrecy (必填,是否保密,1是0否)
     * @param string $rooms (必填，会议室room_id,多个逗号隔开)
     * @param string $start_time (必填,开始时间)
     * @param string $end_time (必填,结束时间)
     * @param int $conferee_num (必填，参会人数)
     * @param int $clerk_id (必填，会议秘书)
     * @param string $department (必填，申请部门)
     * @param string $description (必填，备注)
     * @param int $status (必填,1有效，0无效)
     * @param string $services (必填,会议室服务配置id,多个逗号隔开)
     * @param string $functions (必填,会议功能配置id,多个逗号隔开)
     * @return data 200成功
     */
    public function createMeeting()
    {
        $data = $this->getPost($_POST);
        $data['create_time'] = date('Y-m-d H:i:s',time());
        $data['update_time'] = date('Y-m-d H:i:s',time());
        $res = DB::table('conferences')->insert($data);
        if ($res){
            $this->returnJson($res);
        }else{
            $this->error(-1,'新增会议失败');
        }
    }
    /**
     * 更新会议
     * @param string $token (必填)
     * @param int $conference_id (必填)
     * @param string $title (必填)
     * @param int $is_secrecy (必填,是否保密,1是0否)
     * @param string $rooms (必填，会议室room_id,多个逗号隔开)
     * @param string $start_time (必填,开始时间)
     * @param string $end_time (必填,结束时间)
     * @param int $conferee_num (必填，参会人数)
     * @param int $clerk_id (必填，会议秘书)
     * @param string $department (必填，申请部门)
     * @param string $description (必填，备注)
     * @param int $status (必填,1有效，0无效)
     * @param string $services (必填,会议室服务配置id,多个逗号隔开)
     * @param string $functions (必填,会议功能配置id,多个逗号隔开)
     * @return data 200成功
     */
    public function updateMeeting()
    {
        $data = $this->getPost($_POST);
        $data['update_time'] = date('Y-m-d H:i:s',time());
        $conference_id = $data['conference_id'];
        unset($data['room_id']);

        $res = DB::table('conferences')->where('conference_id',$conference_id)->update($data);
        if ($res){
            $this->returnJson($res);
        }else{
            $this->error(-1,'更新会议失败');
        }
    }
    /**
     * 获取会议详情
     * @param string $token (必填)
     * @param int $conference_id (必填)
     * @return data 200成功
     */
    public function getMeetingInfo()
    {
        $data = $this->getPost($_POST);
        $res = DB::table('conferences')->where('conference_id',$data['conference_id'])->first();
        if ($res){
            $this->returnJson($res);
        }else{
            $this->error(-1,'获取会议详情失败');
        }
    }
    /**
     * 获取会议列表
     * @param string $token (必填)
     * @param int $page (必填,页数)
     * @return data 200成功
     */
    public function getMeetingList()
    {
        $data = $this->getPost($_POST);
//        if ($data['page'] == 1){
//            $pageCountRecord = 0;
//        }else{
//            $pageCountRecord = ($data['page']-1) * 20;
//        }
        $res = DB::table('conferences')
            //->offset($pageCountRecord)
            //->limit(20)
            ->where('status','>',-1)
            ->orderBy('update_time','desc')
            ->get();

        $count = DB::table('conferences')->where('status','>',-1)->orderBy('update_time','desc')->count();

        if ($res && $count){
            $this->returnJson(array('list'=>$res,'count'=>$count));
        }else{
            $this->returnJson(array());
        }
    }
    /**
     * 删除会议室
     * @param string $token (必填)
     * @param int $conference_id (必填,会议ID)
     * @return data 200成功
     */
    public function deleteMeeting()
    {
        $data = $this->getPost($_POST);

        $res = DB::table('conferences')->where('conferences',$data['conference_id'])->update(array('status'=>-1));
        if ($res){
            $this->returnJson($res);
        }else{
            $this->error(-1,'删除会议室失败');
        }
    }
    /**
     * 创建会议议程
     * @param string $token (必填)
     * @param int $conference_id (必填,会议ID)
     * @param string $agenda_code (必填,议程编号)
     * @param string $title (必填,议程主题)
     * @param string $start_time (必填,开始时间)
     * @param string $end_time (必填,结束时间)
     * @param int $hostess_id (必填,主持人id)
     * @param int $status (必填,状态 0 无效 1有效)
     * @return data 200成功
     */
    public function createAgenda()
    {
        $data = $this->getPost($_POST);
        $data['create_time'] = date('Y-m-d H:i:s',time());
        $data['update_time'] = date('Y-m-d H:i:s',time());
        $res = DB::table('conference_agendas')->insert($data);
        if ($res){
            $this->returnJson($res);
        }else{
            $this->error(-1,'新增会议议程失败');
        }
    }
    /**
     * 获取会议议程列表
     * @param string $token (必填)
     * @param int $page (必填,页数)
     * @return data 200成功
     */
    public function getAgendaList()
    {
        $data = $this->getPost($_POST);
//        if ($data['page'] == 1){
//            $pageCountRecord = 0;
//        }else{
//            $pageCountRecord = ($data['page']-1) * 20;
//        }
        $res = DB::table('conference_agendas')
            //->offset($pageCountRecord)
            //->limit(20)
            ->where('status','>',-1)
            ->orderBy('update_time','desc')
            ->get();

        $count = DB::table('conference_agendas')->where('status','>',-1)->orderBy('update_time','desc')->count();

        if ($res && $count){
            $this->returnJson(array('list'=>$res,'count'=>$count));
        }else{
            $this->returnJson(array());
        }
    }
    /**
     * 获取会议详情
     * @param string $token (必填)
     * @param int $conference_id (必填)
     * @return data 200成功
     */
    public function getAgendaInfo()
    {
        $data = $this->getPost($_POST);
        $res = DB::table('conference_agendas')->where('agenda_id',$data['agenda_id'])->first();
        if ($res){
            $this->returnJson($res);
        }else{
            $this->error(-1,'获取会议议程详情失败');
        }
    }
    /**
     * 更新会议议程
     * @param string $token (必填)
     * @param int $conference_id (必填,会议ID)
     * @param int $agenda_id (必填,会议议程ID)
     * @param string $agenda_code (必填,议程编号)
     * @param string $title (必填,议程主题)
     * @param string $start_time (必填,开始时间)
     * @param string $end_time (必填,结束时间)
     * @param int $hostess_id (必填,主持人id)
     * @param int $status (必填,状态 0 无效 1有效)
     * @return data 200成功
     */
    public function updateAgenda()
    {
        $data = $this->getPost($_POST);
        $data['update_time'] = date('Y-m-d H:i:s',time());
        $agenda_id = $data['agenda_id'];
        unset($data['agenda_id']);
        $res = DB::table('conference_agendas')->where('agenda_id',$agenda_id)->update($data);
        if ($res){
            $this->returnJson($res);
        }else{
            $this->error(-1,'更新会议议程失败');
        }
    }
    /**
     * 删除会议议程
     * @param string $token (必填)
     * @param int $agenda_id (必填,会议议程ID)
     * @return data 200成功
     */
    public function deleteAgenda()
    {
        $data = $this->getPost($_POST);

        $res = DB::table('conference_agendas')->where('agenda_id',$data['agenda_id'])->update(array('status'=>-1));
        if ($res){
            $this->returnJson($res);
        }else{
            $this->error(-1,'删除会议议程失败');
        }
    }

    /**
     * 创建会议表决主题
     * @param string $token (必填)
     * @param int $conference_id (必填,会议ID)
     * @param string $title (必填,表决主题)
     * @param string $topic_items (必填,表决项目.多个逗号隔开)
     * @param int $topic_type (必填,表决类型)
     * @param int $status (必填,状态 0 无效 1有效)
     * @return data 200成功
     */
    public function createVote()
    {
        $data = $this->getPost($_POST);
        $data['create_time'] = date('Y-m-d H:i:s',time());
        $data['update_time'] = date('Y-m-d H:i:s',time());
        $res = DB::table('vote_topics')->insert($data);
        if ($res){
            $this->returnJson($res);
        }else{
            $this->error(-1,'新增会议表决主题失败');
        }
    }
    /**
     * 获取会议表决主题列表
     * @param string $token (必填)
     * @param int $page (必填,页数)
     * @return data 200成功
     */
    public function getVoteList()
    {
        $data = $this->getPost($_POST);
//        if ($data['page'] == 1){
//            $pageCountRecord = 0;
//        }else{
//            $pageCountRecord = ($data['page']-1) * 20;
//        }
        $res = DB::table('vote_topics')
            //->offset($pageCountRecord)
            //->limit(20)
            ->where('status','>',-1)
            ->orderBy('update_time','desc')
            ->get();

        $count = DB::table('vote_topics')->where('status','>',-1)->orderBy('update_time','desc')->count();

        if ($res && $count){
            $this->returnJson(array('list'=>$res,'count'=>$count));
        }else{
            $this->returnJson(array());
        }
    }
    /**
     * 获取会议表决主题详情
     * @param string $token (必填)
     * @param int $topic_id (必填)
     * @return data 200成功
     */
    public function getVoteInfo()
    {
        $data = $this->getPost($_POST);
        $res = DB::table('vote_topics')->where('topic_id',$data['topic_id'])->first();
        if ($res){
            $this->returnJson($res);
        }else{
            $this->error(-1,'获取会议表决主题详情失败');
        }
    }
    /**
     * 更新会议表决主题
     * @param string $token (必填)
     * @param int $topic_id (必填)
     * @param int $conference_id (必填,会议ID)
     * @param string $title (必填,表决主题)
     * @param string $topic_items (必填,表决项目.多个逗号隔开)
     * @param int $topic_type (必填,表决类型)
     * @param int $status (必填,状态 0 无效 1有效)
     * @return data 200成功
     */
    public function updateVote()
    {
        $data = $this->getPost($_POST);
        $data['update_time'] = date('Y-m-d H:i:s',time());
        $topic_id = $data['topic_id'];
        unset($data['topic_id']);
        $res = DB::table('vote_topics')->where('topic_id',$topic_id)->update($data);
        if ($res){
            $this->returnJson($res);
        }else{
            $this->error(-1,'更新会议表决主题失败');
        }
    }
    /**
     * 删除会议表决主题
     * @param string $token (必填)
     * @param int $agenda_id (必填,会议表决主题ID)
     * @return data 200成功
     */
    public function deleteVote()
    {
        $data = $this->getPost($_POST);

        $res = DB::table('vote_topics')->where('topic_id',$data['topic_id'])->update(array('status'=>-1));
        if ($res){
            $this->returnJson($res);
        }else{
            $this->error(-1,'删除会议表决主题失败');
        }
    }
}
