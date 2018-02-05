<?php use App\Lib\Util;?>
@extends('layouts.m.base')
@section('css')
    <link rel="stylesheet" type="text/css" href="<?php echo env('APP_STATIC_URL');?>/m/css/video.css">
@stop
@section('content')
<!-- video -->
<div class="y_video">
    <video id="my-video" class="video-js vjs-big-play-centered" controls preload="auto"  data-setup="{}">
        <source src="{{$article['video_url']}}" type="video/mp4">
    </video>
    <script src="<?php echo env('APP_STATIC_URL');?>/m/js/video.min.js"></script>
    <script type="text/javascript">
        //自动播放
       /* var myPlayer = videojs('my-video');
        videojs("my-video").ready(function(){
            var myPlayer = this;
            myPlayer.play();
        });*/
    </script>
</div>
<!-- end -->
<!-- 推荐阅读 -->
<div class="newTit">
    <span>推荐阅读</span>
</div>
<div class="news">
    <div id="result">
        @foreach($relevant as $k=>$v)
            <div class="newsList">
                @if($v['catid'] != 3)
                    <div class="img">
                        <a href="{{Util::createArcUrl($v['id'],$v['created_at'],$v['is_img'],'m')}}" target="_blank">
                            <img src="{{config('app.upload_url') . $v['thumb']}}" alt="{{$v['title']}}">
                        </a>
                    </div>
                @endif
                <h2>
                    <a href="{{Util::createArcUrl($v['id'],$v['created_at'],$v['is_img'],'m')}}" title="{{$v['title']}}">{{$v['title']}}</a>
                </h2>
                <div class="newsInfo">
                    <span class="weizhi">{{date('Y-m-d',strtotime($v['created_at']))}}</span>
                    <span class="time">阅读({{$v['click']}})</span>
                </div>
            </div>
        @endforeach
    </div>
</div>
<!-- end -->
    <!-- 畅言评论 -->
    <div class="chanyanTit">
        <span>热门评论</span>
    </div>
    <!--WAP版-->
    <div id="SOHUCS" sid="sohucs{{$id}}" ></div>
    <script id="changyan_mobile_js" charset="utf-8" type="text/javascript"
            src="https://changyan.sohu.com/upload/mobile/wap-js/changyan_mobile.js?client_id=cyrHuPjAo&conf=prod_2b6e4633ad581f342ee4bb78f9a57081">
    </script>
@stop