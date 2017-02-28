<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use DB;
use App\User;

class WelcomeController extends Controller{

/**
 * 首页 轮播图
 * @return [type] [description]
 */
    public function welcome(){
         //轮播
         $rel=DB::table('study_adv')->get();
        
         //精选
         $res=DB::table('study_cur')->where('cur_is_heat','=',1)->where('cur_is_new','=',1)
         ->distinct()->take(3)->orderBy('cur_is_new', 'desc')->get();
        //print_r($res);die;
         //付费
         $str=DB::table('study_cur')->orwhere('cur_price','>=',1)->orderBy('cur_id','desc')->distinct()->take(3)->get();
        //print_r($he);die;
        //免费       
         $re=DB::table('study_cur')->where('cur_price','=',0)->orderBy('cur_id', 'desc')
               ->distinct()->take(3)->get();
         //print_r($heat);die;
          return view('welcome.welcome',['rel'=>$rel,'res'=>$res,'str'=>$str,'re'=>$re]);
    
    }



   
/** 
 *
 * 精选课程
 */
 public function course(){

    $res=DB::table('study_cur')->where('cur_is_heat',1)->where('cur_is_new','=',1)->orderBy('cur_is_new', 'desc')->take(5)->get();

   //print_r($res);die;
    return view('welcome.course',['res'=>$res]);
 }
 

/** 
 *
 * 免费课程
 */
    
 public function selected(){

    $re=DB::table('study_cur')->where('cur_price','=',0)->orderBy('cur_id', 'desc')->take(5)->get();
  // print_r($re);die; 
 	return view('welcome.selected',['re'=>$re]);
 }
   
   /**
    *
    * 付费课程
    */
public function recommend(){
     $heat=DB::table('study_cur')->where('cur_price','>=',1)->orderBy('cur_id', 'desc')->take(5)->get();
	 return view('welcome.recommend',['heat'=>$heat]);
}



/**
 *
 * 更多
 */
public function morer(){
    $more=DB::table('study_cur')->orderBy('cur_price', 'desc')->take(5)->get();
	return view('welcome.morer',['more'=>$more]);	
}
/**
 * 定位城市
 * @return [type] [description]
 */
    public function get_city()
    {
        //echo 1;die;
         $ip = $_SERVER['REMOTE_ADDR'];
        //$ip ='8.8.8.8';
        $data = file_get_contents("http://api.k780.com:88/?app=ip.get&ip=".$ip."&appkey=20892&sign=28feb41149334bcdb2d02918f618d98d&format=json");
        return $data;
    }


    /**
     * 首页搜索
     * 
     */
        public function search(){
           // echo"1";die;

            $search=$_GET['search'];


        
            //$users = DB::table('study_cur')->->get();

             $sql=DB::select("select * from study_cur where cur_name like '%$search%'");
            // print_r($sql);die;
        //print_r($sql);die;
    
        exit(json_encode($sql));
            
        }

//         /**
//          *
//          * 搜索详情
//          */

// public function details(){

//     $id=$_GET['id'];
//    // echo $id;die;
   
// }







}




