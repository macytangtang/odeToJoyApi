<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


/**
 * 用户接口
 *
 * 所有用户相关操作放在本类
 * @package V1
 */
class UserController extends Controller
{
    //
    /**
     * 创建用户
     * @param string $token (必填)
     * @param string $name (必填)
     * @param string $password (必填)
     * @param string $description (选填)
     * @param int $status (选填)
     * @return data 200成功
     */
    public function createUser(Request $requests)
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
}
