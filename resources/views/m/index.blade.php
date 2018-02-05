<?php use App\Lib\Util;?>
@extends('layouts.m.main')
@section('content')
<!-- slide -->
<div id="slideBox" class="slideBox">
    <div class="bd">
        <ul>
            @foreach($foucsNews as $k=>$v)
            <li>
                <a class="pic" href="{{Util::createArcUrl($v['id'],$v['created_at'],$v['is_img'],'m')}}"><img src="{{config('app.upload_url') . $v['thumb']}}" alt="{{$v['title']}}"/></a>
                <a class="tit" href="{{Util::createArcUrl($v['id'],$v['created_at'],$v['is_img'],'m')}}">{{$v['title']}}</a>
            </li>
            @endforeach
        </ul>
    </div>
</div>
<script type="text/javascript">
    TouchSlide({
        slideCell:"#slideBox",
        titCell:".hd ul",
        mainCell:".bd ul",
        effect:"leftLoop",
        autoPage:false,
        autoPlay:true
    });
</script>
<!-- end -->
<!-- 热门文章 -->
<div class="news inner">
    <div id="result">
       {{-- @foreach($list as $k=>$v)
        <div class="newsList">
            @if($v['catid'] != 3)
            <div class="img">
                <a href="{{Util::createArcUrl($v['id'],$v['created_at'],$v['is_img'],'m')}}">
                    <img src="{{config('app.upload_url') . $v['thumb']}}" alt="{{$v['title']}}">
                </a>
            </div>
            @endif
            <h2>
                <a href="{{Util::createArcUrl($v['id'],$v['created_at'],$v['is_img'],'m')}}" title="{{$v['title']}}">{{$v['title']}}</a>
            </h2>
            <div class="newsInfo">
                <span class="time">{{$v['created_at']}}</span>
                <span class="weizhi">阅读({{$v['click']}})</span>

            </div>
        </div>
        @endforeach--}}

    </div>
</div>
<!-- end -->
@stop