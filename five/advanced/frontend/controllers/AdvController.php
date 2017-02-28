<?php

namespace frontend\controllers;
use Yii;
use yii\web\UploadedFile;
use frontend\models\StudyAdv;
class AdvController extends CommonController
{
	#404时调用
	public $enableCsrfValidation = false;
	#禁用Yii框架的样式
	public $layout = false;

    public function actionAdv()
    {
    	 $StudyAdv = new StudyAdv();
    	 $data = $StudyAdv->getInfo();
        return $this->render('adv',['data'=>$data]);
    }
    /**
     * 添加前台首页轮播图
     */
    public function actionAdv_add()
    {
    	$request=Yii::$app->request;
    	if($request->isPost)
    	{
    		$file = UploadedFile::getInstanceByName('file');//获取图片信息
    		$post=$request->post(); // 接受数据
    		$title = $post['title'];
    		$desc = $post['note'];
    		$url = $post['url'];
    		$sort = $post['sort'];
    		$dir = 'upload/';                //上传目录
    		$name = $dir.$file->name; //上传文件后的绝对路径
    		$status = $file->saveAs($name,true);
    		if($status)
    		{
               
                $filename = $file->name;
                //$reg = $StudyAdv->addAdv($title,$url,$filename,$desc,$sort);
                 $db = \Yii::$app->db->createCommand();
                 $reg = $db->insert('study_adv' , ['adv_title'=>$title,'adv_url'=>$url,'adv_img'=>$filename,'adv_desc'=>$desc,'adv_sort'=>$sort])->execute();//执行添加操作
        			// $StudyAdv->adv_title=$title;
				    // $StudyAdv->adv_url=$url;
				    // $StudyAdv->adv_img=$filename;
				    // $StudyAdv->adv_desc=$desc;
				    // $StudyAdv->adv_sort=$sort;
				    // $reg = $StudyAdv->save();
				    // print_r($reg);
                if($reg)
                {
                	echo "<script>alert('添加成功');location.href='?r=adv/adv'</script>";
                }else
                {
                	die('失败');
                }
    		}else
    		{
    			echo "<script>alert('服务器错误');localtion.href='?r=adv/adv'</script>";
    		}
    	}else
    	{
    		return $this->render('adv');
    	}
    }

    /**
     * 修改轮播图查询单条数据
     */
    public function actionUpdate_adv()
    {
        $request = Yii::$app->request;
        $post = $request->post();
        $adv_id = $post['id'];       //获取到轮播图的ID
        $adv = new StudyAdv();      
        $reg = $adv->updateAdv($adv_id);     //调用Adv model 并将要查询的ID传入model
        return json_encode($reg);        //获取数据后转化为json格式传到前台页面
    } 
    /**
     * 根据ID修改轮播图信息
     */
    public function actionAdv_update_one()
    {
        $request = Yii::$app->request;
        if($request->isPost)
        {
            $post = $request->post();   //接受要修改的轮播图的信息
            $adv_id = $post['adv_id'];
            $adv_title = $post['title'];
            $adv_url = $post['url'];
            $adv_desc = $post['note'];
            $adv_sort = $post['sort'];
            $file = UploadedFile::getInstanceByName('file');//获取图片信息
           // print_r($file);die;
                $dir = 'upload/';                //上传目录
                $name = $dir.$file->name; //上传文件后的绝对路径
                $status = $file->saveAs($name,true);
                if($status)
                {
                   
                    $filename = $file->name;
                    //$reg = $StudyAdv->addAdv($title,$url,$filename,$desc,$sort);
                     $db = \Yii::$app->db->createCommand();
                     //执行轮播图单条修改
                     $reg = $db->update('study_adv' , ['adv_title'=>$adv_title,'adv_url'=>$adv_url,'adv_img'=>$filename,'adv_desc'=>$adv_desc,'adv_sort'=>$adv_sort], ['adv_id'=>$adv_id])->execute();

                    if($reg)
                    {
                        echo "<script>alert('修改成功');location.href='?r=adv/adv'</script>";
                    }else
                    {
                        die('失败');
                    }
                }else
                {
                    echo "<script>alert('服务器错误');localtion.href='?r=adv/adv'</script>";
                }
        }
    }

    /**
     * 删除单条轮播图
     */
    public function actionDelete_adv()
    {
        $adv_id = $_GET['id'];
        $StudyAdv = new StudyAdv();
        $result=$StudyAdv->find()->where(['adv_id'=>$adv_id])->one();
        $reg = $result->delete();
        if($reg)
        {
            return 1;
        }
    }

}
