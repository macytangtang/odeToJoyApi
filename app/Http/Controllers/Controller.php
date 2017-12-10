<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    /**
     * 检测参数是否为空
     * @param $args
     * @return bool
     */
    protected function check_args($args)
    {
        foreach ($args as $arg) {
            if (empty($arg) && $arg !== 0 && $arg !== '0') {
                $this->error(-1, '参数不能为空'); //参数不能为空
            }
        }
    }

    /**
     * @param $token
     * @return array
     **/
    protected function token($token)
    {


    }






    protected function post($url, $params, $header = array())
    {
        $post_string = urldecode(json_encode($params,JSON_UNESCAPED_UNICODE));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_REFERER, 'HTTP://' . $_SERVER['HTTP_HOST']);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        $http_header = array_merge(array('Content-Type: application/json', 'Content-Length: ' . strlen($post_string)), $header);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $tmpInfo = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        return $tmpInfo;
    }

    protected function curl_get_new($url)
    {
        //初始化
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url);
        //设置秒级超时
        curl_setopt($curl, CURLOPT_TIMEOUT,60);
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 0);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //执行命令
        $data = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);
        //显示获得的数据
        return $data;
    }



    /**
     * 返回错误
     * @param $key
     */
    protected function error($key, $msg)
    {
        //header('Content-type: application/json');
        $ret = array('status' => $key, 'data' => $msg);
        echo json_encode($ret);
        exit();
    }

    //获取post参数
    protected function getPost($param = array())
    {
        $data = array();
        foreach ($param as $key=>$value) {
            if (isset($_POST[$key])) {
                $data[$key] = $_POST[$key];
            } else {
                $data[$key] = '';
            }
        }
        unset($data['token']);
        return $data;
    }

    protected function returnJson($data)
    {
        //header('Content-type: application/json');
        echo json_encode(array('status' => 200, 'data' => $data));
        exit();
    }

    protected function toArr($obj)
    {
        $data = json_decode(json_encode($obj), true);
        return $data;
    }

    //正则
    protected function parseBarcode($string)
    {
        $barcode = array();
        $pattern = array(
            '#\D+#', '#^\D+#', '#\D+$#',
        );
        $replacement = array(
            ',', '', ''
        );
        if ($string = preg_replace($pattern, $replacement, $string)) {
            $barcode = preg_split('#\D#', $string);
        }
        return $barcode;


    }
    // dff GuidContoller 移入方法
    /**
     * 生成32位长度guid
     */
    public function getGuid()
    {
        if (function_exists('com_create_guid')) {
            $uuid = com_create_guid();
        } else {
            mt_srand((double)microtime() * 10000);//optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);// "-"
            $uuid = chr(123)// "{"
                . substr($charid, 0, 8) . $hyphen
                . substr($charid, 8, 4) . $hyphen
                . substr($charid, 12, 4) . $hyphen
                . substr($charid, 16, 4) . $hyphen
                . substr($charid, 20, 12)
                . chr(125);// "}"
        }
        return str_replace(['{', '-', '}'], ['', '', ''], $uuid);
    }
}
