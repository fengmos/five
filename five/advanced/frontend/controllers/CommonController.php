<?php

namespace frontend\controllers;
use Yii;
use DB;
use yii\web\Controller;
class CommonController extends Controller
{
	#404时调用
	public $enableCsrfValidation = false;
	#禁用Yii框架的样式
	public $layout = false;

    public function beforeAction($action)
    {
        header("content-type:text/html;charset=utf-8");
       $session=\Yii::$app->session;  //开启session
       $admin_session = $session['admin_name'];   //获取管理员session名称
       if(!isset($admin_session)){     //检测该原理元session是否存在
			echo "<script>alert('请先登录');location.href='?r=login/login'</script>";die;
		}
//        $session = \Yii::$app->session;
//        $admin_id = $session->get('admin_id');
        $admin_id = $session['admin_id'];
        //echo $admin_id;die;
        $sql="select rp.power_id,p.power_name,p.controller,p.action,p.pid from study_role_power as rp LEFT JOIN study_power as p ON rp.power_id=p.power_id WHERE role_id in (select role_id from study_admin_role where admin_id =$admin_id) GROUP BY rp.power_id";
        $rows=\Yii::$app->db->createCommand($sql)->queryAll();
        if($rows){
            //echo 1111;die;
            for ($i=0;$i<count($rows);$i++){
                if($rows[$i]['pid']==0){
                    $one[]=$rows[$i];
                }else{
                    $two[]=$rows[$i];
                }
            }
            for($i=0;$i<count($one);$i++){
                for($j=0;$j<count($two);$j++){
                    //echo $two[$j]['power_name'];
                    if($two[$j]['pid']==$one[$i]['power_id']){
                        $one[$i]['children'][]=$two[$j];
                    }
                }
            }
            $powe=serialize($one);
            //print_r($one);die;
            $session->open();
            $session->set('power',$powe);
        }else{
            //echo 0;die;
            $this->message('?r=index/index',0,"抱歉,您没有权限",3);
        }
        //$arrs=$this->recursion($one);
        //获取当前访问的控制器
        $controller=\Yii::$app->controller->id;
//        $controllers=Yii::app ()->controller->id;
        //print_r($controller);
        //获取当前访问的方法
        $action=\Yii::$app->controller->action->id;
        //print_r($action);die;
        if($controller=='index' && $action=='index'){
            return true;
        }

        //$admin_id = $session->get('admin_id');
        $admin_id = $session['admin_id'];
        //print_r($admin_id);die;
        $sql="select rp.power_id,p.controller,p.action from study_role_power as rp LEFT JOIN study_power as p ON rp.power_id=p.power_id WHERE role_id in (select role_id from study_admin_role where admin_id =$admin_id) GROUP BY rp.power_id";
        $rows=\Yii::$app->db->createCommand($sql)->queryAll();
        $str=$controller.'/'.$action;
        if($rows){
            foreach($rows as $k => $v){
                $data[$k]=$v['controller'].'/'.$v['action'];
            }
            if(!in_array($str,$data)){
                $this->message('?r=index/index',0,"没有权限",3);die;
                //echo "没有权限";
            }else{
                return true;
            }
        }
    }
//    public function beforeAction($action)
//    {
//        header("content-type:text/html;charset=utf-8");
//        $session = \Yii::$app->session;
//        //取出存入的session值
//        $user_session = $session->get('admin_name');
//        //判断是否有登录session
//        if (!isset($user_session)) {
//            echo "<script>alert('请先登录');location.href='?r=login/login'</script>";
//            die;
//        }
//        $admin_id = $session->get('admin_id');
//        $sql="select rp.power_id,p.power_name,p.controller,p.action,p.pid from study_role_power as rp LEFT JOIN study_power as p ON rp.power_id=p.power_id WHERE role_id in (select role_id from study_admin_role where admin_id =$admin_id) GROUP BY rp.power_id";
//        $rows=\Yii::$app->db->createCommand($sql)->queryAll();
//        if($rows){
//            for ($i=0;$i<count($rows);$i++){
//                if($rows[$i]['pid']==0){
//                    $one[]=$rows[$i];
//                }else{
//                    $two[]=$rows[$i];
//                }
//            }
//            for($i=0;$i<count($one);$i++){
//                for($j=0;$j<count($two);$j++){
//                    //echo $two[$j]['power_name'];
//                    if($two[$j]['pid']==$one[$i]['power_id']){
//                        $one[$i]['children'][]=$two[$j];
//                    }
//                }
//            }
//            $powe=serialize($one);
//            $session->open();
//            $session->set('power',$powe);
//        }else{
//            $this->message('?r=index/index',0,"抱歉,您没有权限",$wait=3);
//        }
//        //$arrs=$this->recursion($one);
//        //获取当前访问的控制器
//        $controller=\Yii::$app->controller->id;
////        print_r($controller);die;
//        //获取当前访问的方法
//        $action=\Yii::$app->controller->action->id;
//        if($controller=='index' && $action=='index'){
//            return true;
//        }
//
//        $admin_id = $session->get('admin_id');
//        $sql="select rp.power_id,p.controller,p.action from study_role_power as rp LEFT JOIN study_power as p ON rp.power_id=p.power_id WHERE role_id in (select role_id from study_admin_role where admin_id =$admin_id) GROUP BY rp.power_id";
//        $rows=\Yii::$app->db->createCommand($sql)->queryAll();
//        $str=$controller.'/'.$action;
//        if($rows){
//            foreach($rows as $k => $v){
//                $data[$k]=$v['controller'].'/'.$v['action'];
//            }
//            if(!in_array($str,$data)){
//                $this->message('?r=index/index',0,"没有权限",$wait=3);die;
//            }else{
//                return true;
//            }
//        }
//
//    }
    public function recursion($data,$path=0,$flag=1){
        static $arr=array();
        foreach($data as $key=>$val){
            if($val['pid']==$path){
                $val['flag']=$flag;
                $arr[]=$val;
                $this->recursion($data,$val['power_id'],$flag+1);
            }
        }
        return $arr;
    }
    public function message($url,$status,$msg,$wait=3)
    {
        die($this->render('msg.html',['url'=>$url,'status'=>$status,'message'=>$msg,'wait'=>$wait]));
    }

}
