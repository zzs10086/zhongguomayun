<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Lib\Util;
use Illuminate\Support\Facades\Input;

class BaseController extends Controller
{
    //
    const WECHATKEY = 'zzs594ba@*2f5fH9zzs';  //小程序 KEY

    public function __construct()
    {

        //对小程序进行简单的加密,正式环境需要token对比

        if (Util::isWX()) {

            if(self::debugWechatEncode(self::WECHATKEY)==false){

                echo "token校验错误";

                exit;
            }
        }
    }

    /**
     * 微信小程序加密验证
     * @param $salt
     * @return bool
     */
    protected static function debugWechatEncode($salt){

        $token = Input::get('token_wechat');

        $time = Input::get('time_wechat');

        $rand = Input::get('rand_wechat');

        if(!$token || !$time || !$rand){

            return false;

        }
        $str = md5($time.$rand.$salt);

        return $token == $str;
    }
}
