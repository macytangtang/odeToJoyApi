<?php
require_once 'DocParser.php';

class DocFactory
{
    private static $p;
    private static $all_class_doc=array();
    private function DocFactory()
    {
    }

    public static function getInstance()
    {
        return new DocParser ();
    }
    //遍历目录
    public static function  listDir($dir)     
    {
       
        if (is_dir($dir)) {
           
            if ($dh = opendir($dir)) {
                while (($file = readdir($dh)) !== false) {
              
                    if ((is_dir($dir . "/" . $file)) && $file != "." && $file != ".."  && $file != ".svn" ) {
                         
                        self::listDir($dir . "/" . $file . "/");
                    } else {
                        if ($file != "." && $file != ".." && $file != ".svn" && $file != "Controller.php" && $file != "log.txt" && $file != "Phpdoc" && $file != ".DS_Store") {
                            self::get_doc($dir,$file);
                        }
                    }

                }
                closedir($dh);
            }
        }else{
            echo '目录错误';
        }
        $temp = array();
        foreach (self::$all_class_doc as $key=>$val){
            $temp[self::getNew($key)] = $val;
        }
        return array('all_class_doc'=>$temp);
    }
private static function getNew($key){
    $res = explode('Controller',$key);
    return $res[0];
}
//生成文档
private static function get_doc($dir,$file){

    require_once $dir."/".$file;
    $res = explode('Controllers',$dir);
    if ($res[1]=='//Doc/' || $res[1]=='//Auth/'){
        $path_doc = 'App\Http\Controllers\Doc\\';
        //此文件夹为生成doc
        return true;
    }else if($res[1]=='//V1/'){
        $path_doc = 'App\Http\Controllers\V1\\';
    }else{
        $path_doc = 'App\Http\Controllers\\';
    }
    $class_name=str_replace(".php","",$file);

    $class=new ReflectionClass($path_doc.$class_name);
    $true_name=$class->name;
    $class_doc=self::getInstance()->parse($class->getDocComment());
    self::$all_class_doc[$class_name]["class"]=$class_doc;
    //获取类中的方法，设置只获取public类型方法，其他+ ReflectionMethod::IS_PROTECTED + ReflectionMethod::IS_PRIVATE
    $methods = $class->getMethods(ReflectionMethod::IS_PUBLIC);

    foreach ($methods as $method) {
        //排除父类方法
        if ($true_name!=$method->class){
            return false;
        }

        //获取方法的注释
        $doc = $method->getDocComment();
        $name=$method->getName();
        $function_doc=self::getInstance()->parse($doc);
        self::$all_class_doc[$class_name]["function"][$name]=$function_doc;
    }

}

}