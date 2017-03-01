<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\download;
use DB;

class DownlistController extends Controller
{
    //



    public function __construct(){

        $this->down = new download();

    }

    //加入下载列表
    public function addlist(Request $Request){
        $userid = $Request->input('userid');  //用户id
        $url = $Request->input('url');  //url
        $fid = $Request->input('fid');  //章节id


        $res = $this->down->ins($userid,$url,$fid);



        if($res){

            $msg = array('stat'=>'1','msg'=>"加入成功！");
            return json_encode($msg);
        }else{

            $msg = array('stat'=>'3','msg'=>"已加入，请勿重复加入");
            return json_encode($msg);
        }

        
    }

    //下载列表
    public function downlist(Request $Request){

        $userid = $Request->session()->get('userid');  //用户id



        if($userid!=''){

            $arr = DB::table('study_user')->where('user_id',$userid)->first();

            $data['arr'] = $arr;
            $data['is_display'] = '1';  //是否显示
            return view('market.downlist',$data);
        }else{

            echo "请先登录!";
        }





    }



}
