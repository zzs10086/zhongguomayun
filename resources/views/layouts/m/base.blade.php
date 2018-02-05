<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{$title}}-中国马云</title>
    <meta name="description" content="{{$keyword}}" />
    <meta name="keywords" content="{{$description}}" />
    <link rel="stylesheet" type="text/css" href="<?php echo config('app.static_url');?>/m/css/global.css">
    <link rel="stylesheet" type="text/css" href="<?php echo config('app.static_url');?>/m/css/article.css">
    <link rel="stylesheet" type="text/css" href="<?php echo config('app.static_url');?>/m/css/dropload.css">
    <script type="text/javascript" src="<?php echo config('app.static_url');?>/m/js/zepto.min.js"></script>
    <script type="text/javascript" src="<?php echo config('app.static_url');?>/m/js/flexible.js"></script>
    <script type="text/javascript" src="<?php echo config('app.static_url');?>/m/js/flexible_css.js"></script>
    <!--<script type="text/javascript" src="<?php echo config('app.static_url');?>/m/js/global.js"></script>-->
    @yield('css')
</head>
<body>
<div class="outer">
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
                <a href="/aligushi/">阿里故事</a>
            </div>
        </div>
    </div>
    @yield('content')
</div>

<!-- jQuery1.7以上 或者 Zepto 二选一，不要同时都引用 -->
<script src="<?php echo config('app.static_url');?>/m/js/dropload.min.js"></script>
<script language="javascript">
    var category_id = {{$category_id}};
    $(function(){

        // dropload
        var dropload = $('.inner').dropload({
            domUp : {
                domClass   : 'dropload-up',
                domRefresh : '<div class="dropload-refresh">↓下拉刷新</div>',
                domUpdate  : '<div class="dropload-update">↑释放更新</div>',
                domLoad    : '<div class="dropload-load"><span class="loading"></span>加载中...</div>'
            },
            domDown : {
                domClass   : 'dropload-down',
                domRefresh : '<div class="dropload-refresh">↑上拉加载更多</div>',
                domLoad    : '<div class="dropload-load"><span class="loading"></span>加载中...</div>',
                domNoData  : '<div class="dropload-noData">暂无数据</div>'
            },
            loadUpFn : function(me){
                $.ajax({
                    type: 'GET',
                    url: '<?php echo config('app.api_app_url');?>/api/feed',
                    data:{'category_id':category_id},
                    dataType:"jsonp",
                    jsonp:"_callback",
                    success: function(data){
                        var result = '';
                        for(var i = 0; i < data.data.length; i++){
                            result +=   '<div class="newsList">'
                                    +'<div class="img">'
                                    +'<a href="'+data.data[i].url+'">'
                                    +'<img src="'+data.data[i].imgurl+'" alt="'+data.data[i].title+'">'
                                    +'</a>'
                                    +'</div>'
                                    +'<h2><a href="'+data.data[i].url+'">'+data.data[i].title+'</a></h2>'
                                    +'<div class="newsInfo">'
                                    + '<span class="time">'+data.data[i].created_at+'</span>'
                                    + '<span class="weizhi">阅读('+data.data[i].click+')</span>'
                                    +'</div>'
                                    +'</div>';
                        }
                        // 为了测试，延迟1秒加载
                        setTimeout(function(){
                            $('#result').html(result);
                            // 每次数据加载完，必须重置
                            dropload.resetload();
                        },1000);
                    },
                    error: function(xhr, type){
                        alert('Ajax error!');
                        // 即使加载出错，也得重置
                        dropload.resetload();
                    }
                });
            },
            loadDownFn : function(me){
                $.ajax({
                    type: 'GET',
                    url: '<?php echo config('app.api_app_url');?>/api/feed',
                    data:{'category_id':category_id},
                    dataType:"jsonp",
                    jsonp:"_callback",
                    success: function(data){
                        var result = '';
                        for(var i = 0; i < data.data.length; i++){
                            result +=   '<div class="newsList">'
                                    +'<div class="img">'
                                    +'<a href="'+data.data[i].url+'">'
                                    +'<img src="'+data.data[i].imgurl+'" alt="'+data.data[i].title+'">'
                                    +'</a>'
                                    +'</div>'
                                    +'<h2><a href="'+data.data[i].url+'">'+data.data[i].title+'</a></h2>'
                                    +'<div class="newsInfo">'
                                    + '<span class="time">'+data.data[i].created_at+'</span>'
                                    + '<span class="weizhi">阅读('+data.data[i].click+')</span>'
                                    +'</div>'
                                    +'</div>';
                        }
                        // 为了测试，延迟1秒加载
                        setTimeout(function(){
                            $('#result').append(result);
                            // 每次数据加载完，必须重置
                            dropload.resetload();
                        },1000);
                    },
                    error: function(xhr, type){
                        alert('Ajax error!');
                        // 即使加载出错，也得重置
                        dropload.resetload();
                    }
                });
            }
        });
    });
</script>
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
<div style="display: none;"><script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1272853601'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s13.cnzz.com/stat.php%3Fid%3D1272853601' type='text/javascript'%3E%3C/script%3E"));</script></div>
</body>
</html>