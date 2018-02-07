<?php use App\Lib\Util;?>
@extends('layouts.pc.main')
@section('foucs')
    <div class="index-box">
        <div class="slide">
            <div class="FocusPic">

                <div class="lunbo" id="focus">
                    <ul>
                        @foreach($foucsNews as $k=>$v)
                        <li class="current">
                            <a href="{{Util::createArcUrl($v['id'],$v['created_at'],$v['is_img'])}}" title="{{$v['title']}}" target="_blank">
                                <img src="{{config('app.upload_url') . $v['thumb']}}" alt="{{$v['title']}}" width="745" height="340">
                                <p class="text">{{$v['title']}}</p>
                            </a>
                        </li>
                        @endforeach

                    </ul>
                </div>

            </div>
        </div>
        <div class="newpic">
            <div class="title-a"> <h2>热度排行</h2></div>
            <ul class="d1">
                @foreach($hotNews as $k=>$v)
                <li> <span class="triangle"></span><a target="_blank" href="{{Util::createArcUrl($v['id'],$v['created_at'],$v['is_img'])}}" title="{{$v['title']}}">{{$v['title']}}</a> </li>
                @endforeach
            </ul>
        </div>
    </div>
@stop

@section('content')
    <div class="title-a"><h2>精彩视频</h2></div>
    <div class="video-list">
        <ul>
            @foreach($videoNews as $k=>$v)
            <li>
                <div class="video-box">
                    <div class="pic">
                        <a href="{{Util::createArcUrl($v['id'],$v['created_at'],$v['is_img'])}}" title="{{$v['title']}}"><img src="{{config('app.upload_url') . $v['thumb']}}" alt="{{$v['title']}}"/></a>
                    </div>
                    <div class="txt">
                        <a href="{{Util::createArcUrl($v['id'],$v['created_at'],$v['is_img'])}}" title="{{$v['title']}}">{{$v['title']}}</a>
                    </div>
                </div>
            </li>
            @endforeach

        </ul>
    </div>


    <div class="title-a"><h2>最新资讯</h2></div>
    <ul class="article-list">
        @foreach($mayunNews as $k=>$v)
        <li>
            <div class="article-info">
                <div class="art-img"><a href="{{Util::createArcUrl($v['id'],$v['created_at'],$v['is_img'])}}" title="{{$v['title']}}"><img src="{{config('app.upload_url') . $v['thumb']}}" alt="{{$v['title']}}"/></a></div>
                <div class="art-info">
                    <p class="art-title"><a href="{{Util::createArcUrl($v['id'],$v['created_at']),$v['is_img']}}" target="_blank" title="{{$v['title']}}">{{$v['title']}}</a></p>
                    <p class="art-desc"><a href="{{Util::createArcUrl($v['id'],$v['created_at'],$v['is_img'])}}" target="_blank" title="{{$v['title']}}">{{$v['description']}}</a></p>
                    <p><span class="art-time">{{$v['created_at']}}</span><span>阅读({{$v['click']}})</span></p>
                </div>
            </div>
        </li>
        @endforeach

    </ul>
@stop
@section('js')
    <script type="text/javascript" src="<?php echo config('app.static_url');?>/pc/js/slide.js"></script>
    <script type="text/javascript">
        $('#focus').extend({
            speed: 1000, //动画时间
            auto: true, //自动轮播
            times: 1000, //切换时间
            mode: 3 //切换形式
        });
    </script>
@stop