<?php
/**
 * Created by PhpStorm.
 * User: lingjianhua
 * Date: 2017/11/25
 * Time: 下午2:52
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class Token
{
    public function handle($request, Closure $next)
    {
        $token = $request->input('token');
        $this->checkToken($token);
        if($token == null){
            echo json_encode(array('status'=>0,'data'=>'token不能空'));
            exit();
        }
        //$request->session()->put('token',$token);
        return $next($request);
    }

    function checkToken($token)
    {
        $check_token = DB::table("users")->where("token",$token)->pluck("token");
        if ($check_token){
            return $check_token;
        }else{
            echo json_encode(array('status'=>0,'data'=>'token不正确'));
            exit();
        }

    }
}