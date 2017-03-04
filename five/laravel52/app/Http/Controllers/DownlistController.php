<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\download;
use DB;

class DownlistController extends Controller
{
    //


    private $_speed = 512;   // 下载速度

    public function __construct()
    {

        $this->down = new download();

    }

    //加入下载列表
    public function addlist(Request $Request)
    {
        $userid = $Request->input('userid');  //用户id
        $url = $Request->input('url');  //url
        $fid = $Request->input('fid');  //章节id


        $res = $this->down->ins($userid, $url, $fid);


        if ($res) {

            $msg = array('stat' => '1', 'msg' => "加入成功！");
            return json_encode($msg);
        } else {

            $msg = array('stat' => '3', 'msg' => "已加入，请勿重复加入");
            return json_encode($msg);
        }


    }

    //下载列表
    public function downlist(Request $Request)
    {

        $userid = $Request->session()->get('userid');  //用户id




        if ($userid != '') {

            $arr = DB::table('study_user')->where('user_id', $userid)->first();

            $list = DB::select("select * from study_down INNER JOIN study_chapter on study_down.fid = study_chapter.id where user_id = '$userid'");


            $data['arr'] = $arr;
            $data['is_display'] = '1';  //是否显示
            $data['list'] = $list;
            return view('market.downlist', $data);
        } else {

            return redirect('login');
        }


    }

    //下载功能
    public function downloads(Request $Request)
    {

        $url = $Request->input('url');
        $name = $Request->input('name');  //视频名

        $address =  $url;



        $pathinfo = pathinfo($address);  //获取文件信息



        $houzhuis = ($pathinfo['extension']);  //文件后缀


        $linuxurl = '/data/wwwroot/admin.duzejun.cn/advanced/frontend/web/uploads/';
        $bendi = "D:/phpStudy/WWW/t2/";


        $filename = "$linuxurl".$pathinfo['basename'];  //文件名


        ###开始下载######

        $name = $name.".$houzhuis";

        $flag = $this->download($filename, $name);

        if(!$flag){

            echo 'file not exists';

        }


        ###end下载#######


    }




    //-------upload---------








    /** 下载

     * @param String  $file   要下载的文件路径

     * @param String  $name   文件名称,为空则与下载的文件名称一样

     * @param boolean $reload 是否开启断点续传

     */

    public function download($file, $name='', $reload=false){

        if(file_exists($file)){

            if($name==''){

                $name = basename($file);

            }



            $fp = fopen($file, 'rb');

            $file_size = filesize($file);

            $ranges = $this->getRange($file_size);



            header('cache-control:public');

            header('content-type:application/octet-stream');

            header('content-disposition:attachment; filename='.$name);



            if($reload && $ranges!=null){ // 使用续传

                header('HTTP/1.1 206 Partial Content');

                header('Accept-Ranges:bytes');



                // 剩余长度

                header(sprintf('content-length:%u',$ranges['end']-$ranges['start']));



                // range信息

                header(sprintf('content-range:bytes %s-%s/%s', $ranges['start'], $ranges['end'], $file_size));



                // fp指针跳到断点位置

                fseek($fp, sprintf('%u', $ranges['start']));

            }else{

                header('HTTP/1.1 200 OK');

                header('content-length:'.$file_size);

            }



            while(!feof($fp)){

                echo fread($fp, round($this->_speed*1024,0));

                ob_flush();

                //sleep(1); // 用于测试,减慢下载速度

            }



            ($fp!=null) && fclose($fp);



        }else{

            return '';

        }

    }





    /** 设置下载速度

     * @param int $speed

     */

    public function setSpeed($speed){

        if(is_numeric($speed) && $speed>16 && $speed<4096){

            $this->_speed = $speed;

        }

    }





    /** 获取header range信息

     * @param  int   $file_size 文件大小

     * @return Array

     */

    private function getRange($file_size){

        if(isset($_SERVER['HTTP_RANGE']) && !empty($_SERVER['HTTP_RANGE'])){

            $range = $_SERVER['HTTP_RANGE'];

            $range = preg_replace('/[\s|,].*/', '', $range);

            $range = explode('-', substr($range, 6));

            if(count($range)<2){

                $range[1] = $file_size;

            }

            $range = array_combine(array('start','end'), $range);

            if(empty($range['start'])){

                $range['start'] = 0;

            }

            if(empty($range['end'])){

                $range['end'] = $file_size;

            }

            return $range;

        }

        return null;

    }



    //------------endupload--------------










}
