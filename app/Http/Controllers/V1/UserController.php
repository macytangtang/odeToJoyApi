<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


/**
 * 管理员、用户接口
 *
 * 所有管理员、用户接口相关操作放在本类
 * @package V1
 */
class UserController extends Controller
{
    //
    /**
     * 创建管理员
     * @param string $token (必填)
     * @param string $name (必填)
     * @param string $password (必填)
     * @param string $description (选填)
     * @param int $status (必填)
     * @return data 200成功
     */
    public function createAministrators()
    {
        $post = $this->getPost($_POST);
        //echo $requests->session()->get('token');
        $post['create_time'] = date('Y-m-d H:i:s',time());
        $post['update_time'] = date('Y-m-d H:i:s',time());
        $post['password'] = md5($post['password']);
        $res = DB::table('administrators')->insert($post);
        if ($res){
            $this->returnJson($res);
        }else{
            $this->error(-1,'新增管理员失败');
        }
    }
    /**
     * 创建用户
     * @param string $token (必填)
     * @param string $name (必填)
     * @param string $password (必填)
     * @param int $sex (必填)
     * @param string $email (必填)
     * @param string $mobile (必填)
     * @param int $auth (必填)
     * @param string $description (选填)
     * @param int $status (必填)
     * @return data 200成功
     */
    public function createUser()
    {
        $data = $this->getPost($_POST);
        $data['create_time'] = date('Y-m-d H:i:s',time());
        $data['update_time'] = date('Y-m-d H:i:s',time());
        $data['password'] = md5($data['password']);
        $res = DB::table('users')->insert($data);
        if ($res){
            $this->returnJson($res);
        }else{
            $this->error(-1,'新增用户失败');
        }
    }
    /**
     * 更新用户
     * @param string $token (必填)
     * @param int $user_id (必填)
     * @param string $name (必填)
     * @param string $password (必填)
     * @param int $sex (必填)
     * @param string $email (必填)
     * @param string $mobile (必填)
     * @param int $auth (必填)
     * @param string $description (选填)
     * @param int $status (必填)
     * @return data 200成功
     */
    public function updateUser()
    {
        $data = $this->getPost($_POST);
        $data['update_time'] = date('Y-m-d H:i:s',time());
        if ($data['password']){
            $data['password'] = md5($data['password']);
        }
        $user_id = $data['user_id'];
        unset($data['password']);
        unset($data['user_id']);
        $res = DB::table('users')->where('user_id',$user_id)->update($data);
        if ($res){
            $this->returnJson($res);
        }else{
            $this->error(-1,'更新用户失败');
        }
    }
    /**
     * 获取用户详情
     * @param string $token (必填)
     * @param int $user_id (必填)
     * @return data 200成功
     */
    public function getUserInfo()
    {
        $data = $this->getPost($_POST);
        $res = DB::table('users')->where('user_id',$data['user_id'])->first();
        if ($res){
            $this->returnJson($res);
        }else{
            $this->error(-1,'查询用户失败');
        }
    }
    /**
     * 删除用户
     * @param string $token (必填)
     * @param int $user_id (必填)
     * @return data 200成功
     */
    public function deleteUser()
    {
        $data = $this->getPost($_POST);
        $res = DB::table('users')->where('user_id',$data['user_id'])->update(array('status'=>-1));
        if ($res){
            $this->returnJson($res);
        }else{
            $this->error(-1,'删除用户失败');
        }
    }
    /**
     * 获取用户列表
     * @param string $token (必填)
     * @param int $page (必填,页数)
     * @return data 200成功
     */
    public function getUserList()
    {
        $data = $this->getPost($_POST);
//        if ($data['page'] == 1){
//            $pageCountRecord = 0;
//        }else{
//            $pageCountRecord = ($data['page']-1) * 20;
//        }
        //$res = DB::table('users')->offset($pageCountRecord)->limit(20)->orderBy('update_time','desc')->get();
        $res = DB::table('users')->where('status','>',-1)->orderBy('update_time','desc')->get();

        $count = DB::table('users')->orderBy('update_time','desc')->count();

        if ($res && $count){
            $this->returnJson(array('list'=>$res,'count'=>$count));
        }else{
            $this->returnJson(array());
        }
    }

