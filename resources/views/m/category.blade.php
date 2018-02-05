<?php use App\Lib\Util;?>
@extends('layouts.m.base')
@section('content')
 <!-- list -->
<div class="news inner">
    <div id="result">

    </div>
</div>
<!-- end -->
<!-- jQuery1.7以上 或者 Zepto 二选一，不要同时都引用 -->
<script src="<?php echo config('app.static_url');?>/m/js/dropload.min.js"></script>
<script language="javascript">

    var page = 0;
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
                    data:{'category_id':category_id, 'page':page},
                    dataType:"jsonp",
                    jsonp:"_callback",
                    success: function(data){
                        var result = '';
                        for(var i = 0; i < data.data.length; i++){
                            if(data.data[i].catid == 3){

                                result +=   '<div class="newsList">'
                                        +'<h2><a href="'+data.data[i].url+'">'+data.data[i].title+'</a></h2>'
                                        +'<div class="newsInfo">'
                                        + '<span class="time">'+data.data[i].created_at+'</span>'
                                        + '<span class="weizhi">阅读('+data.data[i].click+')</span>'
                                        +'</div>'
                                        +'</div>';
                            }else{

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
                page++;
                $.ajax({
                    type: 'GET',
                    url: '<?php echo config('app.api_app_url');?>/api/feed',
                    data:{'category_id':category_id, 'page':page},
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
@stop