<?php

namespace frontend\controllers;

class PageController extends \yii\web\Controller
{
	#404时调用
	public $enableCsrfValidation = false;
	#禁用Yii框架的样式
	public $layout = false;
	
    public function actionPage()
    {
        return $this->render('page');
    }

}
