<?php use App\Lib\Util;?>
@extends('layouts.pc.main')
@section('content')
    <div class="title-a"><h2>马云动态</h2></div>
    <ul class="article-list">
        @foreach($list as $k=>$v)
        <li>
            <div class="article-info">
                <div class="art-img"><a href="{{Util::createArcUrl($v['id'],$v['addtime'],$v['is_img'])}}" title="{{$v['title']}}"><img src="{{config('app.upload_url') . $v['thumb']}}" alt="{{$v['title']}}"/></a></div>
                <div class="art-info">
                    <p class="art-title"><a href="{{Util::createArcUrl($v['id'],$v['addtime'],$v['is_img'])}}" target="_blank" title="{{$v['title']}}">{{$v['title']}}</a></p>
                    <p class="art-desc"><a href="{{Util::createArcUrl($v['id'],$v['addtime'],$v['is_img'])}}" target="_blank" title="{{$v['title']}}">{{$v['description']}}</a></p>
                    <p><span class="art-time">{{date('Y年m月d日',$v['addtime'])}}</span><span>阅读({{$v['click']}})</span></p>
                </div>
            </div>
        </li>
        @endforeach

    </ul>

    <!-- 分页 -->
    <div style="background-color: #fff; padding: 20px 0px;">
        <div class="page_area clearfix">
            {!! $paginate !!}
        </div>
    </div>

    <!--con END-->
@stop