<?php

namespace frontend\controllers;
use Yii;

use yii\web\Controller;
use frontend\models\UploadForm;
use common\libraries\Uploadfile;
use yii\web\UploadedFile;
use frontend\models\Type;
class CateController extends CommonController
{
	#404时调用
	public $enableCsrfValidation = false;
	#禁用Yii框架的样式
	public $layout = false;
    //分类列表
    public function actionCate()
    {
        $type=new Type();
        $info=$type::find()->asArray()->all();
        $data=$this->recursion($info);
        //print_r($data);die;
        return $this->render('cate',['data'=>$data]);
    }
    //添加分类
    public function actionAddcate()
    {
        $request=Yii::$app->request;
        $model = new UploadForm();
        if($request->isPost) {
            //print_r($_FILES['type_img']);die;
            $data = Yii::$app->request->post();
            $uploads=new Uploadfile();
            $type = array('image/gif', 'image/jpeg', 'image/png', 'image/pjpeg', 'image/x-png');
            $uploads->Uploadfile($_FILES['type_img'], './upload/type',1221024000,$type);
            $num = $uploads->upload();
            if($num!=0) {
                $b_cover = $uploads->getSaveInfo();
                $admin_img = $b_cover[0]['newpath'];
                $article = new Type();
                $article->type_name = $data['type_name'];
                $article->parent_id = $data['parent_id'];
                $article->type_is_show = $data['type_is_show'];
                $article->type_sort = $data['sort'];
                $article->type_img = $admin_img;
                $res=$article->save();
                if ($res) {
                    //Yii::$app->getSession()->setFlash('errors', '保存成功');
                    return $this->redirect("?r=cate/cate");
                } else {
                    $this->message('?r=cate/addcate', 0, "保存失败", $wait = 3);
                }
            }else{
                $this->message('?r=cate/addcate',0,"文件上传错误",$wait=3);
            }
        }else{
            $type=new Type();
            $info=$type::find()->asArray()->all();
            $data=$this->recursion($info);
            return $this->render('addcate',['type'=>$data,'model'=>$model]);
        }

    }
    //删除分类
    public function actionDetele(){
        $id = Yii::$app->request->post('id');
        $one=Type::find()->select('type_id')->where(['type_id'=>$id])->asArray()->one();
//        print_r($one);die;
        $type=new Type();
        $resone=$type::find()->where(['parent_id'=>$one['type_id']])->asArray()->all();
        if($resone){
            $info=[
                'code'=>1002,
                'arr'=>"有子级分类，无法删除！"
            ];
            return json_encode($info);
        }else{
            //删除一条
            $res = Type::findOne($id)->delete();
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
    //修改分类
    public function actionCateedit(){
        $request=Yii::$app->request;
        if($request->isPost) {
            $data = $request->post();
            //print_r($data);
            $img=$_FILES['type_img'];
            if($img['name'][0]==""){
                $article = Type::findOne($data['tid']);
                $article->type_name = $data['type_name'];
                $article->parent_id = $data['parent_id'];
                $article->type_is_show = $data['type_is_show'];
                $article->type_sort = $data['sort'];
                $res=$article->save();
                if($res){
                    //Yii::$app->getSession()->setFlash('errors', '保存成功');
                    return $this->redirect("?r=cate/cate");
                } else {
                    $this->message('?r=cate/cate',0,"保存失败",$wait=3);
                }
            }else{
                $uploads=new Uploadfile();
                $type = array('image/gif', 'image/jpeg', 'image/png', 'image/pjpeg', 'image/x-png');
                $uploads->Uploadfile($_FILES['type_img'], './upload/type',1221024000,$type);
                $num = $uploads->upload();
                if($num!=0) {
                    $b_cover = $uploads->getSaveInfo();
                    $admin_img = $b_cover[0]['newpath'];
                    $article = Type::findOne($data['tid']);
                    $article->type_name = $data['type_name'];
                    $article->parent_id = $data['parent_id'];
                    $article->type_is_show = $data['type_is_show'];
                    $article->type_sort = $data['sort'];
                    $article->type_img = $admin_img;
                    $res=$article->save();
                    if($res){
                        //Yii::$app->getSession()->setFlash('errors', '保存成功');
                        return $this->redirect("?r=cate/cate");
                    } else {
                        $this->message('?r=cate/cate',0,"保存失败",$wait=3);
                    }
                }else{
                    $this->message('?r=cate/cate',0,"图标保存失败",$wait=3);
                }
            }
        }else{
            $tid = $request->get('tid');
            $one=Type::find()->where(['type_id'=>$tid])->asArray()->one();
            $type=new Type();
            $info=$type::find()->asArray()->all();
            $data=$this->recursion($info);
            return $this->render('cateedit',['one'=>$one,'type'=>$data]);
        }
    }
//是否显示点改
    public function actionShowupdate(){
        $tid = Yii::$app->request->post('tid');
        $is_show = Yii::$app->request->post('is_show');
        $article = Type::findOne($tid);
        $article->type_is_show = $is_show;
        $res=$article->save();
        if($res){
            $info=[
                'code'=>1000,
                'arr'=>"修改成功！"
            ];
            return json_encode($info);
        }else{
            $info=[
                'code'=>1001,
                'arr'=>"修改失败！"
            ];
            return json_encode($info);
        }
    }
//    public function actionUpload()
//    {
//        $model = new UploadForm();
//        if (Yii::$app->request->isPost) {
//            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
//            if ($model->upload()) {
//                // 文件上传成功
//                return;
//            }
//        }
//
//        return $this->render('upload', ['model' => $model]);
//    }
// //图片上传
//    public function actionUploadone()
//    {
//        $uploaddir     = 'upload/';
//        $filename      = date("Ymdhis").rand(100,999);
//        $uploadfile    = $uploaddir . $filename.substr($_FILES['Filedata']["name"],strrpos($_FILES['Filedata']["name"],"."));
//        $temploadfile  = $_FILES['Filedata']['tmp_name'];
//        move_uploaded_file($temploadfile , $uploadfile);
//
//        //返回数据  在页面上js做处理
//        $filedata = array(
//            'result' => 'true',
//            'name' => $_FILES['Filedata']["name"],
//            'filepath' => $uploadfile,
//        );
//        echo json_encode($filedata);
//        exit;
//    }
    public function recursion($data,$path=0,$flag=1){
        static $arr=array();
        foreach($data as $key=>$val){
            if($val['parent_id']==$path){
                $val['flag']=$flag;
                $arr[]=$val;
                $this->recursion($data,$val['type_id'],$flag+1);
            }
        }
        return $arr;
    }
    //消息
    public function message($url,$status,$msg,$wait=3)
    {
        die($this->render('msg.html',['url'=>$url,'status'=>$status,'message'=>$msg,'wait'=>$wait]));
    }
}
