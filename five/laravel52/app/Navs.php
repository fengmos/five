<?php

namespace App\Http;

use Illuminate\Database\Eloquent\Model;

class Navs extends Model
{
    protected $table='user';
    protected $primaryKey='id';
    public $timestamps=false;
    protected $guarded=[];
}
