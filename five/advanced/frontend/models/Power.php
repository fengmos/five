<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "power".
 *
 * @property integer $power_id
 * @property string $power_name
 * @property string $action
 * @property string $controller
 * @property integer $pid
 */
class Power extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'study_power';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid'], 'integer'],
            [['power_name', 'action', 'controller'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'power_id' => 'Power ID',
            'power_name' => 'Power Name',
            'action' => 'Action',
            'controller' => 'Controller',
            'pid' => 'Pid',
        ];
    }
}
