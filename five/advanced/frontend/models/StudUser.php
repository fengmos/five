<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

class StudUser extends ActiveRecord
{

    /**
     * 声明表名
     *
     * @author YING
     * @param void
     * @return void
     */
    public static function tableName()
    {
        return '{{%study_notes}}';
    }


    /**
     * 验证规则
     *
     * @author YING
     * @param void
     * @return void
     */
}