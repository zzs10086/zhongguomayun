<?php use App\Lib\Util;?>
@extends('layouts.pc.main')
@section('content')
    <div class="a-content mt10">
        <div class="a-title">
            <h2>{{$article['title']}}</h2>
            <div class="a-time"><svg width="1em" height="1em" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" class="meta-item__icon icon" style="font-size:14px;color:#999999;margin-right:6px;" data-v-849552ce=""><path d="M512 0C229.232 0 0 229.232 0 512s229.232 512 512 512 512-229.232 512-512S794.768 0 512 0zm0 960C264.976 960 64 759.024 64 512S264.976 64 512 64s448 200.976 448 448-200.976 448-448 448zm246.72-346.496L531.888 510.4V225.872c0-17.68-14.336-32-32-32s-32 14.32-32 32v305.12a31.944 31.944 0 0 0 18.768 29.12l245.6 111.632a31.577 31.577 0 0 0 13.216 2.88c12.16 0 23.776-6.976 29.136-18.752 7.312-16.096.208-35.056-15.888-42.368z"></path></svg>{{date('Y-m-d H:i:s',$article['addtime'])}}</div>
            <div class="a-read"><svg width="1em" height="1em" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" class="meta-item__icon icon" style="font-size:14px;color:#999999;margin-right:6px;" data-v-849552ce=""><path d="M0 0h1024v837.818H698.182L512 1024 325.818 837.818H0V0zm93.09 93.09v651.637h279.274L512 884.364l139.636-139.637H930.91V93.091H93.091zm186.183 186.183h465.454v93.09H279.273v-93.09zm0 186.182h465.454v93.09H279.273v-93.09z"></path></svg> {{$article['click']}}</div>
        </div>
        <div class="a-cont">
            <div class="a-desc">
                <blockquote>
                    <p>{{$article['description']}}</p>
                </blockquote>
            </div>
            <div class="show-content">
                {{$content}}
            </div>

            @if($count > 1)
            <!-- 分页 -->
            <div class="page_area clearfix">
                {!! $paginate !!}
            </div>
            @endif
            <!--con END-->
            <!--相关文章-->
            <div class="a-relevant">
                <div class="title-a"><h2>相关文章</h2></div>
                <ul>
                    <li>
                        <div class="a-article-info">
                            <div class="a-art-img"><a href=""><img src="http://n.sinaimg.cn/tech/transform/w630h419/20171203/BP8B-fypikwt4922958.jpg" alt="贾跃亭回应北京证监局：尽责到底，但不回国"/></a></div>
                            <div class="a-art-info">
                                <p class="a-art-title"><a href="" target="_blank" title="贾跃亭回应北京证监局：尽责到底，但不回国">贾跃亭回应北京证监局：尽责到底，但不回国</a></p>
                                <p class="a-art-desc"><a href="" target="_blank" title="贾跃亭回应北京证监局：尽责到底，但不回国">这就是你应该知道的。在本文中，我将探讨它对利用投机资金进行交易意味着什么。我还将会讲解向经纪商入金时使自己放心的两种方式，无论你的入金金额有多大</a></p>
                                <p><span class="a-art-time">2018年01月01日</span><span>阅读(196)</span></p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="a-article-info">
                            <div class="a-art-img"><a href=""><img src="http://n.sinaimg.cn/tech/transform/w630h419/20171203/BP8B-fypikwt4922958.jpg" alt=""/></a></div>
                            <div class="a-art-info">
                                <p class="a-art-title"><a href="" target="_blank" title="贾跃亭回应北京证监局：尽责到底，但不回国">贾跃亭回应北京证监局：尽责到底，但不回国</a></p>
                                <p class="a-art-desc"><a href="" target="_blank" title="贾跃亭回应北京证监局：尽责到底，但不回国">这就是你应该知道的。在本文中，我将探讨它对利用投机资金进行交易意味着什么。我还将会讲解向经纪商入金时使自己放心的两种方式，无论你的入金金额有多大</a></p>
                                <p><span class="a-art-time">2018年01月01日</span><span>阅读(196)</span></p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="a-article-info">
                            <div class="a-art-img"><a href=""><img src="http://n.sinaimg.cn/tech/transform/w630h419/20171203/BP8B-fypikwt4922958.jpg" alt=""/></a></div>
                            <div class="a-art-info">
                                <p class="a-art-title"><a href="" target="_blank" title="贾跃亭回应北京证监局：尽责到底，但不回国">贾跃亭回应北京证监局：尽责到底，但不回国</a></p>
                                <p class="a-art-desc"><a href="" target="_blank" title="贾跃亭回应北京证监局：尽责到底，但不回国">这就是你应该知道的。在本文中，我将探讨它对利用投机资金进行交易意味着什么。我还将会讲解向经纪商入金时使自己放心的两种方式，无论你的入金金额有多大</a></p>
                                <p><span class="a-art-time">2018年01月01日</span><span>阅读(196)</span></p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="a-article-info">
                            <div class="a-art-img"><a href=""><img src="http://n.sinaimg.cn/tech/transform/w630h419/20171203/BP8B-fypikwt4922958.jpg" alt=""/></a></div>
                            <div class="a-art-info">
                                <p class="a-art-title"><a href="" target="_blank" title="贾跃亭回应北京证监局：尽责到底，但不回国">贾跃亭回应北京证监局：尽责到底，但不回国</a></p>
                                <p class="a-art-desc"><a href="" target="_blank" title="贾跃亭回应北京证监局：尽责到底，但不回国">这就是你应该知道的。在本文中，我将探讨它对利用投机资金进行交易意味着什么。我还将会讲解向经纪商入金时使自己放心的两种方式，无论你的入金金额有多大</a></p>
                                <p><span class="a-art-time">2018年01月01日</span><span>阅读(196)</span></p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="a-article-info">
                            <div class="a-art-img"><a href=""><img src="http://n.sinaimg.cn/tech/transform/w630h419/20171203/BP8B-fypikwt4922958.jpg" alt=""/></a></div>
                            <div class="a-art-info">
                                <p class="a-art-title"><a href="" target="_blank" title="贾跃亭回应北京证监局：尽责到底，但不回国">贾跃亭回应北京证监局：尽责到底，但不回国</a></p>
                                <p class="a-art-desc"><a href="" target="_blank" title="贾跃亭回应北京证监局：尽责到底，但不回国">这就是你应该知道的。在本文中，我将探讨它对利用投机资金进行交易意味着什么。我还将会讲解向经纪商入金时使自己放心的两种方式，无论你的入金金额有多大</a></p>
                                <p><span class="a-art-time">2018年01月01日</span><span>阅读(196)</span></p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

        </div>
    </div>
@stop