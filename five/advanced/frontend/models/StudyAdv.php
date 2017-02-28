<?php

namespace frontend\models;


use yii\base\Model;
use yii\base\InvalidParamException;
use common\models\User;

use Yii;

/**
 * This is the model class for table "study_adv".
 *
 * @property string $adv_id
 * @property string $adv_title
 * @property string $adv_url
 * @property string $adv_img
 * @property string $adv_desc
 * @property integer $adv_sort
 * @property integer $adv_is_show
 */
class StudyAdv extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'study_adv';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['adv_desc'], 'string'],
            [['adv_sort', 'adv_is_show'], 'integer'],
            [['adv_title', 'adv_url', 'adv_img'], 'string', 'max' => 60],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'adv_id' => 'Adv ID',
            'adv_title' => 'Adv Title',
            'adv_url' => 'Adv Url',
            'adv_img' => 'Adv Img',
            'adv_desc' => 'Adv Desc',
            'adv_sort' => 'Adv Sort',
            'adv_is_show' => 'Adv Is Show',
        ];
    }
    /**
     * 模型层添加轮播图信息
     */
    public static function addAdv($title,$url,$filename,$desc,$sort)
    {
          $adv = new Self();
          $adv->adv_title=$title;
          $adv->adv_url=$url;
          $adv->adv_img=$filename;
          $adv->adv_desc=$desc;
          $adv->adv_sort=$sort;
          $reg = $adv->save();
          return $adv;
    }
    /**
     * 查询轮播图
     */
    public static function getInfo()
    {
        $result = Self::find()->asArray()->all();
        return $result;
    }
    /**
     * 根据轮播图ID查询轮播图
     * 返回单条数据
     */
    public static function updateAdv($adv_id)
    {
      $res=Self::find()->where(['adv_id'=>$adv_id])->asArray()->one();
      return $res;
    }
}
