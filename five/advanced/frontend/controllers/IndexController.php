<?php

namespace frontend\controllers;

class IndexController extends CommonController
{
	#404时调用
	public $enableCsrfValidation = false;
	#禁用Yii框架的样式
	public $layout = false;

    public function actionIndex()
    {
        return $this->render('index');
    }

    //网站建设
    public function actionInfo()
    {
    	return $this->render('info');
    }
    //
}
