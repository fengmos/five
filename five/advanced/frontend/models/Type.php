<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%type}}".
 *
 * @property integer $type_id
 * @property string $type_name
 * @property integer $parent_id
 * @property integer $type_sort
 * @property integer $type_is_show
 * @property integer $type_buy
 */
class Type extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%type}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_name', 'parent_id'], 'required'],
            [['parent_id', 'type_sort', 'type_is_show', 'type_buy'], 'integer'],
            [['type_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'type_id' => 'Type ID',
            'type_name' => 'Type Name',
            'parent_id' => 'Parent ID',
            'type_sort' => 'Type Sort',
            'type_is_show' => 'Type Is Show',
            'type_buy' => 'Type Buy',
        ];
    }
}
