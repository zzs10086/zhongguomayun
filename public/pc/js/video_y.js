$(function(){
    var id = $('.bui-zan').data('aid');
    var cookid_like_key = 'video_like_'+id;
    var cookid_bad_key = 'video_bad_'+id;
    //点赞
    if($.cookie(cookid_like_key)){
        $("#praise_txt").addClass("hover");
        $(".good i").addClass("active");
    }
    //踩
    if($.cookie(cookid_bad_key)){
        $("#belittle_txt").addClass("hover");
        $(".bad i").addClass("active");
    }


	// 动态点赞
	$(".good i").click(function(){

        if($.cookie(cookid_like_key)){
            alert('您已经点赞过了');
            return false;
        }
		var text_box = $("#add_num");
		var praise_txt = $("#praise_txt");
		var num=parseInt(praise_txt.text());
        praise_txt.addClass("hover");

        $.cookie(cookid_like_key, num);

        $(this).addClass("active");
        text_box.show().html("<em class='add_animation'>+1</em>");
        $(".add_animation").addClass("hover");
        num +=1;
		praise_txt.text(num);
        $.ajax({
            'type':'post',
            'url': '/api/agree',
            'data':{'id':id, 'field' : 0},
            'dataType':'json',
            success:function(data){

            },
            error:function(){
            }
        });
	});
    $(".bad i").click(function(){

        if($.cookie(cookid_bad_key)){
            alert('您已经踩过了');
            return false;
        }

		var belittle_txt = $("#belittle_txt");
		var num2=parseInt(belittle_txt.text());
        belittle_txt.addClass("hover");

        $.cookie(cookid_bad_key, num2);

        $(this).addClass("active");
        $(".add_animation").addClass("hover");
        num2 +=1;
		belittle_txt.text(num2);

        $.ajax({
            'type':'post',
            'url': '/api/agree',
            'data':{'id':id, 'field' : 1},
            'dataType':'json',
            success:function(data){

            },
            error:function(){
            }
        });
	});

})