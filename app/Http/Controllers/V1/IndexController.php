<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

/**
 * 首页接口
 *
 * 所有首页相关操作放在本类
 * @package V1
 */
class IndexController extends Controller
{
    //
    /**
     * 首页
     * @param string $token (必填)
     * @return data 200成功
     */
    public function index(Request $requests)
    {
        $res = $requests->input('token');

        $res = DB::table('users')->first();
        $this->returnJson($res);

    }
}
