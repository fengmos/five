<?php

namespace frontend\controllers;
use Yii;
use frontend\models\StudyAdmin;
use common\code\ValidateCode;
class LoginController extends \yii\web\Controller
{
	#404时调用
	public $enableCsrfValidation = false;
	#禁用Yii框架的样式
	public $layout = false;

	//登录界面
    public function actionLogin()
    {
        return $this->render('login');
    }
    //检测管理员登录
    public function actionCheck()
    {
      $session = Yii::$app->session;   //开启session
    	$request=Yii::$app->request;    //调用request类
    	if($request->isPost)
    	{
            $post=$request->post();    //接受数据
            $code = $session['code'];     //验证码
            $name = $post['name'];         //用户名
            $pwd = $post['password'];     //密码
            $nowCode = $post['code'];    //获取验证码
            // $pwd = md5($post['password']);
           // $pwd = Yii::$app->security->generatePasswordHash($post['password']);
            if($code!=$nowCode)    //判断验证码
            {
                 echo "<script>alert('验证码错误');location.href='?r=login/login'</script>";
            }else
            {
                $res = StudyAdmin::checkAdmin($name,$pwd); //调用管理员model
                if($res!='no')
                {
                  $time= date('Y-m-d H:i:s',time());     //当前时间
                  $time = strtotime($time);          //转化为时间戳
                  $ip = $_SERVER['REMOTE_ADDR'];     //获取登陆者IP地址
                  $db = \Yii::$app->db->createCommand();      //开启DB类
                  $reg = $db->update('study_admin' , ['admin_time'=>$time,'admin_ip'=>$ip], ['admin_id'=>$res['admin_id']])->execute();//执行管理员登录修改信息
                   if($reg)     //0为管理员登录
                   {
                       $session['admin_name'] = $name;
                       $session['admin_id'] = $res['status'];
                       echo "<script>alert('登录成功');location.href='?r=index/index'</script>";
                   }else
                   {
                    echo "<script>alert('服务器错误');location.href='?r=login/login'</script>";
                   }
                      
                 // $result = StudyAdmin::saveInfo($name,$time,$ip);
                }else
                {
                    echo "<script>alert('账号或用户名错误');location.href='?r=login/login'</script>";
                }

            }
           
    	}else
    	{
    		return $this->render('login');
    	}
    	
    }
    /**
     * 验证码
     * 调用第三方类生产验证码，并将生成的验证码存储到session中国
     */
    public function actionCode()
    {
      //session_start();
      $session = Yii::$app->session;    //开启session
    	$code = new ValidateCode();       //实例化验证码类
    	$code->doimg();        //获取验证码图片
    	$session['code'] = $code->getCode();    //将生成的验证码存储到session中
    }
    /**
     * 管理员退出登录
     */
    public function actionLogin_out()
    {
       $session=Yii::$app->session;         //  开启session
        if($session->remove('admin_name'))      // 移除session
        {
           echo "<script>alert('退出成功');location.href='?r=login/login'</script>";
        }
    }
}
