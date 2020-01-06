<?php

namespace App\Http\Controllers\Pc;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class WechatController extends Controller
{
    //
     private $token = 'zgmy';

     /**
      * 处理微信的请求消息
      *
      * @return string
      */
     public function check_token()
     {
          Log::info('request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志

          $app = app('wechat.official_account');
          $app->server->push(function($message){
               return "欢迎关注 overtrue！";
          });

          return $app->server->serve();
     }

     public function check_tokens(Request $request){

         /* $signature = $request->get('signature');
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
          }*/

          //获得参数 signature nonce token timestamp echostr
          /*$echostr = $request->get('echostr');

          $signature = $request->get('signature');
          $nonce = $request->get('nonce');
          $timestamp = $request->get('timestamp');

          //形成数组，然后按字典序排序

          $array = array($nonce, $timestamp, $this->token);

          sort($array);

          //拼接成字符串,sha1加密 ，然后与signature进行校验

          $str = sha1( implode( $array ) );

          if( $str  == $signature && $echostr ){
               Log::info('Wechat where', ['data'=>'signature']);
               //第一次接入weixin api接口的时候

               echo  $echostr;

               exit;

          }else{
               Log::info('Wechat where', ['data'=>'responseMsg']);
               $this->responseMsg();

          }*/

          //Log::info('Wechat where', ['data'=>'responseMsg']);
          $this->responseMsg();

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

     private function responseMsg()
     {
//1.获取到微信推送过来post数据（xml格式）
          //$postArr=$GLOBALS['HTTP_RAW_POST_DATA'];
          $postStr =file_get_contents("php://input");
//2.处理消息类型，并设置回复类型和内容
          //$postObj=simplexml_load_string($postStr);
          $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
          //判断该数据包是否是订阅de事件推送
          if(strtolower($postObj->MsgType)=='event')
          {
               //Log::info('Wechat MsgType', ['data'=>'event']);
               //如果是关注 subscribe事件
               if(strtolower($postObj->Event)=='subscribe')
               {
                    //Log::info('Wechat Event', ['data'=>'subscribe']);
                    $toUser    =$postObj->FromUserName;
                    $fromUser  =$postObj->ToUserName;
                    $time      =time();
                    $msgType   ='text';
                    $content   ='hello lao siji';
                    $template="<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[%s]]></MsgType>
                    <Content><![CDATA[%s]]></Content>
                    </xml>";
                    $info=sprintf($template,$toUser,$fromUser,$time,$msgType,$content);
                    echo $info;
               }
          }

     }

}
