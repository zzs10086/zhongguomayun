<?php use App\Lib\Util;?>
@extends('layouts.pc.base')
@section('content')
    <form action="" method="get">
        <div class="sear-place">
                <div class="sear-input"><input type="text" name="keywords" id="keywords" value="" placeholder="请输入关键词" class="sear-keywords"></div>
                <div class="sear-btn"><a href="javascript:void(0);" id="btnSearch">搜索</a></div>
        </div>
    </form>
    <script language="JavaScript">
        $("#btnSearch").click(function () {
            var keywords = $.trim($("#keywords").val());
            var len = keywords.length;

            if(keywords != ''){
                if(len<2){
                    alert('请输入至少2个字关键词');
                    $("#keywords").focus();
                    return;
                }
                var searchUrl = '<?php echo config('app.url')."/search/";?>';

                window.location.href =  searchUrl+ keywords ;
            }else{
                alert('请输入搜索关键词');
                $("#keywords").focus();
            }
        })
    </script>
@stop