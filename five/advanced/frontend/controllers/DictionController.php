<?php

namespace frontend\controllers;
use Yii;
use yii\db\Query;
use yii\web\Controller;
use frontend\models\UploadForm;
use common\libraries\Uploadfile;
use yii\web\UploadedFile;
use frontend\models\Type;
class DictionController extends CommonController
{
	#404时调用
	public $enableCsrfValidation = false;
	#禁用Yii框架的样式
	public $layout = false;
    //管理员列表
    public function actionAdministrators(){
        $db = new \yii\db\Query();
        $res=$db->select('admin_id,admin_name,admin_tel,admin_time,admin_ip,admin_img')->from('study_admin')->all();
        if($res){
            return $this->render('administrators',['data'=>$res]);
        }else{
            $this->message('?r=index/index',0,"显示失败",$wait=3);
        }
    }
    //添加管理员
    public function actionAddadmin(){
        $request=Yii::$app->request;
        if($request->isPost) {
            $arr=\Yii::$app->request->post();
            //print_r($arr);die;
            $uploads=new Uploadfile();
            $type = array('image/gif', 'image/jpeg', 'image/png', 'image/pjpeg', 'image/x-png');
            $uploads->Uploadfile($_FILES['admin_img'], './upload/admin',1221024000,$type);
            $num = $uploads->upload();
            if($num!=0) {
                $b_cover = $uploads->getSaveInfo();
                $admin_img=$b_cover[0]['newpath'];
                $pwd = Yii::$app->security->generatePasswordHash($arr['admin_pwd']);
                $res=Yii::$app->db->createCommand()->insert('study_admin',[
                    'admin_name' =>$arr['admin_name'],
                    'admin_pwd' =>$pwd,
                    'admin_tel' =>$arr['admin_tel'],
                    'admin_img' =>$admin_img,
                    'admin_time'=>time(),
                    'admin_status'=>1,
                ])->execute();
                if($res){
                    //$data=Array ( [role_id] => Array ( [0] => 1 [1] => 2 [2] => 3 ) )
                    $last_id=Yii::$app->db->getLastInsertId();
                    foreach ($arr['role'] as $k=>$v){
                        $re=Yii::$app->db->createCommand()->insert('study_admin_role',[
                            'admin_id' =>$last_id,
                            'role_id' =>$v,
                        ])->execute();
                    }
                    if($re){
                        return $this->redirect("?r=diction/administrators");
                    }else{
                        $this->message('?r=diction/addadmin',0,"角色添加失败",$wait=3);
                    }
                }else{
                    $this->message('?r=diction/addadmin',0,"添加信息失败",$wait=3);
                }
            }else{
                $this->message('?r=diction/addadmin',0,"添加修改失败",$wait=3);
            }
        }else{
            $arr=\Yii::$app->db->createCommand("select * from study_role")->queryAll();
            return $this->render('addadmin',['arr'=>$arr]);
        }
    }
    //删除管理员
    public function actionAdmindetele(){
        $id = Yii::$app->request->post('id');
        $db = \Yii::$app->db;
        $res=$db->createCommand()->delete('`study_admin`',"admin_id=$id")->execute();
        if($res){
            $info=[
                'code'=>1000,
                'arr'=>"删除成功"
            ];
            return json_encode($info);
        }else{
            $info=[
                'code'=>1001,
                'arr'=>"删除失败！"
            ];
            return json_encode($info);
        }
    }
    //修改管理员
    public function actionAdminupdate(){
        $request=Yii::$app->request;
        if($request->isPost) {
            $arr = $request->post();
            //print_r($arr);die;
            $db = \Yii::$app->db->createCommand();      //开启DB类
            $img=$_FILES['admin_img'];
            if($img['name'][0]==""){
                $db->update('study_admin', [
                    'admin_name' => $arr['admin_name'],
                    'admin_tel' => $arr['admin_tel'],
                ],['admin_id'=>$arr['admin_id']])->execute();
                //先删
                $db->delete('study_admin_role' , 'admin_id=:id' , [':id' => $arr['admin_id']] )->execute();
                foreach ($arr['role'] as $k=>$v){
                    $re=Yii::$app->db->createCommand()->insert('study_admin_role',[
                        'admin_id' =>$arr['admin_id'],
                        'role_id' =>$v,
                    ])->execute();
                }
                if($re){
                    return $this->redirect("?r=diction/administrators");
                }else{
                    $this->message('?r=diction/administrators',0,"修改失败",$wait=3);
                }
            }else{
                $uploads=new Uploadfile();
            $type = array('image/gif', 'image/jpeg', 'image/png', 'image/pjpeg', 'image/x-png');
            $uploads->Uploadfile($_FILES['admin_img'], './upload/admin',1221024000,$type);
            $num = $uploads->upload();
            if($num!=0) {
                $b_cover = $uploads->getSaveInfo();
                $admin_img = $b_cover[0]['newpath'];
                Yii::$app->db->createCommand()->update('study_admin', [
                    'admin_name' => $arr['admin_name'],
                    'admin_tel' => $arr['admin_tel'],
                    'admin_img' => $admin_img,
                ],'admin_id=:id',[':id'=>$arr['admin_id']])->execute();
                //shan
                $db->delete('study_admin_role' , 'admin_id=:id' , [':id' => $arr['admin_id']] )->execute();
                foreach ($arr['role'] as $k=>$v){
                    $re=Yii::$app->db->createCommand()->insert('study_admin_role',[
                        'admin_id' =>$arr['admin_id'],
                        'role_id' =>$v,
                    ])->execute();
                }
                if($re){
                    return $this->redirect("?r=diction/administrators");
                }else{
                    $this->message('?r=diction/administrators',0,"修改失败",$wait=3);
                }
            }else{
                $this->message('?r=diction/administrators',0,"修改头像失败",$wait=3);
            }
            }
        }else{
            $aid = $request->get('aid');
            $db = new \yii\db\Query;
            $oneadmin=$db->from('study_admin')->where("admin_id=:id " , [':id' => $aid])->one();
            $arr=\Yii::$app->db->createCommand("select * from study_role")->queryAll();
            $yijue=$db->from('study_admin_role')->where('admin_id=:id',[':id'=>$aid])->all();
            //////查询已有角色
            $info=array();
            foreach($yijue as $k=>$v){
                $info[]=$v['role_id'];
            }
            foreach($arr as $key=>$val){
                if(in_array($val['role_id'],$info)){
                    $arr[$key]['pp']=1;
                }else{
                    $arr[$key]['pp']=0;
                }
            }
//            print_r($info);die;
            return $this->render('adminupdate',['oneadmin'=>$oneadmin,'arr'=>$arr]);
        }
    }

