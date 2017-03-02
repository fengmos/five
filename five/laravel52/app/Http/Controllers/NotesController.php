<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use DB;
use App\User;
use App\Cur;
use App\Cart;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Session\Session;
class NotesController extends Controller
{
    //查询所有笔记，查询最新以及推荐
    public function index(){
        $id=Input::get('sh','');
        $types = DB::table('study_type')->where('type_is_show',1)->where('parent_id','=',0)->get();
        //print_r($types);die;
        foreach($types as $key=>$val){
            $types[$key]['pp']=DB::table('study_type')->where('type_is_show',1)->where('parent_id','=',$val['type_id'])->get();
            foreach($types[$key]['pp'] as $k=>$v){
                $types[$key]['pp'][$k]['pp']=DB::table('study_type')->where('type_is_show',1)->where('parent_id','=',$v['type_id'])->get();
                //print_r($v['type_id']);
            }
            //print_r($types[$key]['pp']);
        }
//        print_r($types);
//        print_r($info);
//        die;
        $cur = new Cur();
        if($id==1){
            //最新的
            $data=DB::select("SELECT * from study_notes INNER JOIN study_teacher on study_notes.teacher_id=study_teacher.teacher_id INNER JOIN study_type on study_notes.type_id=study_type.type_id ORDER BY notes_time DESC ");
        }else if($id==2){
            //最热的
            $data=DB::select("SELECT * from study_notes INNER JOIN study_teacher on study_notes.teacher_id=study_teacher.teacher_id INNER JOIN study_type on study_notes.type_id=study_type.type_id where notes_hot=1");
        }else{
            $data = DB::select("SELECT * from study_notes INNER JOIN study_teacher on study_notes.teacher_id=study_teacher.teacher_id INNER JOIN study_type on study_notes.type_id=study_type.type_id");
        }
        return view('notes.notes_index',['types'=>$types,'data'=>$data]);
    }
    //点击进入详情页
    public function notes_ur(){
        $notes_id=Input::get('notes_id');
        $data=DB::select("SELECT * from study_notes INNER JOIN study_teacher on study_notes.teacher_id=study_teacher.teacher_id INNER JOIN study_type on study_notes.type_id=study_type.type_id where notes_id='$notes_id'");
        return view('notes.notes_article',['curone'=>$data[0]]);
    }
    //展示其分类下的笔记
    public function notes_urs(){
        $type_id=Input::get('id');
        $types = DB::table('study_type')->where('type_is_show',1)->where('parent_id','=',0)->get();
        //print_r($types);die;
        foreach($types as $key=>$val){
            $types[$key]['pp']=DB::table('study_type')->where('type_is_show',1)->where('parent_id','=',$val['type_id'])->get();
            foreach($types[$key]['pp'] as $k=>$v){
                $types[$key]['pp'][$k]['pp']=DB::table('study_type')->where('type_is_show',1)->where('parent_id','=',$v['type_id'])->get();
                //print_r($v['type_id']);
            }
            //print_r($types[$key]['pp']);
        }
        $data=DB::select("SELECT * from study_notes INNER JOIN study_teacher on study_notes.teacher_id=study_teacher.teacher_id INNER JOIN study_type on study_notes.type_id=study_type.type_id where study_notes.type_id='$type_id'");
        return view('notes.notes_index',['types'=>$types,'data'=>$data]);
    }

}