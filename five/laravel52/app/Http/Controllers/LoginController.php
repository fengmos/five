<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Session\Session;
class LoginController extends Controller{

/**
 * 登陆
 * @return [type] [description]
 */
    public function login(){
        $session = new Session;
        $code = $session->get('nickname');
        if(!empty($code)){
            return redirect('/');
            die;
        }
        return view('login.login');
    }
    /**
     * 验证唯一性
     */
    public function Only()
    {
        $tel = Input::get('tel');
        $user = DB::table('study_user')->where('user_tel', '=',$tel)->get();
        if($user){
            return 1;
        }else{
            return 0;
        }
    }
    /**
     * 登录
     */
    public function Checklogin()
    {   //echo Crypt::encrypt('k123456');die;
        $tel = Input::get('tel');
        $pwd = Input::get('pwd');
        $token = Input::get('_token');
        if(empty($tel) || empty($pwd)){
            return back()->with('errors','不能为空！');
        }
        $arr = DB::table('study_user')->where('user_tel',$tel)->first();
        if($arr){
            if($pwd !=Crypt::decrypt($arr['user_pwd'])){
                return back()->with('errors','密码错误!');
            }else{
                $session = new Session;
                $session->set('nickname',$arr['nickname']);
                $session->set('id',$arr['user_id']);
                return redirect('/');
            }
        }else{
            return back()->with('errors','账号不存在!');
        }

    }
    /**
     * 获取ip
     */
    function getIP()
    {
        $ip=getenv('REMOTE_ADDR');
        $ip_ = getenv('HTTP_X_FORWARDED_FOR');
        if (($ip_ != "") && ($ip_ != "unknown"))
        {
            $ip=$ip_;
        }
        return $ip;
    }
    /**
     * 微博登录
     */
    public function Weibo()
    {
        date_default_timezone_set('PRC');
        $code = @$_GET['code'];
        $url = "https://api.weibo.com/oauth2/access_token";
        $data = "client_id=61581137&client_secret=094717fc7b87c55520c31758b846ed19&grant_type=authorization_code&code=$code&redirect_uri=http://home.duzejun.cn/weibo";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // post数据
        curl_setopt($ch, CURLOPT_POST, 1);
        // post的变量
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $output = curl_exec($ch);
        curl_close($ch);
        //打印获得的数据
        //{"access_token":"2.00xiNHcG0r96lyfa9799e6f50YiDlF","remind_in":"157679999","expires_in":157679999,"uid":"6060018815"}
        $tokens = json_decode($output,true);
        //请求查询用户access_token的授权相关信息
        $token = $tokens['access_token'];
        $url = "https://api.weibo.com/oauth2/get_token_info";
        $arr = "access_token=".$token;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // post数据
        curl_setopt($ch, CURLOPT_POST, 1);
        // post的变量
        curl_setopt($ch, CURLOPT_POSTFIELDS, $arr);
        $result = curl_exec($ch);
        curl_close($ch);
        $user = json_decode($result,true);
        $uid = $user['uid'];
        $info = file_get_contents("https://api.weibo.com/2/users/show.json?access_token=$token&uid=$uid");
        $userinfo = json_decode($info,true);
        //先查询用户是否存在本网站中
        $res = DB::table('study_user')->where('open_id','=',$userinfo['id'])->first();
        if($res){
            //有的话直接登陆  存session
            $session = new Session;
            $session->set('nickname',$userinfo['name']);
            $session->set('id',$res['user_id']);
            return redirect('/');
        }else{
            //没有的话相当于注册  一个
            $addtime = date("Y-m-d H:i:s");
            $user=array(
                'open_id'=>$userinfo['id'],
                'login_method'=>2,
                'img'=>$userinfo['profile_image_url'],
                'addtime'=>$addtime,
                'nickname'=>$userinfo['name'],
            );
            $re = DB::table('study_user')->insert($user);
            if($re){
                $session = new Session;
                $session->set('nickname',$userinfo['name']);
                $user_id = DB::table('study_user')->where('nickname',$userinfo['name'])->first();
                $session->set('id',$user_id['user_id']);
                return redirect('/');
            }else{
                return redirect('login');
            }
        }
    }
    /**
     * qq登录
     */
    public function Qqlogin()
    {
        date_default_timezone_set('PRC');
        $token = Input::get('token');
        $open_id = file_get_contents('https://graph.qq.com/oauth2.0/me?access_token='.$token);
        $pre = '#callback\((.*)\)#isU';
        preg_match($pre,$open_id,$user);
        $open_id = json_decode($user[1],true);
        $userinfo = file_get_contents("https://graph.qq.com/user/get_user_info?access_token=$token&oauth_consumer_key=101371415&openid=".$open_id['openid']);
        $users = json_decode($userinfo,true);
        //查一下此用户是否在本网战使用qq登陆过
        $res = DB::table('study_user')->where('open_id','=',$open_id['openid'])->first();
        if($res){
            //如果有直接存session  进首页
            $session = new Session;
            $session->set('nickname',$users['nickname']);
            $session->set('id',$res['user_id']);
            return redirect('/');
        }else{
            //没有的话相当于注册  一个
            $addtime = date("Y-m-d H:i:s");
            $user=array(
                'open_id'=>$open_id['openid'],
                'login_method'=>1,
                'img'=>$users['figureurl_2'],
                'addtime'=>$addtime,
                'nickname'=>$users['nickname'],
            );
            $re = DB::table('study_user')->insert($user);
            if($re){
                $user_id = DB::table('study_user')->where('nickname',$users['nickname'])->first();
                $session = new Session;
                $session->set('nickname',$users['nickname']);
                $session->set('id',$user_id['user_id']);
                return redirect('/');
            }else{
                return redirect('login');
            }
        }
    }
    /**
     * f发送短信验证
     */
    public function Short()
    {
        $tel = Input::get('tel');
        $number = rand(1000,9999);
        $session = new Session;
        $session->set('short',$number);
        $param = "code%3D".$number;
        $nowapi_parm['app']='sms.send';
        $nowapi_parm['param']=$param;
        $nowapi_parm['tempid']=50895;
        $nowapi_parm['phone']=$tel;
        $nowapi_parm['appkey']=20892;
        $nowapi_parm['sign']='28feb41149334bcdb2d02918f618d98d';
        $nowapi_parm['format']='json';
        $result=$this->nowapi_call($nowapi_parm);
        if($result['status'] == 'OK'){
            return 1;
        }
    }
    /**
     * 验证码对比
     */
    public function Contrast(Request $request)
    {
        $user_code = Input::get('code');
        $session = new Session;
        $code = $session->get('short');
        if($user_code == $code) {
            return 1;
        }else{
            return 0;
        }
    }
    /**
     * 注册入库
     */
    public function Add()
    {
        $request = Input::get();
        $pwd = Crypt::encrypt($request['pwd']);
        $tel = $request['tel'];
        $addtime = date("Y-m-d H:i:s");
        $name = 'duoxue'.time();
        $user=array(
            'user_tel'=>"$tel",
            'user_pwd'=>"$pwd",
            'addtime'=>"$addtime",
            'nickname'=>$name,
            'login_method' =>0,
            'img'=>'./style/img/1a.png'
        );
        $re = DB::table('study_user')->insert($user);
        if($re){
            $session = new Session();
            $session->set('nickname',$name);
            $user_id = DB::table('study_user')->where('nickname',$name)->first();
            $session->set('id',$user_id['user_id']);
            return redirect('/');
        }else{
            return redirect('regist');
        }
    }
    /**
     * 短信
     */
    function nowapi_call($a_parm){
        if(!is_array($a_parm)){
            return false;
        }
        //combinations
        $a_parm['format']=empty($a_parm['format'])?'json':$a_parm['format'];
        $apiurl=empty($a_parm['apiurl'])?'http://api.k780.com:88/?':$a_parm['apiurl'].'/?';
        unset($a_parm['apiurl']);
        foreach($a_parm as $k=>$v){
            $apiurl.=$k.'='.$v.'&';
        }
        $apiurl=substr($apiurl,0,-1);
        if(!$callapi=file_get_contents($apiurl)){
            return false;
        }
        //format
        if($a_parm['format']=='base64'){
            $a_cdata=unserialize(base64_decode($callapi));
        }elseif($a_parm['format']=='json'){
            if(!$a_cdata=json_decode($callapi,true)){
                return false;
            }
        }else{
            return false;
        }
        //array
        if($a_cdata['success']!='1'){
            echo $a_cdata['msgid'].' '.$a_cdata['msg'];
            return false;
        }
        return $a_cdata['result'];
    }
/**
 *
 *注册
 * 
 */

   public function regist(){

     return view('login.regist');
   }


  /**
   *    
   * 退出登录
   */
     public function login_out(){

         $session = new Session();
         $session->set('nickname','');
         return redirect('login');
    }

  }

  ?>
