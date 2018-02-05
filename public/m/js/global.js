var minheight = 0;
var maxheight = 3.8;
var time = 300;
var timer = null;
var toggled = false;
 
window.onload = function() {
  var controler = document.getElementById('slide');
  var slider = document.getElementById('slider');
  var upIcon_lanmu = document.getElementById('upIcon_lanmu');
  slider.style.height = minheight + 'rem';
  var menuslide = function() {  
    clearInterval(timer);
    var instanceheight = parseInt(slider.style.height);
    var init = (new Date()).getTime();
    var height = (toggled = !toggled) ? maxheight: minheight; 
     
    var disp = height - parseInt(slider.style.height);
    timer = setInterval(function() {
      var instance = (new Date()).getTime() - init;
      if(instance < time ) {
        var pos = Math.floor(disp * instance / time);
        result = instanceheight + pos;
        slider.style.height =  result + 'rem';
      }else {
        slider.style.height = height + 'rem'; 
        clearInterval(timer);
      }
    },1);
  };
  controler.onclick = menuslide;
  //upIcon_lanmu.onclick = menuslide;
};

$(function(){
     // 菜单
 
	$(".gochannels").on("touchstart",function(e){
		$(".gochannels").addClass("on");
	});
	$("#upIcon_lanmu").on("touchstart",function(e){
        $(".gochannels").removeClass("on");
	});


})