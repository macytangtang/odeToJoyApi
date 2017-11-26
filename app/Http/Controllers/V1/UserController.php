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
     * @param int $status (选填)
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
     * @param int $status (选填)
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
     * @param int $status (选填)
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
     * 更新用户
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
        if ($data['page'] == 1){
            $pageCountRecord = 0;
        }else{
            $pageCountRecord = ($data['page']-1) * 20;
        }
        $res = DB::table('users')->offset($pageCountRecord)->limit(20)->orderBy('update_time','desc')->get();

        $count = DB::table('users')->orderBy('update_time','desc')->count();

        if ($res && $count){
            $this->returnJson(array('list'=>$res,'count'=>$count));
        }else{
            $this->error(-1,'无用户数据');
        }
    }

    /**
     * 管理员登陆
     * @param string $name (必填)
     * @param string $password (必填)
     * @return data 200成功
     */
    public function login()
    {
        $data = $this->getPost($_POST);
        $data['password'] = md5($data['password']);
        
        $res = DB::table('administrators')->where('name',$data['name'])->where('password',$data['password'])->first();
        
        if ($res){
            $ret = DB::table('administrators')
                ->where('name',$data['name'])
                ->where('password',$data['password'])
                ->update(array('token'=>md5($data['password']+time()),'update_time'=>time()));
            $this->returnJson($ret);
        }else{
            $this->error(-1,'登陆失败');
        }
    }
}
