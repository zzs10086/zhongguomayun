<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>{{$title}}-中国马云</title>
    <meta name="description" content="{{$keyword}}" />
    <meta name="keywords" content="{{$description}}" />
    <link rel="shortcut icon" href="<?php echo config('app.static_url');?>/pc/images/favicon.ico" type="image/x-icon" />
    <link href="<?php echo config('app.static_url');?>/pc/css/style.css" rel="stylesheet" media="screen" type="text/css" />

    <meta name="mobile-agent" content="format=html5;url={{$mURL}}">

    @yield('css')
</head>
<body>
<!--toper-->
<div id="topBar" class="toper">
    <div class="tpr">
        <p class="tpr_1">做此站仅向中国骄傲Jack.Ma 马云致敬，全民偶像，我的人生导师！</p>
        <p class="tpr_2">it's never too late to believe in yourself!</p>
    </div>
</div>
<!--header-->
<div class="header">
    <div class="hd_w">
        <div class="logo"><a href="/"><img src="<?php echo config('app.static_url');?>/pc/images/logo.png" height="50" width="150" alt="中国马云"></a></div>
        <div class="nav">
            <ul>
                <li><a href="/">首页</a></li>
                <li class="line"></li>
                <li><a href="/news/">马云动态</a></li>
                <li class="line"></li>
                <li><a href="/video/">马云视频</a></li>
                <li class="line"></li>
                <li><a href="/yulu/">马云语录</a></li>
                <li class="line"></li>
                <li><a href="/alibaba/">阿里资讯</a></li>
                <li class="line"></li>
                <li><a href="/aligushi/">阿里故事</a></li>
                <li class="line"></li>
            </ul>
        </div>
    </div>
</div>
@yield('foucs')
<div class="main">
    <div class="m_left">
        @yield('content')
    </div>

    <!--right-->
    <div class="m_right">
        <div class="title-a"><h2>传奇马云</h2></div>
        <div class="index-cq">
            <div class="index-cq-cont">
                <div class="cq-photo"></div>
                <div class="cq-wrapper">
                    <div class="cq-name">阿里巴巴董事局主席：马云</div>
                    <div class="cq-info"><a href="javascript:void(0);">马云，男，1964年9月10日生于浙江省杭州市，祖籍浙江省嵊州市（原嵊县）谷来镇， 阿里巴巴集团主要创始人，现担任阿里巴巴集团董事局主席、日本软银董事、大自然保护协会中国理事会主席兼全球董事会成员、华谊兄弟董事、生命科学突破奖基金会董事。</a></div>
                </div>

            </div>
        </div>


        <div class="right-block mt10">
            <div class="title-a"><h2>马云语录</h2></div>
            <ul class="index-rank">
                <li>
                    <span class="num1">01</span>
                    <a href="javascript:void(0);">人还是要有梦想的，万一实现了呢？</a>
                </li>
                <li>
                    <span class="num2">02</span>
                    <a href="javascript:void(0);">晚上想想千条路，早上醒来走原路。</a>
                </li>
                <li>
                    <span class="num3">03</span>
                    <a href="javascript:void(0);">你穷，是因为你没有野心。</a>
                </li>
                <li>
                    <span class="num">04</span>
                    <a href="javascript:void(0);">当你成功的时候，你说的所有话都是真理。</a>
                </li>
                <li>
                    <span class="num">05</span>
                    <a href="javascript:void(0);">上当不是别人太狡猾，而是自己太贪。</a>
                </li>
                <li>
                    <span class="num">06</span>
                    <a href="javascript:void(0);">寒冷的时候，学会用自己的左手温暖右手。</a>
                </li>
                <li>
                    <span class="num">07</span>
                    <a href="javascript:void(0);">不要等到明天，明天太遥远，今天就行动。</a>
                </li>
                <li>
                    <span class="num">08</span>
                    <a href="javascript:void(0);">因为信任，所以简单。</a>
                </li>
                <li>
                    <span class="num">09</span>
                    <a href="javascript:void(0);">熬那些很苦的日子一点都不难，因为我知道它会变好。</a>
                </li>
                <li>
                    <span class="num">10</span>
                    <a href="javascript:void(0);">以前我的生活就是工作，以后我的工作就是生活。</a>
                </li>
            </ul>

        </div>

        <div class="right-block mt20">
            <div class="idx-topic"><img src="<?php echo config('app.static_url');?>/pc/images/topic.jpg" alt=""/></div>
        </div>
    </div>
    <!--right end-->
    <div id="fixedBtn">
        <a class="top" href="#topBar">向上</a>
        <a class="down" href="javascript:void(0)" onclick="$('html,body').animate({scrollTop:$(document).height()},150);">向下</a>
    </div>
</div>


<div class="footer">
    <div class="foot">

        <div class="copyright">
            <p class="mobile-hide">本站由 阿里云提供技术支持 </p>
            <p class="law">© 2017~2020 中国马云 | <a href="http://www.miitbeian.gov.cn/" rel="nofollow" target="_blank">苏ICP备16035736号-7</a> <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1272853601'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s13.cnzz.com/stat.php%3Fid%3D1272853601%26show%3Dpic1' type='text/javascript'%3E%3C/script%3E"));</script></p>

        </div>

    </div>
</div>

<script type="text/javascript" src="<?php echo config('app.static_url');?>/pc/js/jquery-1.7.2.min.js"></script>
<script>
    (function(){
        var bp = document.createElement('script');
        var curProtocol = window.location.protocol.split(':')[0];
        if (curProtocol === 'https') {
            bp.src = 'https://zz.bdstatic.com/linksubmit/push.js';
        }
        else {
            bp.src = 'http://push.zhanzhang.baidu.com/push.js';
        }
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(bp, s);
    })();
</script>
@yield('js')
</body>
</html>