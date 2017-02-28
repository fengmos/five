<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "study_chapter".
 *
 * @property integer $id
 * @property integer $det_id
 * @property string $url
 */
class Chapter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'study_chapter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['det_id'], 'integer'],
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
            'det_id' => 'Det ID',
            'url' => 'Url',
        ];
    }
}
