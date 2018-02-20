<?php use App\Lib\Util;?>
@extends('layouts.pc.main')
@section('content')
    <div class="title-a"><h2>马云语录</h2></div>
    <ul class="yulu-list">
        @foreach($list as $k=>$v)
            <li>
                <div class="yulu-info">
                    <div class="yulu-title"><a href="javascript:void(0);">{{$v['title']}}</a></div>
                    <div class="yulu-biao">
                        <span class="p1">喜欢({{$v['click']}})</span>
                        <span class="p2">评论({{$v['click']}})</span>
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