<?php use App\Lib\Util;?>
@extends('layouts.m.base')
@section('content')
<!-- 正文 -->
<div class="articleCon">
    <h1>{{$article['title']}}</h1>
    <div class="artFrom">
        <span class="a_from">{{$article['source']}}</span><span class="a_time">{{$article['created_at']}}</span>
    </div>
    <div class="artCon">
        {!! $content !!}
    </div>
</div>
<div class="page">
    <ul>
        @if($preBtn['title'])<li class="prev"><a href="{{$preBtn['url']}}">{{$preBtn['title']}}</a></li>@endif
        @if($nextBtn['title'])<li class="next"><a href="{{$nextBtn['url']}}">{{$nextBtn['title']}}</a></li>@endif
    </ul>
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
<style type="text/css">
    #SOHUCS #SOHU_MAIN .module-mobile-cmt-list .list-wrapper-wap .list-container-wap .list-item-wap .list-content-wrapper-wap .list-content-wap{
        font-size: 0.42rem;
        color: #333;
        margin-top: .25em;
        line-height: 1.916666667em;
        float: left;
        width: 100%;
        padding-right: .833333333em;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
        word-wrap: break-word;
        word-break: break-all;
    }
    #SOHUCS #SOHU_MAIN .module-mobile-cmt-list .list-wrapper-wap .list-container-wap .list-item-wap .list-content-wrapper-wap .list-content-info .list-nickname-wap {
        float: left;
        font-size: 0.42rem;
        color: #4398ed;
    }
    #SOHUCS #SOHU_MAIN .module-mobile-cmt-list .list-wrapper-wap .list-container-wap .list-item-wap .list-content-wrapper-wap .list-content-info .list-cmt-time-wap {
        float: right;
        color: #d5d5d5;
        font-size: 0.42rem;
        margin: .166666667em .083333333em 0 0;
    }
    #SOHUCS #SOHU_MAIN .module-mobile-cmt-list .list-footer-wrapper-wap .up-to-cbox .up-to-cbox-text {
        font-size: 0.42rem;
    }
    #SOHUCS #SOHU_MAIN .module-mobile-cmt-list .list-wrapper-wap .list-container-wap .list-build-wap .floor-item-wap .floor-content-wrapper-wap .floor-content-wap {
        font-size: 0.35rem;
        color: #333;
        line-height: 1.833333333em;
        margin-top: .666666667em;
        word-wrap: break-word;
        word-break: break-all;
    }
</style>
<div id="SOHUCS" sid="sohucs{{$id}}" ></div>
<script id="changyan_mobile_js" charset="utf-8" type="text/javascript"
        src="https://changyan.sohu.com/upload/mobile/wap-js/changyan_mobile.js?client_id=cyrHuPjAo&conf=prod_2b6e4633ad581f342ee4bb78f9a57081">
</script>

@stop