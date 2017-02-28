<?php

namespace frontend\controllers;

class AdminController extends \yii\web\Controller
{
	#404时调用
	public $enableCsrfValidation = false;
	#禁用Yii框架的样式
	public $layout = false;

	//管理员修改密码
    public function actionPass()
    {
        return $this->render('pass');
    }

}
