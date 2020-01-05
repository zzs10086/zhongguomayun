<?php

namespace App\Http\Controllers\Pc;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WechatController extends Controller
{
    //
     private $token = 'zgmy';
     public function wechat(Request $request){

          $signature = $request->get('signature');
          $nonce = $request->get('nonce');
          $timestamp = $request->get('timestamp');
          //如果相等，验证成功就返回echostr
          if($this->checkSignature($signature,$nonce,$timestamp))
          {
               //返回echostr
               $echostr = $request->get('echostr');
               if($echostr)
               {
                    echo $echostr;
                    exit;
               }
          }

     }

     //检查标签
     private  function checkSignature($signature, $nonce, $timestamp)
     {
          //先获取到这三个参数
          /*$signature = $_GET['signature'];
          $nonce = $_GET['nonce'];
          $timestamp = $_GET['timestamp'];*/

          //把这三个参数存到一个数组里面
          $tmpArr = array($timestamp, $nonce, $this->token);
          //进行字典排序
          sort($tmpArr);

          //把数组中的元素合并成字符串，impode()函数是用来将一个数组合并成字符串的
          $tmpStr = implode($tmpArr);

          //sha1加密，调用sha1函数
          $tmpStr = sha1($tmpStr);
          //判断加密后的字符串是否和signature相等
          if ($tmpStr == $signature) {

               return true;
          }
          return false;
     }
}
