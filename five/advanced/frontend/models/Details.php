<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "study_details".
 *
 * @property integer $id
 * @property integer $cur_id
 * @property string $chapter
 * @property string $url
 * @property integer $teacher
 */
class Details extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'study_details';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cur_id', 'chapter', 'url'], 'required'],
            [['cur_id', 'teacher'], 'integer'],
            [['chapter'], 'string', 'max' => 50],
            [['url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cur_id' => 'Cur ID',
            'chapter' => 'Chapter',
            'url' => 'Url',
            'teacher' => 'Teacher',
        ];
    }
}
