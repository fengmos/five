<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Info extends Model
{
    protected $table='study_info';
    protected $primaryKey='study_id';
    public $timestamps = false;
    /**
     * 用户反馈意见
     */
   public function user_info_feedback($email,$feedBack,$nickname)
   {
      $userInfo = DB::table('study_user')->where('nickname', '=',$nickname)->first();
      $reg  = $this->insert(['user_email' => $email, 'study_log' => $feedBack,'user_id'=>$userInfo['user_id']]);
      return $reg;
   }
}
