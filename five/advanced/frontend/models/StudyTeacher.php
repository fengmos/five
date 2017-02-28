<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "study_teacher".
 *
 * @property string $teacher_id
 * @property string $teacher_name
 * @property string $teacher_img
 * @property string $teacher_years
 * @property string $teacher_desc
 */
class StudyTeacher extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'study_teacher';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['teacher_desc'], 'string'],
            [['teacher_name', 'teacher_years'], 'string', 'max' => 60],
            [['teacher_img'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'teacher_id' => 'Teacher ID',
            'teacher_name' => 'Teacher Name',
            'teacher_img' => 'Teacher Img',
            'teacher_years' => 'Teacher Years',
            'teacher_desc' => 'Teacher Desc',
        ];
    }
}
