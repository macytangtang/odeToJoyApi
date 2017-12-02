<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Response;
use App\Model\Upload;
use Excel;

use Illuminate\Support\Facades\Input;

/**
 * 上传文件接口
 *
 * 所有上传文件接口相关操作放在本类
 * @package V1
 */
class UploadController extends Controller
{
    /**
     * 上传图片
     * @param string $token (必填)
     * @param string $file (必填)
     * @return data 200成功
     */
    public function imgUpload()
    {
        $file = Input::file('file');

        $token = Input::file("token");


        $allowed_extensions = ["png","jpg", "gif"];
        if ($file->getClientOriginalExtension() && !in_array($file->getClientOriginalExtension(), $allowed_extensions)) {
            $this->error(-1,"图片格式不对");
        }
        $size = $file->getClientSize();

        $path = Upload::checkDir();
        $Path = $path.'/images';
        if (!file_exists($Path)){
            mkdir($Path,0777);
        }
        $extension = $file->getClientOriginalExtension();
        $fileName = str_random(10).'.'.$extension;

        $file->move($Path, $fileName);

        $imageUrl = "http://".$_SERVER['HTTP_HOST'].'/uploads/images/'.$fileName;

        $this->returnJson($imageUrl);
    }
    /**
     * 上传excel
     * @param string $token (必填)
     * @param string $file (必填)
     * @return data 200成功
     */
    public function excelUpload()
    {
        $file = Input::file('file');
    }

}
