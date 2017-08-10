$(function() {
$(document).pjax('a[target!=_blank]', '.pjax', {fragment:'.pjax', timeout:6000}); //这是a标签的pjax。#content 表示执行pjax后会发生变化的id，改成你主题的内容主体id或class。timeout是pjax响应时间限制，如果在设定时间内未响应就执行页面转跳，可自由设置。
$(document).on('submit', 'form', function (event) {$.pjax.submit(event, '.pjax', {fragment:'.pjax', timeout:6000});}); //这是提交表单的pjax。form表示所有的提交表单都会执行pjax，比如搜索和提交评论，可自行修改改成你想要执行pjax的form id或class。#content 同上改成你主题的内容主体id或class。
    $(document).on('pjax:send', function() {
         $('html').toggleClass('load');//参考的loading动画代码
          //执行pjax开始，在这里添加要重载的代码，可自行添加loading动画代码。例如你已调用了NProgress，在这里添加 NProgress.start();
          });
    $(document).on('pjax:complete', function() {
         $('html').toggleClass('load');//参考的loading动画代码
          //执行pjax结束，在这里添加要重载的代码，可自行添加loading动画结束或隐藏代码。例如NProgress的结束代码 NProgress.done();
//灯箱
	jQuery(document).ready(function () {
        jQuery.viewImage({
            'target' : '.echolog img,#pic-wall .pici a img', //需要使用ViewImage的图片
            'exclude': '.exclude img',    //要排除的图片
            'delay'  : 300                //延迟时间
        });
    });

$('.icon-menu').click(function(){
	$(".header").slideToggle();
});

          });
});

$(document).ready(function(){
$('.icon-menu').click(function(){
	$(".header").slideToggle();
});
});
//灯箱
	jQuery(document).ready(function () {
        jQuery.viewImage({
            'target' : '.echolog img,#pic-wall .pici a img', //需要使用ViewImage的图片
            'exclude': '.exclude img',    //要排除的图片
            'delay'  : 300                //延迟时间
        });
    });
	

//返回顶部
$('.back2top').click(function(){$('html,body').animate({scrollTop: '0px'}, 1000);});
    $(window).scroll(function(){
        $(window).scrollTop()>10?$('.back2top').css('display','block'):$('.back2top').css('display','none');
    });



// <![CDATA[
    jQuery(document).ready(function() {
    	function d() {
    		document.title = document[b] ? "(´･_･) 不喜欢人家啦？！" : a
    	}
    	var b, c, a = document.title;
    	"undefined" != typeof document.hidden ? (b = "hidden", c = "visibilitychange") : "undefined" != typeof document.mozHidden ? (b = "mozHidden", c = "mozvisibilitychange") : "undefined" != typeof document.webkitHidden && (b = "webkitHidden", c = "webkitvisibilitychange"), ("undefined" != typeof document.addEventListener || "undefined" != typeof document[b]) && document.addEventListener(c, d, !1)
    });
    
// ]]>


