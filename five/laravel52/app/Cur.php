<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Session\Session;

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
    //查询单单一条
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
    /*
     * 李阳
     * 通过前台的ID 查询数据
     * 得到老师表里的ID，查询teacher表
     * 得到数据返回C层
     */
    public function  select($id){
        $users = DB::table('study_cur')->where('cur_id', '=', $id)->first();
        $teacher_id=$users['teacher_id'];
       return  DB::table('study_teacher')->where('teacher_id', '=', $teacher_id)->first();
    }
    /*
     * 李阳
     * 通过前台传来$ID 判断当前文章点击数
     * 首页获取登陆时存取的session判断用户有没有点过攒
     * 一个用户只能给一个教师点赞一次
     * 如果点过，则$num 不变给予返回
     * 如果没登陆先让用户进行登陆
     * 如果没点过，则$num +1  并给出返回值
     */
    public function  check($num,$teacher_id){
        $session=new Session();
        $id=$session->get('id');
        if(!empty($id))
        {
            $users = DB::table('study_back')
                ->where('user_id', '=', $id)
                ->where('teacher_id','=',$teacher_id)
                ->get();
            if($users)
            {

               return 0;
            }
            else
            {

                DB::table('study_back')->insert([
                    'user_id' =>$id,
                    'teacher_id' =>$teacher_id
                ]);

                $count=$num+1;
                DB::table('study_teacher')
                    ->where('teacher_id', $teacher_id)
                    ->update(['teacher_num' => $count]);

                return $count;
            }
        }
        else
        {
            return 2;
        }
    }
}
