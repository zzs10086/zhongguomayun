<?php use App\Lib\Util;?>
@extends('layouts.pc.main')
@section('css')
    <link href="<?php echo config('app.static_url');?>/pc/css/video.css" rel="stylesheet" media="screen" type="text/css" />
@stop
@section('content')
<div class="a-content mt10">
    <div class="a-title">
        <h1>{{$article['title']}}</h1>
        <div class="a-time"><svg width="1em" height="1em" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" class="meta-item__icon icon" style="font-size:14px;color:#999999;margin-right:6px;" data-v-849552ce=""><path d="M512 0C229.232 0 0 229.232 0 512s229.232 512 512 512 512-229.232 512-512S794.768 0 512 0zm0 960C264.976 960 64 759.024 64 512S264.976 64 512 64s448 200.976 448 448-200.976 448-448 448zm246.72-346.496L531.888 510.4V225.872c0-17.68-14.336-32-32-32s-32 14.32-32 32v305.12a31.944 31.944 0 0 0 18.768 29.12l245.6 111.632a31.577 31.577 0 0 0 13.216 2.88c12.16 0 23.776-6.976 29.136-18.752 7.312-16.096.208-35.056-15.888-42.368z"></path></svg>{{$article['created_at']}}</div>
        <div class="a-read"><svg width="1em" height="1em" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" class="meta-item__icon icon" style="font-size:14px;color:#999999;margin-right:6px;" data-v-849552ce=""><path d="M0 0h1024v837.818H698.182L512 1024 325.818 837.818H0V0zm93.09 93.09v651.637h279.274L512 884.364l139.636-139.637H930.91V93.091H93.091zm186.183 186.183h465.454v93.09H279.273v-93.09zm0 186.182h465.454v93.09H279.273v-93.09z"></path></svg> {{$click}}</div>
    </div>
    <div class="a-cont">
        <div class="a-desc">
            <blockquote>
                <p>{{$article['description']}}</p>
            </blockquote>
        </div>
        <div class="show-content">
            <!--中间内容 START-->
            <div class="fl center_video">
                <div class="tt_video">
                    <video id="my-video" class="video-js vjs-big-play-centered" controls preload="auto" width="780" height="450"
                           data-setup="{}">
                        <source src="{{$article['video_url']}}" type="video/mp4">
                    </video>
                    <script src="<?php echo config('app.static_url');?>/pc/js/video.min.js"></script>
                    <script type="text/javascript">
                        //自动播放
                       /* var myPlayer = videojs('my-video');
                        videojs("my-video").ready(function(){
                            var myPlayer = this;
                            myPlayer.play();
                        });*/
                    </script>
                </div>
                <div class="share_video">
                    <div class="snsbox clearfix">
                        <span class="snsbox-share">分享到：</span>
                        <div  data-bd-bind="1431498273755" class="share_to bdsharebuttonbox bdshare-button-style0-16" >
                            <a title="分享到新浪微博" href="#" class="bds_tsina" data-cmd="tsina"></a>
                            <a title="分享到微信" href="#" class="bds_weixin" data-cmd="weixin"></a>
                            <a title="分享到QQ空间" href="#" class="bds_qzone" data-cmd="qzone"></a>
                        </div>
                    </div>
                    <script>
                        window._bd_share_config = {
                            "common": {
                                "bdSnsKey": {},
                                "bdText": "",
                                "bdMini": "2",
                                "bdPic": "",
                                "bdStyle": "0",
                                "bdSize": "16"
                            },
                            "share": {},
                            "selectShare": {
                                "bdContainerClass": null,
                                "bdSelectMiniList": ["qzone", "tsina", "tqq", "renren", "weixin"]
                            }
                        };
                        with (document)
                            0[(getElementsByTagName('head')[0] || body).appendChild(createElement('script')).src = 'http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion=' + ~(-new Date() / 36e5)];
                    </script>
                    <div class="bui-zan">
                    <span class="good">
                        <span id="praise_txt">143</span>
                        <i></i>
                        <span id="add_num"><em>+1</em></span>
                    </span>
                    <span class="bad">
                        <span id="belittle_txt">43</span>
                        <i></i>
                    </span>
                    <span class="collect" onclick="addFavorite(this);">
                        <span>收藏</span>
                        <i></i>
                    </span>
                    </div>
                </div>
                <div class="videoTit_h2">
                    <h2>{{$article['title']}}</h2>
                    <div class="mb20 clearfix">
                        <div class="info fl">
                            <i class="fromIcon">
                                <img src="<?php echo config('app.static_url');?>/pc/images/logo.png" alt="头像">
                            </i>
                            <span class="name">中国马云</span>
                        </div>
                        <div class="boNum fr">
                            <em>{{$article['click']}}</em>次播放
                        </div>
                    </div>
                </div>


            </div>
            <!--中间内容 END-->
        </div>

        <div class="clear"></div>
        <!--相关文章-->
        <div class="a-hotvideo">
            <div class="title-a"><h2>热门视频</h2></div>
            <div class="htvideo">
                <ul>
                    @foreach($hotVideo as $k=>$v)
                    <li>
                        <a href="{{Util::createArcUrl($v['id'],$v['created_at'],$v['is_img'])}}" target="_blank" class="vitem" title="{{$v['title']}}">
                            <img src="{{config('app.upload_url') . $v['thumb']}}">
                                    <span class="v-duration">
                                        <i></i>
                                    </span>
                        </a>
                        <a href="{{Util::createArcUrl($v['id'],$v['created_at'],$v['is_img'])}}" target="_blank" class="vTit" title="{{$v['title']}}">{{$v['title']}}</a>
                    </li>
                    @endforeach

                </ul>
            </div>

        </div>
        <!--相关文章-->
        @if($relevant)
        <div class="a-relevant">
            <div class="title-a"><h2>更多视频</h2></div>
            <ul>
                @foreach($relevant as $k=>$v)
                    <li>
                        <div class="a-article-info">
                            <div class="a-art-img"><a href="{{Util::createArcUrl($v['id'],$v['created_at'],$v['is_img'])}}"><img src="{{config('app.upload_url') . $v['thumb']}}" alt="{{$v['title']}}"/></a></div>
                            <div class="a-art-info">
                                <p class="a-art-title"><a href="{{Util::createArcUrl($v['id'],$v['created_at'],$v['is_img'])}}" target="_blank" title="{{$v['title']}}">{{$v['title']}}</a></p>
                                <p class="a-art-desc"><a href="{{Util::createArcUrl($v['id'],$v['created_at'],$v['is_img'])}}" target="_blank" title="{{$v['title']}}">{{$v['description']}}</a></p>
                                <p><span class="a-art-time">{{$v['created_at']}}</span><span>阅读({{$v['click']}})</span></p>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        @endif

    </div>
</div>
@stop