<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\download;

class DownlistController extends Controller
{
    //
    public $downloads;

    public function __construct(download $download){

        $this->$downloads = $download;

    }

    public function downlist(Request $Request){
        $userid = $Request->input('userid');  //用户名
        $url = $Request->input('url');  //用户名

        $res = $this->$downloads->ins($userid,$url);

        print_r($res);

        
    }



}
