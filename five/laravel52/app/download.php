<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class download extends Model
{
    //
    public $table = 'study_down';

    public $timestamps = false;

    public $primaryKey = 'down_id';

    public function ins($userid,$url,$fid){



        $users = $this->whereRaw('user_id = ? and downaddress = ? and fid = ?', [$userid,$url,$fid])->get()->toArray();





       if($users){
           return 0;
       }else{
           $this->user_id = $userid;
           $this->downaddress = $url;
           $this->fid = $fid;
           $res = $this->save();
           return $res;
       }


    }
}