    //角色列表
    public function actionRole(){
        $sql = "select * from study_role";
        $connection=Yii::$app->db;
        $role=$connection->createCommand($sql)->queryAll();
        return $this->render('role',['role'=>$role]);
    }
    //添加角色
    public function actionAddrole(){
        $request=Yii::$app->request;
        if($request->isPost) {
            $arr=\Yii::$app->request->post('username');
            $role=explode(',',$arr);
            foreach ($role as $k=>$v){
                $re=Yii::$app->db->createCommand()->insert('study_role',[
                    'role_name' =>$v,
                ])->execute();
            }
            if($re){
                return $this->redirect("?r=diction/role");
            }else{
                $this->message('?r=diction/addrole',0,"添加失败",$wait=3);
            }
        }else{
            return $this->render('addrole');
        }
    }
    //删除角色
    public function actionRoledetele(){
        $id = Yii::$app->request->post('id');
        $db = \Yii::$app->db;
        $res=$db->createCommand()->delete('`study_role`',"role_id=$id")->execute();
        if($res){
            $info=[
                'code'=>1000,
                'arr'=>"删除成功"
            ];
            return json_encode($info);
        }else{
            $info=[
                'code'=>1001,
                'arr'=>"删除失败！"
            ];
            return json_encode($info);
        }
    }

