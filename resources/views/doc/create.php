<?php
header("Content-type: text/html; charset=utf-8");
//ini_set("display_errors",1);
//error_reporting(E_ALL);
//require_once "../class/Common.php";
require_once  __DIR__."/../../../app/Http/Controllers/Controller.php";
require_once 'DocFactory.php';

/**
 * Created by PhpStorm.
 * User: wang
 * Date: 14-10-14
 * Time: 上午10:42
 */
//开始运行
$doc=DocFactory::listDir( __DIR__."/../../../app/Http/Controllers/");
//转换成jsong字符串
$json=json_encode($doc);
//写到文件
$fp=fopen("doc.data",'w');
fwrite($fp,$json);
fclose($fp);
echo 'OK';