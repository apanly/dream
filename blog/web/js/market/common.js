;
var common_ops = {
    init:function(){
        this.setMenuIconHighLight();
    },
    eventBind:function(){

    },
    setMenuIconHighLight:function(){
        if( $("#navbarCollapse li").size() < 1 ){
            return;
        }
        var pathname = window.location.pathname;
        var nav_name = "home";


        if(  pathname.indexOf("/default/mina") > -1  ){
            nav_name = "mina";
        }

        if(  pathname.indexOf("/default/site") > -1  ){
            nav_name = "site";
        }

        if(  pathname.indexOf("/default/soft") > -1  ){
            nav_name = "soft";
        }

        $("#navbarCollapse li."+nav_name).addClass("active");
    },
    buildMarketUrl:function( path ,params){
        var url =  "/market" +  path;
        var _paramUrl = '';
        if( params ){
            _paramUrl = Object.keys(params).map(function(k) {
                return [encodeURIComponent(k), encodeURIComponent(params[k])].join("=");
            }).join('&');
            _paramUrl = "?"+_paramUrl;
        }
        return url+_paramUrl

    },
};

$(document).ready(function () {
    common_ops.init();
});