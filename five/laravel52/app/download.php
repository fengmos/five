<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class download extends Model
{
    //
    public $table = 'study_down';

    public function ins($userid,$url){

        $this->user_id = $userid;
        $this->downaddress = $url;
        $res = $this->save();
        return $res;

    }
}
