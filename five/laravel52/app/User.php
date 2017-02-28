<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table='study_user';
    protected $primaryKey='user_id';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
  public function Updateinfo($nickname,$nickName,$desc)
  {
      $arr = $this->where('nickname','=',$nickname)->first();
      $res = $this->where('user_id','=',$arr['user_id'])->update(['nickname'=>$nickName,'user_desc'=>$desc]);
      return 1;
  }
    /**
     * 修改个人资料
     */
    public function Update_info($nickname,$nickName,$desc,$filename)
    {
        $arr = $this->where('nickname','=',$nickname)->first();
        $res = $this->where('user_id','=',$arr['user_id'])->update(['nickname'=>$nickName,'user_desc'=>$desc,'img'=>$filename]);
        return 1;
    }
    /**
     * 展示用户个人资料
     */
    public function infomation($nickname)
    {
        $reg = $this->where('user_id','=',$nickname)->first();
        return $reg;
    }
}
