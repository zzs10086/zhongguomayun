<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Lib\Util;

class Tag extends Model
{
    //
     protected $table = 'tag';

     public $timestamps = false;

     public static function getTag($limit = 20){

          $key = "getTag:". $limit;

          $data = Util::getRedis($key, true);

          if(!$data) {

               $data = Tag::where([['status',1]]) ->limit($limit) ->orderBy('id', 'desc')->get()->toArray();

               Util::setRedis($key, $data);
          }

          return $data;
     }

}
