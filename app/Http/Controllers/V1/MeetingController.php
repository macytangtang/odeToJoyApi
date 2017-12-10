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
        $res = DB::table('conferences')->insertGetId($data);
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
     * @param int $status (必填,1未开始，2开会中，3以结束)
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
        $a = 0;
        if (isset($data['status'])){
            $a = $data['status'];
        }
        $res = DB::table('conferences')
            ->where(function($query) use($a){
                if ($a > 0){
                    $query->where('status','=',$a);
                }else{
                    $query->where('status','>',$a);
                }

            })
            ->orderBy('update_time','desc')
            ->get();
        foreach ($res as $key){
            if ($key->status == 1){
                $key->status_name = "未开会";
            }elseif ($key->status == 2){
                $key->status_name = "开会中";
            }else if($key->status == 3){
                $key->status_name = "已结束";
            }
        }
        if ($res){
            $this->returnJson(array('list'=>$res,'count'=>count($res)));
        }else{
            $this->returnJson(array());
        }
    }
    /**
     * 开始或结束会议室
     * @param string $token (必填)
     * @param int $conference_id (必填,会议ID)
     * @param int $status (必填,状态 1未开始，2开会中，3结束)
     * @return data 200成功
     */
    public function endMeeting()
    {
        $data = $this->getPost($_POST);
        $res = DB::table('conferences')->where('conference_id',$data['conference_id'])->update(array('status'=>$data['status']));
        if ($res){
            $this->returnJson($res);
        }else{
            $this->error(-1,'结束会议室失败');
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
     * @param int $conference_id (必填,所属会议ID)
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
            ->where('conference_id',$data['conference_id'])
            ->orderBy('update_time','desc')
            ->get();

        $count = DB::table('conference_agendas')->where('conference_id',$data['conference_id'])->where('status','>',-1)->orderBy('update_time','desc')->count();

        if ($res && $count){

            foreach ($res as $key){
                $key->hostess_name = DB::table("users")->where("user_id",$key->hostess_id)->value("name");
            }

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
            $res->hostess_name = DB::table("users")->where("user_id",$res->hostess_id)->value("name");
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
    /**
     * 创建会议附件
     * @param string $token (必填)
     * @param int $agenda_id (必填,所属议程ID)
     * @param string $title (必填)
     * @param string $owner_id (必填,材料所属人)
     * @param string $file_url (必填,材料地址)
     * @param int $attach_type (必填,材料类型 1 系统 2 用户批注)
     * @param int $conference_id (必填,会议ID)
     * @return data 200成功
     */
    public function createAttachment()
    {
        $data = $this->getPost($_POST);
        $data['create_time'] = date('Y-m-d H:i:s',time());
        $data['update_time'] = date('Y-m-d H:i:s',time());
        $res = DB::table('conference_attachments')->insertGetId($data);
        if ($res){
            $this->returnJson($res);
        }else{
            $this->error(-1,'新增会议附件失败');
        }
    }
    /**
     * 获取会议附件列表
     * @param string $token (必填)
     * @param int $page (必填,页数)
     * @param int $conference_id (必填,会议ID)
     * @return data 200成功
     */
    public function getAttachmentList()
    {
        $data = $this->getPost($_POST);
        $res = DB::table('conference_attachments as a')
            ->select(DB::RAW('a.*,b.title as agenda_title,c.name'))
            ->leftjoin('conference_agendas as b','a.agenda_id','=','b.agenda_id')
            ->leftjoin('users as c','a.owner_id','=','c.user_id')
            ->where('a.status','>',-1)
            ->where('a.conference_id',$data['conference_id'])
            ->orderBy('a.update_time','desc')
            ->get();
        if ($res){
            $this->returnJson(array('list'=>$res,'count'=>count($res)));
        }else{
            $this->returnJson(array());
        }
    }
    /**
     * 获取会议附件详情
     * @param string $token (必填)
     * @param int $attachment_id (必填)
     * @return data 200成功
     */
    public function getAttachmentInfo()
    {
        $data = $this->getPost($_POST);
        //$res = DB::table('conference_attachments')->where('attachment_id',$data['attachment_id'])->first();
        $res = DB::table('conference_attachments as a')
            ->select(DB::RAW('a.*,b.title as agenda_title,c.name'))
            ->leftjoin('conference_agendas as b','a.agenda_id','=','b.agenda_id')
            ->leftjoin('users as c','a.owner_id','=','c.user_id')
            ->where('a.status','>',-1)
            ->where('a.attachment_id',$data['attachment_id'])
            ->orderBy('a.update_time','desc')
            ->first();
        if ($res){
            $this->returnJson($res);
        }else{
            $this->error(-1,'获取会议附件详情失败');
        }
    }
    /**
     * 更新会议附件
     * @param string $token (必填)
     * @param int $agenda_id (必填,所属议程ID)
     * @param string $title (必填)
     * @param string $owner_id (必填,材料所属人)
     * @param string $file_url (必填,材料地址)
     * @param int $attach_type (必填,材料类型 1 系统 2 用户批注)
     * @param int $attachment_id (必填,附件ID)
     * @param int $conference_id (必填,会议ID)
     * @return data 200成功
     */
    public function updateAttachment()
    {
        $data = $this->getPost($_POST);
        $data['update_time'] = date('Y-m-d H:i:s',time());
        $attachment_id = $data['attachment_id'];
        unset($data['attachment_id']);
        $res = DB::table('conference_attachments')->where('attachment_id',$attachment_id)->update($data);
        if ($res){
            $this->returnJson($res);
        }else{
            $this->error(-1,'更新会议附件失败');
        }
    }
    /**
     * 删除会议附件
     * @param string $token (必填)
     * @param int $attachment_id (必填,附件ID)
     * @return data 200成功
     */
    public function deleteAttachment()
    {
        $data = $this->getPost($_POST);

        $res = DB::table('conference_attachments')->where('attachment_id',$data['attachment_id'])->update(array('status'=>-1));
        if ($res){
            $this->returnJson($res);
        }else{
            $this->error(-1,'删除会议附件失败');
        }
    }
    /**
     * 会议签到列表
     * @param string $token (必填)
     * @param int $conference_id (必填,会议ID)
     * @return data 200成功
     */
    public function signUserList()
    {
        $data = $this->getPost($_POST);
        $res = DB::table('sign_in as a')
            ->leftjoin('conferees as b','a.conferee_id','=','b.conferee_id')
            ->leftjoin('seats as c','b.seat_id','=','c.seat_id')
            ->select(DB::Raw('a.create_time,a.conferee_id,a.conference_id,a.sign_in_id,b.name,b.seat_id,c.seat_code'))
            ->where('a.conference_id',$data['conference_id'])
            ->get();
        if ($res){
            $this->returnJson($res);
        }else{
            $this->returnJson(array());
        }
    }
    /**
     * 会议权限
     * @param string $token (必填)
     * @param int $conferee_id (必填,参会人ID)
     * @param int $conference_id (必填,会议ID)
     * @param int $upload_file (必填,材料ID上传)
     * @param int $download_file (必填,材料ID下载)
     * @return data 200成功
     */
    public function getMeetingAuth()
    {
        $data = $this->getPost($_POST);

        $getSeatId = DB::table('conferees')->where('conferee_id',$data['conferee_id'])->value('seat_id');

        $a = 0;
        if (isset($data['upload_file'])){
            $a = $data['upload_file'];
        }
        $b = 0;
        if (isset($data['download_file'])){

        }
        $checkId = DB::table('conference_authorities')
            ->where('conferee_id',$data['conferee_id'])
            ->where('conference_id',$data['conference_id'])
            ->where(function ($query) use($a,$b){
                if ($a){
                    $query->where('upload_file',$a);
                }
                if ($b){
                    $query->where('download_file',$b);
                }

            })
            ->first();
        if ($checkId){
            $data['seat_id'] = $getSeatId;
            $data['update_time'] = date('Y-m-d H:i:s');
            $res = DB::table('conference_authorities')->where('conferee_id',$data['conferee_id'])
                ->where('conference_id',$data['conference_id'])->update($data);
        }else{
            $data['seat_id'] = $getSeatId;
            $data['create_time'] = date('Y-m-d H:i:s');
            $data['update_time'] = date('Y-m-d H:i:s');
            $res = DB::table('conference_authorities')->insertGetId($data);
        }
        if ($res){
            $this->returnJson($res);
        }else{
            $this->error(-1,'修改会议权限失败');
        }
    }
    /**
     * 会议信息发布
     * @param string $token (必填)
     * @param string $emailUser (必填,多个用逗号隔开)
     * @param string $title (必填,主题)
     * @param string $content (必填,内容)
     * @param string $file_url (必填,附件)
     * @return data 200成功
     */
    public function sendEmail()
    {
        $data = $this->getPost($_POST);
        if (isset($data['file_url']) && $data['file_url'] != null){
            $path = explode('/',$data['file_url']);
            //文件路径
            $file_path = public_path()."/".$path[3]."/".$path[4]."/".$path[5];
        }

        /*****发送邮件****start*****/

        /*****End****/

        $this->returnJson($data);

    }
    /**
     * 会议表决结果
     * @param string $token (必填)
     * @param int $conference_id (必填,会议ID)
     * @return data 200成功
     */
    public function getVoteMeetingResult()
    {
        $data = $this->getPost($_POST);

        $checkId = DB::table('vote_topics')->where('conference_id',$data['conference_id'])->get();
    }
}
