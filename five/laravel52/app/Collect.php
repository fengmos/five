<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Collect extends Model
{
    protected $table='study_collect';
    protected $primaryKey='id';
    public $timestamps = false;
   /**
    * 添加个人收藏
    */
   public function addCol($cur_id,$nickname)
   {
        $userInfo = DB::table('study_user')->where('nickname', '=',$nickname)->first();
        $res = $this->insert(['user_id'=>$userInfo['user_id'],'cur_id'=>$cur_id]);
        return $res;
   }
   /**
    * 查询个人收藏
    */
    public function getCol($nickname)
    {
          $userInfo = DB::table('study_user')->where('nickname', '=',$nickname)->first();
          $reg = $this->where('user_id',$userInfo['user_id'])->get(array('cur_id'))->toArray();
          return $reg;
    }
    /**
     * 删除个人收藏
     */
    public function delCol($cur_id,$nickname)
    {
      $userInfo = DB::table('study_user')->where('nickname', '=',$nickname)->first();
      $reg = $this->where('user_id',$userInfo['user_id'])->where('cur_id',$cur_id)->delete();

    }
}
