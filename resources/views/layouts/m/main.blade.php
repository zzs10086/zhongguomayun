<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{$title}}-中国马云</title>
    <meta name="description" content="{{$keyword}}" />
    <meta name="keywords" content="{{$description}}" />
    <link rel="stylesheet" type="text/css" href="<?php echo config('app.static_url');?>/m/css/global.css">
    <link rel="stylesheet" type="text/css" href="<?php echo config('app.static_url');?>/m/css/index.css">
    <script type="text/javascript" src="<?php echo config('app.static_url');?>/m/js/zepto.min.js"></script>
    <script type="text/javascript" src="<?php echo config('app.static_url');?>/m/js/flexible.js"></script>
    <script type="text/javascript" src="<?php echo config('app.static_url');?>/m/js/flexible_css.js"></script>
    <script type="text/javascript" src="<?php echo config('app.static_url');?>/m/js/TouchSlide.js"></script>
    <script type="text/javascript" src="<?php echo config('app.static_url');?>/m/js/global.js"></script>
    @yield('css')
</head>
<body>
<header class="header">
    <div class="nav">
        <span class="logo"><img src="<?php echo config('app.static_url');?>/m/images/logo.png"></span>
    </div>
</header>
<div class="menu">
    <ul>
        <li><a href="/">首页</a></li>
        <li><a href="/news/">资讯</a></li>
        <li><a href="/video/">视频</a></li>
        <li><a href="/yulu/">语录</a></li>
        <li><a href="/alibaba/">阿里资讯</a></li>
        <li><a href="/aligushi/">阿里故事</a></li>
    </ul>
</div>

@yield('content')
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
</body>
</html>