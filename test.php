<?php
/**
 * Created by PhpStorm.
 * User: lingjianhua
 * Date: 17/3/9
 * Time: 上午9:34
 */
$time = time();
$mall_host = $_SERVER['SERVER_NAME'];
if($mall_host == "t-mbox.bingofresh.com" || $mall_host == "mbox.bingofresh.com" || $mall_host=="t-box.bingofresh.com"){
    $file_host = "Framework7/dist/";
}else{
    $file_host = "MyTest/mbox/app/Framework7/dist/";
}
echo 11;
if (isset($_GET["go"]) && !empty($_GET["go"])){
    $go = $_GET["go"];
    switch ($go) {
        case 'boss':
            $url = boss($mall_host,$file_host,$time);
            break;
        case 'tallyclerk':
            $url="http://".$mall_host."/{$file_host}/tallyclerk.html?v=".$time;
            break;
        default:
            $url="http://".$mall_host."/{$file_host}/index.html?v=".$time;
    }
    header('Location:'.$url);
}
function boss($mall_host,$file_host,$time){

    $user_list = curl_get("http://box.bingofresh.com/api.php?s=/Sales/getUser");
    $user_list = json_decode($user_list,true);
    if ($user_list['code']==200){
        $openid_group = array();
        $list = $user_list['data'];
        foreach ($list as $key=>$val){
            $openid_group[$key] = $val['openid'];
        }
    }else{
        $openid_group = array();
    }
    if (isset($_GET["code"]) && !empty($_GET["code"])){
        $code = $_GET['code'];

        $json = file_get_contents('https://api.weixin.qq.com/sns/oauth2/access_token?appid=&secret=&code='.$code.'&grant_type=authorization_code');

        $return_data = json_decode($json,true);

        if(!in_array($return_data['openid'],$openid_group)){
            echo "<center>未授权无法进入</center>";
            exit();
        }
        $url="http://mbox.bingofresh.com/Framework7/dist/index.html?v=".$time;
        //$url="http://".$mall_host."/{$file_host}/index.html?v=".$time;
        header('Location:'.$url);
    }
    exit();
}
//    //get方法
    function curl_get($url){
        //初始化
        $ch = curl_init();
        //设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        //执行并获取HTML文档内容
        $output = curl_exec($ch);
        //释放curl句柄
        curl_close($ch);
        return $output;
    }