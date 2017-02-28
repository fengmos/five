<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Order extends Model
{
    protected $table='study_order';
    protected $primaryKey='user_id';
    public $timestamps = false;
    /**
     * 用户已购买的视频
     */
    public function orderList($nickname)
    {
        $userInfo = DB::table('study_user')->where('nickname', '=',$nickname)->first();
        $orderData = $this->where('user_id',$userInfo['user_id'])->where('status','1')->get()->toArray();
        return $orderData;
    }
}
