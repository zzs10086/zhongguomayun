<?php use App\Lib\Util;?>
@extends('layouts.pc.main')
@section('content')
    <div class="title-a"><h2>{{$current}}</h2></div>
    <div class="video-list">
        <ul>
            @foreach($list as $k=>$v)
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

    <!-- 分页 -->
    <div style="background-color: #fff; padding: 20px 0px;">
        <div class="page_area clearfix">
            {!! $paginate !!}
        </div>
    </div>

    <!--con END-->
@stop