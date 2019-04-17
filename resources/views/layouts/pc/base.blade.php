<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>{{$title}}-马云导师</title>
    <meta name="keywords" content="{{$keyword}}" />
    <meta name="description" content="{{$description}}" />
    <link rel="shortcut icon" href="<?php echo config('app.static_url');?>/pc/images/favicon.ico" type="image/x-icon" />
    <link href="<?php echo config('app.static_url');?>/pc/css/style.css" rel="stylesheet" media="screen" type="text/css" />
    @yield('css')
    <meta name="mobile-agent" content="format=html5;url={{$mURL}}">
    <script type="text/javascript" src="<?php echo config('app.static_url');?>/pc/js/jquery-1.7.2.min.js"></script>
    <script>
        var _hmt = _hmt || [];
        (function() {
            var hm = document.createElement("script");
            hm.src = "https://hm.baidu.com/hm.js?06227904dbbec6c3cc72a920671caff3";
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(hm, s);
        })();
    </script>
</head>
<body>
<!--toper-->
<div id="topBar" class="toper">
    <div class="tpr">
        <p class="tpr_1">做此站仅向中国骄傲Jack Ma 马云致敬，全民偶像，我的人生导师！</p>
        <p class="tpr_2">it's never too late to believe in yourself!</p>
    </div>
</div>
<!--header-->
<div class="header">
    <div class="hd_w">
        <div class="logo"><a href="/"><img src="<?php echo config('app.static_url');?>/pc/images/logo.png" height="50" width="150" alt="中国马云"></a></div>
        <div class="nav">
            <ul>
                <li><a href="/"  @if($currentClass == 'index')class="current"@endif>首页</a></li>
                <li class="line"></li>
                <li><a href="/news/" @if($currentClass == 'news')class="current"@endif>马云动态</a></li>
                <li class="line"></li>
                <li><a href="/video/" @if($currentClass == 'video')class="current"@endif>马云视频</a></li>
                <li class="line"></li>
                <li><a href="/yulu/" @if($currentClass == 'yulu')class="current"@endif>马云语录</a></li>
                <li class="line"></li>
                <li><a href="/alibaba/" @if($currentClass == 'alibaba')class="current"@endif>阿里资讯</a></li>
                <li class="line"></li>
                <li><a href="/aligushi/" @if($currentClass == 'aligushi')class="current"@endif>阿里故事</a></li>
                <li class="line"></li>
                <li><a href="/search/" class="red">全站搜索</a></li>
                <li class="line"></li>
            </ul>
        </div>
    </div>
</div>
@yield('foucs')
<div class="main">
    @yield('content')
</div>


<div class="footer">
    <div class="foot">

        <div class="copyright">
            <p class="mobile-hide">本站由 阿里云提供技术支持 </p>
            <p class="law">© 2017~2020 马云导师 | <a href="http://www.miitbeian.gov.cn/" rel="nofollow" target="_blank">苏ICP备16035736号-7</a> <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1272853601'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s13.cnzz.com/stat.php%3Fid%3D1272853601%26show%3Dpic1' type='text/javascript'%3E%3C/script%3E"));</script><script type="text/javascript" src="//js.users.51.la/19714627.js"></script></p>

        </div>

    </div>
</div>


<script type="text/javascript" src="<?php echo config('app.static_url');?>/pc/js/global.js"></script>
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