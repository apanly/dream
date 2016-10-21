;
/*
统计页面访问情况，为什么用JS，两个原因
第一：不在php端做为了加快页面访问速度
第二：对于脚本访问呢也不想要了
*/
var access_ops = {
    init:function(){
        access_ops.postLog();
    },
    postLog:function(){
        var access_domain = $("#access_domain").val();
        if( access_domain == undefined ){
            return;
        }
        var referer = document.referrer;
        $.ajax(access_domain + "log/add", {
            data: {
                'referer': referer,
                '_': new Date().getTime(),
                'screen': $(window).width() + "/"  + $(window).height()
            },
            dataType: 'jsonp',

            crossDomain: true,
            success: function(data) {
            }
        });
    }
};
$(document).ready(function(){
    access_ops.init();

    window.onerror = function(message, url, lineNumber,columnNo,error) {
        var data = {
            'message':message,
            'url':url,
            'error':error.stack
        };
        var access_domain = $("#access_domain").val();
        if( access_domain == undefined ){
            return;
        }
        $.ajax({
            url:access_domain + "/error/capture",
            type:'post',
            data:data,
            success:function(){

            }
        });
        return true;
    };
});