<?php
namespace frontend\controllers;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\db\Query;
use frontend\models\Type;
use frontend\models\StudUser;
use yii\data\Pagination;
/**
 * Notes controller
 */
class NotesController extends \yii\web\Controller
{
    #404时调用
    public $enableCsrfValidation = false;
    #禁用Yii框架的样式
    public $layout = false;
    //笔记添加页面
    public function actionNotes_ad(){
        //分类查询
        $type=new Type();
        $info=$type::find()->asArray()->all();
        $data=$this->recursion($info);
        //老师
        $query = new Query();
        $res = $query->select('teacher_id,teacher_name')->from('study_teacher')->all();
        return $this->render('notes_ad',['type'=>$data,'teacher'=>$res]);
    }
    //查询所有的分类
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
    //添加入库
    public function actionNotes_ads(){
        $notes_hot=Yii::$app->request->post('notes_hot');
        $notes_assess=Yii::$app->request->post('notes_assess');
        $notes_tittle=Yii::$app->request->post('notes_tittle');
        $teacher_id=Yii::$app->request->post('teacher_id');
        $type=Yii::$app->request->post('type');
        $notes_time=date("Y-m-d H:i:s");
        $db=Yii::$app->db;
        $res=$db->createCommand()->insert('study_notes', [
            'teacher_id' =>$teacher_id,
            'type_id' => $type,
            'notes_assess' =>$notes_assess,
            'notes_tittle' =>$notes_tittle,
            'notes_time'=>$notes_time,
            'notes_hot'=>$notes_hot
        ])->execute();
        if($res)
        {
            $this->redirect('?r=notes/notes_show');
        }else{
            $this->redirect('?r=notes/notes_ad');
        }
    }
    //展示页面
    public function actionNotes_show(){
        //实例化query
        $query=new Query();

        $query->from('study_notes');
        //分页
        $pagination = new Pagination(['totalCount' => $query->count()]);

        //条数
        $pagination->setPageSize('3');

        //条件
        $query->offset($pagination->offset)->limit($pagination->limit);

        //执行
        $userInfo=$query->join('INNER JOIN', 'study_teacher', 'study_notes.teacher_id=study_teacher.teacher_id')->join('INNER JOIN', 'study_type', 'study_notes.type_id=study_type.type_id')->all();
        return $this->render('notes_show',['userInfo'=>$userInfo,'page'=>$pagination]);
    }
    //笔记删除
    public function actionNotes_del(){
        $notes_id=Yii::$app->request->post('notes_id');
        $db=Yii::$app->db;
        $res=$db->createCommand()->delete('study_notes',"notes_id='$notes_id'")->execute();
        if($res)
        {
            echo 1;
        }else
        {
          echo 2;
        }
    }
}