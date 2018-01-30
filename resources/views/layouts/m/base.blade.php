<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{$title}}-中国马云</title>
    <meta name="description" content="{{$keyword}}" />
    <meta name="keywords" content="{{$description}}" />
    <link rel="stylesheet" type="text/css" href="<?php echo config('app.static_url');?>/m/css/global.css">
    <link rel="stylesheet" type="text/css" href="<?php echo config('app.static_url');?>/m/css/article.css">
    <script type="text/javascript" src="<?php echo config('app.static_url');?>/m/js/zepto.min.js"></script>
    <script type="text/javascript" src="<?php echo config('app.static_url');?>/m/js/flexible.js"></script>
    <script type="text/javascript" src="<?php echo config('app.static_url');?>/m/js/flexible_css.js"></script>
    <script type="text/javascript" src="<?php echo config('app.static_url');?>/m/js/global.js"></script>
    @yield('css')
</head>
<body>
<header class="header">
    <div class="nav">
        <div class="header-left">
            <a href="javascript:window.history.back();"><i class="icon-back"></i></a>
        </div>
        <span class="classif_name">{{$current}}</span>
			<span class="menuIcon">
				<span class="gochannels" id="slide"></span>
			</span>
    </div>
</header>
<!-- menuAdd -->
<div class="all_lanmu" id="slider">
    <div class="all_lanmu_first_line">
        <span class="all_lanmu_first_line_span_all">所有栏目</span>
    </div>
    <div class="all_lanmu_content">
        <div class="all_lanmu_line">
            <a href="/">首页</a>
            <a href="/news/">资讯</a>
            <a href="/video/">视频</a>
            <a href="/yulu/">语录</a>
            <a href="/alibaba/">阿里资讯</a>
        </div>
    </div>
</div>
@yield('content')
</body>
</html>