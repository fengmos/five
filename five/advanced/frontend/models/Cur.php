<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "study_cur".
 *
 * @property integer $cur_id
 * @property string $cur_name
 * @property string $cur_addtime
 * @property string $cur_img
 * @property integer $teacher_id
 * @property integer $cur_is_heat
 * @property integer $cur_is_new
 * @property string $cur_describe
 * @property string $cur_price
 * @property integer $typeid
 * @property string $price
 */
class Cur extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'study_cur';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cur_name', 'teacher_id'], 'required'],
            [['cur_addtime'], 'safe'],
            [['teacher_id', 'cur_is_heat', 'cur_is_new', 'typeid'], 'integer'],
            [['cur_name', 'cur_price'], 'string', 'max' => 50],
            [['cur_img', 'cur_describe', 'price'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cur_id' => 'Cur ID',
            'cur_name' => 'Cur Name',
            'cur_addtime' => 'Cur Addtime',
            'cur_img' => 'Cur Img',
            'teacher_id' => 'Teacher ID',
            'cur_is_heat' => 'Cur Is Heat',
            'cur_is_new' => 'Cur Is New',
            'cur_describe' => 'Cur Describe',
            'cur_price' => 'Cur Price',
            'typeid' => 'Typeid',
            'price' => 'Price',
        ];
    }
}
