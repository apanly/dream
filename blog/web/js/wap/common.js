;
var common_ops = {
    getUrlPrefix:function(){
        return "/wap";
    },
    setCurrentNav:function(){
        var pathname = window.location.pathname;

        idx = 0 ;
        if( pathname.indexOf("/wap/default") > -1 ){
            idx = 1;
        }

        if( pathname.indexOf("/wap/library") > -1 ){
            idx = 2;
        }

        if( pathname.indexOf("/wap/richmedia") > -1 ){
            idx = 3;
        }

        if( idx < 1 ){
            return;
        }

        var target = $( $(".am-navbar a").get(idx - 1) );
        target.addClass("am-btn-success");
    },
    getRequest:function() {
        var url = location.search; //获取url中"?"符后的字串
        var theRequest = new Object();
        if (url.indexOf("?") != -1) {
            var str = url.substr(1);
            strs = str.split("&");
            for(var i = 0; i < strs.length; i ++) {
                theRequest[strs[i].split("=")[0]]=unescape(strs[i].split("=")[1]);
            }
        }
        return theRequest;
    }
};
$(document).ready(function(){
    common_ops.setCurrentNav();
});