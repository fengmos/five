<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use DB;
use App\User;
use App\Cur;
class ThiseeController extends Controller
{

    public function thisee(){
        //现在时间
        $time=time()+8*60*60;

        //$data=DB::table('study_seeding')->join('study_teacher', 'study_teacher.teacher_id','=','study_seeding.teacher_id')->where('study_seeding.begintime','>',$time)->get();//正在播
        $data=DB::table('study_seeding')->join('study_teacher', 'study_teacher.teacher_id','=','study_seeding.teacher_id')->get();//正在播
        //print_r($data);die;
//        $cur=new Cur();
//        $data=$cur->moBod();
        //print_r($data);die;
        return view('thisee.thisee',['data'=>$data]);
    }
    public function mogbo(){
        //echo date("Y-m-d H:i:s",'1487766823');die;
        $time=time()+8*60*60;
        $data=DB::table('study_seeding')->join('study_teacher', 'study_teacher.teacher_id','=','study_seeding.teacher_id')->where('study_seeding.begintime','<',$time)->get();//没开波
//        print_r($data);die;
//        $cur=new Cur();
//        $data=$cur->moBod();
        return view('thisee.modo',['data'=>$data]);
    }
    ////直播
    public function begbo(){
        $id=Input::get('id');
        $data=DB::table('study_seeding')->join('study_teacher', 'study_teacher.teacher_id','=','study_seeding.teacher_id')->where('id',$id)->first();
//        print_r($data);
//        echo time();
//        die;
        return view('thisee.yibo',['data'=>$data]);
    }


}



 


