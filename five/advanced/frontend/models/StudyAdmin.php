<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "admin".
 *
 * @property integer $admin_id
 * @property string $admin_name
 * @property string $admin_pwd
 * @property string $admin_tel
 * @property integer $admin_status
 * @property string $admin_time
 * @property string $admin_ip
 * @property string $admin_img
 */
class StudyAdmin extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'study_admin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['admin_name', 'admin_pwd'], 'required'],
            [['admin_status'], 'integer'],
            [['admin_time'], 'safe'],
            [['admin_name'], 'string', 'max' => 50],
            [['admin_pwd'], 'string', 'max' => 32],
            [['admin_tel'], 'string', 'max' => 20],
            [['admin_ip'], 'string', 'max' => 100],
            [['admin_img'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'admin_id' => 'Admin ID',
            'admin_name' => 'Admin Name',
            'admin_pwd' => 'Admin Pwd',
            'admin_tel' => 'Admin Tel',
            'admin_status' => 'Admin Status',
            'admin_time' => 'Admin Time',
            'admin_ip' => 'Admin Ip',
            'admin_img' => 'Admin Img',
        ];
    }
    /**
     * 检测管理员账号密码
     */
    public static function checkAdmin($name,$pwd)
    {
        $res=Self::find()->where(['admin_name'=>$name])->asArray()->one();
        if($res)
        {
            $admin_pwd = $res['admin_pwd'];
            $admin_id = $res['admin_id'];
            $hash_pwd = Yii::$app->security->validatePassword($pwd,$admin_pwd);
            if($hash_pwd)
            {
               $error['code'] = 1;
               $error['admin_id'] = $admin_id;
               $error['status'] = $admin_id;
               return $error;
            }else
            {
                return 'no';
            }
        }else
        {
            return 'no';
        }
    }
    /**
     * 修改管理员登录信息
     */
      public static function saveInfo($name,$time,$ip)
    {
        $res=Self::find()->where(['admin_name'=>$name])->asArray()->one();
        if($res)
        {
            $admin = Self::findOne($res['admin_id']);
            $admin->admin_ip=$ip;
            $admin->admin_time=$time;
            $reg = $admin->save();
            return $reg;
        }
    }

}
