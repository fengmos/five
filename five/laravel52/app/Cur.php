<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Cur extends Model
{
    //
    protected $table='study_cur';
    protected $primaryKey='cur_id';
    public $timestamps=false;
    protected $guarded=[];

    public function searchCurType($id){
        return DB::table($this->table)->where('typeid',$id)->join('study_teacher', 'study_cur.teacher_id', '=','study_teacher.teacher_id')->select('study_cur.cur_id','study_cur.cur_name','study_cur.cur_img','study_cur.cur_price','study_teacher.teacher_id','study_teacher.teacher_name')->get();//->orderBy('cur_id','desc')->paginate(1);
    }
    //查询一条+讲师
    public function searchCurone($id){
        return DB::table($this->table)->where('cur_id',$id)->join('study_teacher', 'study_cur.teacher_id', '=','study_teacher.teacher_id')->first();
    }
    //查询丹丹一条
    public function curOne($id){
        $cur=DB::table($this->table)->where('cur_id',$id)->select('cur_id','cur_name')->first();
        //print_r($cur);die;
        $cur['pp']=DB::table("study_details")->where('cur_id',$cur['cur_id'])->select('id','chapter')->get();
        foreach($cur['pp'] as $k=>$v){
            $cur['pp'][$k]['pp']=DB::table("study_chapter")->where('det_id',$v['id'])->select('id','file_name')->get();
        }
      // print_r($cur);die;
        return $cur;
    }
    /////////
    public function moBod(){
        $data=DB::table('study_seeding')->join('study_teacher', 'study_teacher.teacher_id', '=', 'study_seeding.teacher_id')->get();
        foreach($data as $key=>$val){
            $data[$key]['begintime']=strtotime($val['begintime']);
            $data[$key]['endtime']=strtotime($val['endtime']);
        }
        return $data;
    }
    //查询所有
    public function searchCurAll(){
        return DB::table($this->table)->join('study_teacher', 'study_cur.teacher_id', '=','study_teacher.teacher_id')->select('study_cur.cur_id','study_cur.cur_name','study_cur.cur_img','study_cur.cur_price','study_teacher.teacher_id','study_teacher.teacher_name')->orderBy('cur_id','desc')->skip(0)->take(10)->get();
    }
    //查询所有
    public function searchCurAlls(){
        return DB::table($this->table)->join('study_teacher', 'study_cur.teacher_id', '=','study_teacher.teacher_id')->select('study_cur.cur_id','study_cur.cur_name','study_cur.cur_img','study_cur.cur_price','study_teacher.teacher_id','study_teacher.teacher_name')->orderBy('cur_id','desc')->skip(0)->take(4)->get();
    }
    //查询最新 &&最热
    public function searchCurNew($newhot="study_cur.cur_is_new"){
        return DB::table($this->table)->where($newhot,1)->join('study_teacher', 'study_cur.teacher_id', '=','study_teacher.teacher_id')->select('study_cur.cur_id','study_cur.cur_name','study_cur.cur_img','study_cur.cur_price','study_teacher.teacher_id','study_teacher.teacher_name')->get();
    }
    public function searchCurNum($num,$nums){
        return DB::table($this->table)->join('study_teacher', 'study_cur.teacher_id', '=','study_teacher.teacher_id')->select('study_cur.cur_id','study_cur.cur_name','study_cur.cur_img','study_cur.cur_price','study_teacher.teacher_id','study_teacher.teacher_name')->orderBy('cur_id','desc')->skip($num)->take($nums)->get();
    }
}
