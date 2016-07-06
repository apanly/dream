;
var common_ops = {
    getHostUrl:function( path ){
        var access_domain = $("#access_domain").val();
        return access_domain + path;
    },
    getUrlPrefix: function () {
        var pathname = window.location.pathname;
        if( pathname.indexOf("/wap") > -1 ){
            return "/wap"
        }
        return "";
    },
    buildWapUrl:function( path ,params){
        var pathname = window.location.pathname;
        var prefix = "";
        if( pathname.indexOf("/wap") > -1 ){
            prefix =  "/wap"
        }
        var url =  prefix +  path;
        var _paramUrl = '';
        if( params ){
            _paramUrl = Object.keys(params).map(function(k) {
                return [encodeURIComponent(k), encodeURIComponent(params[k])].join("=");
            }).join('&');
            _paramUrl = "?"+_paramUrl;
        }
        return url+_paramUrl

    },
    setCurrentNav: function () {
        var pathname = window.location.pathname;

        idx = 1;

        if (pathname.indexOf("/library") > -1) {
            idx = 2;
        }

        if ( pathname.indexOf("/richmedia") > -1 || pathname.indexOf("/gallery") > -1) {
            idx = 3;
        }

        if (pathname == "/my/about") {
            idx = 4;
        }

        if (pathname == "/my/wechat") {
            idx = 5;
        }


        if (idx < 1) {

            return;
        }

        var target = $($(".am-navbar a").get(idx - 1));
        target.addClass("am-btn-primary");
    },
    getRequest: function () {
        var url = location.search; //获取url中"?"符后的字串
        var theRequest = new Object();
        if (url.indexOf("?") != -1) {
            var str = url.substr(1);
            strs = str.split("&");
            for (var i = 0; i < strs.length; i++) {
                theRequest[strs[i].split("=")[0]] = unescape(strs[i].split("=")[1]);
            }
        }
        return theRequest;
    }
};
$(document).ready(function () {
    common_ops.setCurrentNav();
});