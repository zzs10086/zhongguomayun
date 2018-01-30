<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/18
 * Time: 13:53
 */
namespace App\Lib;
use Illuminate\Support\Facades\Redis;

class Util
{
    const DS = DIRECTORY_SEPARATOR;

    private static $redisExpire = 3600;

    public static function debug_log($msg, $level = '')
    {
        $logs_path = storage_path() . '/logs/';

        $logdir = $logs_path ? $logs_path : '/tmp';

        $level = strtolower($level);
        if ($level == '' || $level == 'debug') {
            $f = 'debug';
        } else {
            $f = 'debug_' . $level;
        }
        $flag=file_put_contents(rtrim($logdir,self::DS).self::DS.$f.'.'.date('Ymd'),(is_array($msg)?print_r($msg,true):$msg)."\t".date('Y-m-d H:i:s')."\n",FILE_APPEND);
        if($flag===false)
        {
            if(!file_exists($logdir) || !is_dir($logdir))
            {
                mkdir($logs_path,0777,true);
            }
            file_put_contents(rtrim($logdir,self::DS).self::DS.$f.'.'.date('Ymd'),(is_array($msg)?print_r($msg,true):$msg)."\t".date('Y-m-d H:i:s')."\n",FILE_APPEND);
        }
    }


    /**
     * 获取远程url内容
     * @param $url
     * @param array $data
     * @param string $method
     * @param string $userAgentType
     * @return bool
     */
    public static function curl_get_contents($url, $data = array(), $method = 'POST', $userAgentType = '')
    {
        $request_data = http_build_query($data);

        $ch = curl_init();
        $this_header = array(
            "content-type: application/x-www-form-urlencoded;charset=UTF-8"
        );
        if ($data && strtoupper($method) == 'GET') {
            $url .= '?' . $request_data;
        } elseif ($data && strtoupper($method) == 'POST') {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELself::DS, $request_data);
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $this_header);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  #追踪重定向
        if ($userAgentType == 'app') {
            curl_setopt($ch, CURLOPT_USERAGENT, "Android4.4.2autohome7.2.0Android");
        } else {
            curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36");
        }
        //curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:8888');

        curl_setopt($ch, CURLOPT_TIMEOUT, 60);

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_errno($ch), ' ', $url . "\n";
            return false;
        } else {
            curl_close($ch);
        }

        return $response;
    }


    public static function jsonp_decode($jsonp, $assoc = false)
    {
        $jsonp = substr($jsonp, strpos($jsonp, '('));
        return json_decode(trim($jsonp, '();'), $assoc);
    }


    //gbk转utf8
    public static function gb2utf($str)
    {
        return iconv("gb2312","utf-8//IGNORE",$str);
    }

    /**
     * utf8转换gb2312编码
     * @param $str
     * @return mixed
     */
    public static function utfgb2($str)
    {
        return iconv("utf-8","gb2312//IGNORE",$str);
    }

    /**
     * 封装设置Redis缓存
     * @param $key
     * @param $data
     * @param $expire
     */
    public static function setRedis($key,$data,$expire=0){

        //-1永不过期
        if($expire == -1){

            $jsonData =  json_encode($data);

            Redis::set($key,$jsonData);
            return;
        }
        //过期时间
        if($expire==0){

            $expire = self::$redisExpire;

        }

        $jsonData =  json_encode($data);

        Redis::setex($key,$expire, $jsonData);
    }


    /**
     * 获取Redis缓存
     * @param $key
     * @return mixed
     */
    public static function getRedis($key, $bool = false){

        $jsonData = Redis::get($key);

        return json_decode($jsonData,$bool);

    }


    //https
    public static  function getHTTPS($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_REFERER, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36");
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }


    public static function show($msg, $level = 'DEBUG')
    {
        $msg = sprintf("[%s] %s\n", $level, $msg);
        echo $msg;
    }

    /**
     *
     * Api返回数据
     * @param null $data
     * @param int $code
     * @param string $msg
     */
    public static function output($data = null, $code = 0, $msg = '', $_callback = '')
    {

        $msg = ($msg ? $msg : ($code ? self::getCodeMsg($code) : 'ok'));
        if (!is_null($data)) {
            $cnt = json_encode(array('code' => $code, 'msg' => $msg, 'data' => $data));
        } else {
            $cnt = json_encode(array('code' => $code, 'msg' => $msg, 'data' => []));
        }

        header("Content-type: application/json");
        if($_callback) {
            $cnt = $_callback . "(" . $cnt . ")";
        }
        echo $cnt;

        exit;
    }

    /**
     * 生成文章详情url
     * @param $id
     * @param $urlTime
     * @param int $is_img
     * @param string $type
     * @return string
     */
    public static function createArcUrl($id, $time,$is_img = 1, $type = 'pc', $page = 1){

        $siteUrl = $type == 'm' ? env('M_APP_URL') : env('APP_URL');

        $url = $siteUrl;
        //echo strtotime($time);exit;
        $urlTime = date('Ymd',strtotime($time));
        if($is_img == 2){
            $url = $url . '/video/'.$urlTime.'/'.$id;
        }else{
            $url = $url . '/news/'.$urlTime.'/'.$id;
        }

        if($page == 1){

            $url = $url .'.html';

        }else{

            $url = $url .'_' . $page .'.html';
        }
        return $url;
    }

    /**
     * 判断是否是手机打开
     * @return bool
     */
    public static function isMobile(){

        if(stripos($_SERVER['HTTP_USER_AGENT'],"android")!=false||stripos($_SERVER['HTTP_USER_AGENT'],"ios")!=false||stripos($_SERVER['HTTP_USER_AGENT'],"wp")!=false){

            return true;
        }

        return false;
    }

}