    /**
     * 管理员登陆
     * @param string $email (必填)
     * @param string $password (必填)
     * @return data 200成功
     */
    public function login()
    {
        $data = $this->getPost($_POST);
        $data['password'] = md5($data['password']);
        
        $res = DB::table('users')->where('email',$data['email'])->where('password',$data['password'])->first();
        
        if ($res){
            $token = md5($data['password']+date("Y-m-d"));
            $ret = DB::table('users')
                ->where('email',$data['email'])
                ->where('password',$data['password'])
                ->update(array('token'=>$token,'update_time'=>time()));
            $this->returnJson(array('token'=>$token,'name'=>$res->name,'auth'=>$res->auth,'auth_name'=>'管理员','user_id'=>$res->user_id));
        }else{
            $this->error(-1,'登陆失败');
        }
    }
    /**
     * 创建参会人
     * @param string $token (必填)
     * @param string $name (必填)
     * @param string $password (必填)
     * @param string $title (必填,职务)
     * @param string $email (必填,邮箱)
     * @param string $mobile (必填,手机)
     * @param int $seat_id (必填，坐席)
     * @param int $user_id (必填，用户ID)
     * @param int $conference_id (必填，会议id)
     * @param int $status (必填,状态 0 无效 1有效)
     * @param int $can_sync_screen (必填,是否允许发起同屏幕  0 不允许 1允许)
     * @return data 200成功
     */
    public function createUserConferees()
    {
        $data = $this->getPost($_POST);
        $data['create_time'] = date('Y-m-d H:i:s',time());
        $data['update_time'] = date('Y-m-d H:i:s',time());
        $data['password'] = md5($data['password']);
        $res = DB::table('conferees')->insertGetId($data);
        if ($res){
            $this->returnJson($res);
        }else{
            $this->error(-1,'新增参会人失败');
        }
    }
    /**
     * 更新参会人
     * @param string $token (必填)
     * @param string $name (必填)
     * @param string $password (必填)
     * @param string $title (必填,职务)
     * @param string $email (必填,邮箱)
     * @param string $mobile (必填,手机)
     * @param string $seat_id (必填，坐席)
     * @param int $user_id (必填，用户ID)
     * @param int $conference_id (必填，会议id)
     * @param int $status (必填,状态 0 无效 1有效)
     * @param int $can_sync_screen (必填,是否允许发起同屏幕  0 不允许 1允许)
     * @param int $conferee_id (必填,参会人ID)
     * @return data 200成功
     */
    public function updateUserConferees()
    {
        $data = $this->getPost($_POST);
        $data['update_time'] = date('Y-m-d H:i:s',time());
        if ($data['password']){
            $data['password'] = md5($data['password']);
        }
        $conferee_id = $data['conferee_id'];
        unset($data['password']);
        unset($data['conferee_id']);
        $res = DB::table('conferees')->where('conferee_id',$conferee_id)->update($data);
        if ($res){
            $this->returnJson($res);
        }else{
            $this->error(-1,'更新参会人失败');
        }
    }
    /**
     * 获取参会人详情
     * @param string $token (必填)
     * @param int $user_id (必填)
     * @return data 200成功
     */
    public function getUserConfereesInfo()
    {
        $data = $this->getPost($_POST);
        $res = DB::table('conferees')->where('conferee_id',$data['conferee_id'])->first();
        if ($res){
            $this->returnJson($res);
        }else{
            $this->error(-1,'查询参会人失败');
        }
    }
    /**
     * 删除参会人
     * @param string $token (必填)
     * @param int $user_id (必填)
     * @return data 200成功
     */
    public function deleteUserConferees()
    {
        $data = $this->getPost($_POST);
        $res = DB::table('conferees')->where('conferee_id',$data['conferee_id'])->update(array('status'=>-1));
        if ($res){
            $this->returnJson($res);
        }else{
            $this->error(-1,'删除参会人失败');
        }
    }
    /**
     * 获取参会人列表
     * @param string $token (必填)
     * @param int $page (必填,页数)
     * @param int $conference_id (必填,会议id)
     * @return data 200成功
     */
    public function getUserConfereesList()
    {
        $data = $this->getPost($_POST);
//        if ($data['page'] == 1){
//            $pageCountRecord = 0;
//        }else{
//            $pageCountRecord = ($data['page']-1) * 20;
//        }
        //$res = DB::table('conferees')->offset($pageCountRecord)->limit(20)->orderBy('update_time','desc')->get();
        $res = DB::table('conferees as a ')
            ->select(DB::RAW('a.*,b.seat_code'))
            ->leftjoin('seats as b','a.seat_id','=','b.seat_id')
            ->where('a.conference_id',$data['conference_id'])
            ->where('a.status',1)
            ->orderBy('a.update_time','desc')
            ->get();

        $count = DB::table('conferees')->where('conference_id',$data['conference_id'])->where('status',1)->orderBy('update_time','desc')->count();

        if ($res && $count){
//            foreach ($res as $key){
//                $key->authlist = DB::table('conference_authorities')
//                    ->where('conference_id',$data['conference_id'])
//                    ->where('conferee_id',$key->conferee_id)->get();
//            }
            $this->returnJson(array('list'=>$res,'count'=>$count));
        }else{
            $this->returnJson(array());
        }
    }
    /**
     * 获取参会人列表文件
     * @param string $token (必填)
     * @param int $conference_id (必填,会议id)
     * @param int $conferee_id (必填,参会人ID)
     * @return data 200成功
     */
    public function getUserConfereesListFile()
    {
        $data = $this->getPost($_POST);

        $res = DB::table('conference_attachments')->where('conference_id',$data['conference_id'])->where('status',1)->orderBy('update_time','desc')->get();

        if ($res){

            foreach ($res as $key){
                $check = DB::table('conference_authorities')->where('conference_id',$data['conference_id'])->where('conferee_id',$data['conferee_id'])->first();
                if ($check){
                    if ($check->download_file){
                        $key->download_file = $check->download_file;
                    }else{
                        $key->download_file = 0;
                    }
                    if ($check->upload_file){
                        $key->upload_file = $check->upload_file;
                    }else{
                        $key->upload_file = 0;
                    }
                }else{
                    $key->upload_file = 0;
                    $key->download_file = 0;
                }
            }

            $this->returnJson($res);
        }else{
            $this->returnJson(array());
        }



    }
}
