<?php
namespace frontend\controllers;


use Yii;
use yii\db\Query;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use yii\data\Pagination;
use frontend\models\Teacher;
use frontend\models\StudyTeacher;
use frontend\models\Type;


/**
 * 名师点播
 * Teacher controller
 */
class TeacherController extends CommonController
{

public $enableCsrfValidation = false; //禁止表单提交验证
public $layout = false;
   

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

/**
 *跳转添加页面
 *    
 */
	public function actionYe(){
                         $query = new Query();
                      $res = $query->select('teacher_id,teacher_name')->from('study_teacher')->all();

                        $type=new Type();
                         $info=$type::find()->asArray()->all();
                         $data=$this->recursion($info);
	 	return $this->render('teacher',['type'=>$data,'laoshi'=>$res]);
	}



 /**
  * 添加直播
  * @inheritdoc
  */
    public function actionAdd()
    {
    	
    	$upload=new UploadedFile(); //实例化上传类
    	//print_r($upload);die;
        $name=$upload->getInstanceByName('photo'); //获取文件原名称
        $img=$_FILES['photo']; //获取上传文件参数
        //print_r($img);die;
		$tmp_img=$upload->tempName=$img['tmp_name']; //设置上传的文件的临时名称
		
		//创建目录
		$dir='upload/';
		$rand = md5(time() . mt_rand(0,10000));
		$name= $dir.$rand.'.'.'jpg';
		//print_r($name);die;
		$arr=$upload->saveAs($name,true); //保存文件
		 //var_dump($arr);
    	if($arr){
    		$photo=$name;
    		//print_r($photo);die;
    	//接值 用request
    		$add= yii::$app->request;
    		$res=$add->post();
    		$title=$res['title'];
    		$begintime=strtotime($res['begintime']);
    		$endtime=strtotime($res['endtime']);
    		$course=$res['course'];
    
                     $type_id=$res['type_id'];
                         $teacher_id=$res['teacher_id'];
                         $url = $res['url'];
    		$test= new Teacher();
    		//print_r($test);die;
        			       $test->title     =       $title;
        			       $test->photo     =        $photo;
        			       $test->begintime =   $begintime;
        			       $test->endtime   =     $endtime;
        			       $test->course    =      $course;
                                       $test->type_id = $type_id;
                                       $test->teacher_id=$teacher_id;
                                       $test->url=$url;
        			$res  =  $test->save();
        			if($res){

        				return $this->redirect("?r=teacher/show");

        			}else{

        				echo  "alert('失败')";
        			}
    	}else{
    		echo "失败失败";
    	}
    	//print_r($res);die;

    }


 /**
  *直播列表
  * 
  */

	public function actionShow(){

     /**
      * 查询
      */
      
		$test=new teacher();	//实例化model模型
		$arr=$test->find();
		//$countQuery = clone $arr;
		$pages = new Pagination([
		//'totalCount' => $countQuery->count(),
		'totalCount' => $arr->count(),
		'pageSize'   => 4  //每页显示条数
		]);
		$rel = $arr->offset($pages->offset)
			->limit($pages->limit)
			->all();
	return $this->render('show', [
		'rel' => $rel,
		'pages'  => $pages
	]);

	}   


	/**
	 *
	 * 删除
	 */

	public function actionDelete(){	
		//echo 1;die;
	//接删除id
		$id=$_GET['id'];
		//echo $id;die;
		
		$result=teacher::find()->where(['id'=>$id])->one();
		$reg = $result->delete();
		if($reg)
		{
			return 1;
		}

	}

	/**
	 * 教师添加页面
	 */
	public function actionTeacher_add_html()
	{
         return  $this->render('teacher_add');
	}
    /**
     * 添加教师信息
     */
    public function actionTeacher_add_info()
    {
          $request=Yii::$app->request;
    	if($request->isPost)
    	{
    		$file = UploadedFile::getInstanceByName('photo');//获取图片信息
    		$post=$request->post(); // 接受数据
    		$names = $post['name'];
    		$desc = $post['desc'];
    		$years = $post['years'];
                     $address = $post['address'];
                     $email = $post['email'];
    		$dir = 'upload/';                //上传目录
    		$name = $dir.$file->name; //上传文件后的绝对路径
    		$status = $file->saveAs($name,true);
    		if($status)
    		{
               
                $filename = $file->name;
                //$reg = $StudyAdv->addAdv($title,$url,$filename,$desc,$sort);
                 $db = \Yii::$app->db->createCommand();
                 $reg = $db->insert('study_teacher' , ['teacher_name'=>$names,'teacher_years'=>$years,'teacher_img'=>$filename,'teacher_desc'=>$desc,'teacher_address'=>$address,'teacher_email'=>$email])->execute();//执行添加操作
        			// $StudyAdv->adv_title=$title;
				    // $StudyAdv->adv_url=$url;
				    // $StudyAdv->adv_img=$filename;
				    // $StudyAdv->adv_desc=$desc;
				    // $StudyAdv->adv_sort=$sort;
				    // $reg = $StudyAdv->save();
				    // print_r($reg);
                if($reg)
                {
                	echo "<script>alert('添加成功');location.href='?r=teacher/teacher_list'</script>";
                }else
                {
                	die('失败');
                }
    		}else
    		{
    			echo "<script>alert('服务器错误');localtion.href='?r=teacher/teacher_add_html'</script>";
    		}
    	}else
    	{
    		return $this->render('teacher_add_html');
    	}
    }

    /**
     * 教师展示页面
     */
     public function actionTeacher_list()
     {
         $StudyTeacher = new StudyTeacher();
         $info = $StudyTeacher->find()->asArray()->all();
     	return $this->render('teacher_list',['info'=>$info]);
     }
     /**
      * 删除教师
      */
     public function actionDelete_teacher()
     {
     	$teacher_id = $_GET['id'];
     	$StudyTeacher = new StudyTeacher();
     	$result=$StudyTeacher->find()->where(['teacher_id'=>$teacher_id])->one();
		$reg = $result->delete();
		if($reg)
		{
			return 1;
		}
     }
}


?>