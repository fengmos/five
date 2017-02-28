<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use DB;
use App\User;
class MoreController extends Controller{

/**
 * 更多
 * @return [type] [description]
 */

     public function more(){
     	return view('more.more');
     }

     

}

?>