    //节点列表
    public function actionPower(){
        $sql = "select * from study_power";
        $connection=Yii::$app->db;
        $power=$connection->createCommand($sql)->queryAll();
        $arr=$this->recursion($power);
        return $this->render('power',['power'=>$arr]);
    }
    //添加节点
    public function actionAddpower(){
        $request=Yii::$app->request;
        if($request->isPost) {
            $arr=\Yii::$app->request->post();
            $re=Yii::$app->db->createCommand()->insert('study_power',[
                'power_name' =>$arr['username'],
                'action' =>$arr['action'],
                'controller' =>$arr['controller'],
                'pid' =>$arr['pid'],
            ])->execute();
            if($re){
                return $this->redirect("?r=diction/power");
            }else{
                $this->message('?r=diction/addpower',0,"添加失败",$wait=3);
            }
        }else{
            $sql = "select * from study_power";
            $connection=Yii::$app->db;
            $power=$connection->createCommand($sql)->queryAll();
            $a=$this->recursion($power);
            return $this->render('addpower',['power'=>$a]);
        }
    }
    //修改节点
    public function actionPowerupdate(){
        $request=Yii::$app->request;
        if($request->isPost) {
            $arr = $request->post();
            //print_r($arr);die;
            $db = \Yii::$app->db->createCommand();      //开启DB类
            $res=$db->update('study_power', [
                    'power_name' => $arr['username'],
                    'pid' => $arr['pid'],
                    'controller' => $arr['controller'],
                    'action' => $arr['action'],
                ],['power_id'=>$arr['id']])->execute();
            if($res){
                return $this->redirect("?r=diction/power");
            }else{
                $this->message('?r=diction/power',0,"修改失败",$wait=3);
            }
        }else{
            $id = $request->get('id');
            $sql = "select * from study_power";
            $connection=Yii::$app->db;
            $power=$connection->createCommand($sql)->queryAll();
            $a=$this->recursion($power);
            $db = new \yii\db\Query;
            $one=$db->from('study_power')->where("power_id=:id " , [':id' => $id])->one();
            //print_r($one);die;
            return $this->render('powerupdate',['power'=>$a,'one'=>$one]);
        }
    }
    //删除节点
    public function actionPowerdetele(){
        $id = Yii::$app->request->post('id');
        $db = new \yii\db\Query;
        $one=$db->from('study_power')->where("power_id=:id " , [':id' => $id])->one();
//        print_r($one);die;
        $resone=$db->from('study_power')->where('pid=:id',[':id'=>$one['power_id']])->all();
        if($resone){
            $info=[
                'code'=>1002,
                'arr'=>"有子级节点，无法删除！"
            ];
            return json_encode($info);
        }else{
            //删除一条
            $res = $db->createCommand()->delete('`study_power`',"power_id=$id")->execute();
            if($res){
                $info=[
                    'code'=>1000,
                    'arr'=>"删除成功"
                ];
                return json_encode($info);
            }else{
                $info=[
                    'code'=>1001,
                    'arr'=>"删除失败！"
                ];
                return json_encode($info);
            }
        }
    }
    //为角色附权
    public function actionRolepower(){
        $request=Yii::$app->request;
        if($request->isPost) {
            $power=\Yii::$app->request->post();
            if(empty($power)){
                $this->message('?r=diction/powerupdate',0,"无选择节点",$wait=3);
                die;
            }
            $db = \Yii::$app->db->createCommand();
            $db->delete('study_role_power' , "role_id=:id" , [':id' =>$power['role_id']] )->execute();
            foreach ($power['power'] as $k=>$v){
                $res=Yii::$app->db->createCommand()->insert('study_role_power',[
                    'power_id' =>$v,
                    'role_id' =>$power['role_id'],
                ])->execute();
            }
            if($res){
                return $this->redirect("?r=diction/role");
            }else{
                $this->message('?r=diction/role',0,"附权失败",$wait=3);
            }
        }else{
            $role_id=$request->get('id');
            $query = new Query();
            $res = $query->where('role_id=:id',[':id'=>$role_id])->from('study_role')->one();

            $sql = "select * from study_power";
            $rows=Yii::$app->db->createCommand($sql)->queryAll();
            $data=$this->recursion($rows);
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
            ///查询已有权限
            $yi=$query->from('study_role_power')->where('role_id=:id',[':id'=>$role_id])->all();
            //print_r($yi);die;
            $info=array();
            foreach($yi as $k=>$v){
                $info[]=$v['power_id'];
            }
            //print_r($info);die;
            foreach($data as $key=>$val){
                if(in_array($val['power_id'],$info)){
//                    array_push($data[$key],1);
                        $data[$key]['pp']=1;
                }else{
                        $data[$key]['pp']=0;
//                    array_push($data[$key],0);
                }
            }
            //print_r($data);die;
            return $this->render('rolepower',['role'=>$res,'power'=>$data]);
        }

    }
    //递归处理
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
    //消息
    public function message($url,$status,$msg,$wait=3)
    {
        die($this->render('msg.html',['url'=>$url,'status'=>$status,'message'=>$msg,'wait'=>$wait]));
    }
    public function actionAss(){
        echo "111";
    }
}
