<?php

namespace frontend\controllers;

class ContentController extends \yii\web\Controller
{
	#404时调用
	public $enableCsrfValidation = false;
	#禁用Yii框架的样式
	public $layout = false;
    //内容显示列表
    public function actionContentlist()
    {
        return $this->render('list');
    }
    //添加内容
    public function actionContentadd()
    {
        return $this->render('add');
    }

}
