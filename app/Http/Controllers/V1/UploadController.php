<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
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

        $token = Input::get("token");


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
     * 上传坐席excel并导入
     * @param string $token (必填)
     * @param string $file (必填)
     * @param int $room_id (必填)
     * @return data 200成功
     */
    public function excelUpload()
    {
        $file = Input::file('file');
        $room_id = Input::get('room_id');
        $token = Input::get('token');

        $path = Upload::checkDir();
        $Path = $path.'/files';
        if (!file_exists($Path)){
            mkdir($Path,0777);
        }
        $extension = $file->getClientOriginalExtension();
        $file_name = $room_id."_"."seatExcel".time();
        $fileName = $file_name.'.'.$extension;

        $file->move($Path, $fileName);

        $list = $this->seatExcelDeal($path."/files/",$file_name,$room_id);

        $imageUrl = "http://".$_SERVER['HTTP_HOST'].'/uploads/files/'.$fileName;

        $this->returnJson(array('list'=>$list,'url'=>$imageUrl));
    }
    private function seatExcelDeal($path,$file_name,$room_id){
        $filePath = $path.$file_name.'.xlsx';
        $data = Excel::load($filePath, function($reader) {})->getSheet(0)->toArray();
        $insert_arr = array();
        foreach ($data as $k=>$key){
            if ($k > 0 && $key[0]!= null ){
                $insert_arr[] = array(
                    'seat_code'=>$key[0],
                    'seat_ip'=>$key[1],
                    'coordinate'=>$key[2],
                    'room_id'=>$room_id,
                    'create_time'=>date('Y-m-d H:i:s'),
                    'update_time'=>date('Y-m-d H:i:s'),
                );
            }
        }
        DB::table("seats")->insert($insert_arr);

        return DB::table("seats")->where('room_id',$room_id)->get();

    }
    /**
     * 上传文件
     * @param string $token (必填)
     * @param string $file (必填)
     * @return data 200成功
     */
    public function filesUpload()
    {
        $file = Input::file('file');
        $path = Upload::checkDir();
        $Path = $path.'/files';
        if (!file_exists($Path)){
            mkdir($Path,0777);
        }
        $extension = $file->getClientOriginalExtension();

        $fromFileName = $file->getClientOriginalName();

        $fromFileName = explode('.',$fromFileName);

        $file_name = $fromFileName[0]."_".time();
        $fileName = $file_name.'.'.$extension;

        $file->move($Path, $fileName);

        $imageUrl = "http://".$_SERVER['HTTP_HOST'].'/uploads/files/'.$fileName;

        $this->returnJson(array('url'=>$imageUrl,'filename'=>$fromFileName[0].'.'.$fromFileName[1]));
    }
    /**
     * 导出坐席excel模板
     * @param string $token (必填)
     * @return data 200成功
     */
    public function getExcelSeats()
    {
        $cellData = [
            ['坐席编号','IP地址','坐席坐标'],
            ['10001','192.168.1.11','(35,36)'],
            ['10002','192.168.1.12','(35,36)'],
            ['10003','192.168.1.13','(35,36)'],
            ['10004','192.168.1.14','(35,36)'],
            ['10005','192.168.1.15','(35,36)'],
        ];
        Excel::create('坐席列表模板',function($excel) use ($cellData){
            $excel->sheet('sheet', function($sheet) use ($cellData){
                $sheet->rows($cellData);
            });
        })->export('xlsx');
    }
    /**
     * 导出用户excel模板
     * @param string $token (必填)
     * @return data 200成功
     */
    public function getExcelUser()
    {
        $cellData = [
            ['姓名','性别(男填1,女2)','邮箱','电话','密码','备注','权限位(0或1)'],
            ['张一','1','123123@qq.com','13100021234','123456','测试','1']
        ];
        Excel::create('用户列表模板',function($excel) use ($cellData){
            $excel->sheet('sheet', function($sheet) use ($cellData){
                $sheet->rows($cellData);
            });
        })->export('xlsx');
    }
}
