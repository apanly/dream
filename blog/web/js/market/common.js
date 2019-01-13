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

        if(  pathname.indexOf("/default/about") > -1  ){
            nav_name = "about";
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
    alert:function( msg ,cb ){
        layer.alert( msg,{
            yes:function( index ){
                if( typeof cb == "function" ){
                    cb();
                }
                layer.close( index );
            }
        });
    },
    confirm:function( msg,callback ){
        callback = ( callback != undefined )?callback: { 'ok':null, 'cancel':null };
        layer.confirm( msg , {
            btn: ['确定','取消'] //按钮
        }, function( index ){
            //确定事件
            if( typeof callback.ok == "function" ){
                callback.ok();
            }
            layer.close( index );
        }, function( index ){
            //取消事件
            if( typeof callback.cancel == "function" ){
                callback.cancel();
            }
            layer.close( index );
        });
    },
    tip:function( msg,target ){
        layer.tips( msg, target, {
            tips: [ 3, '#e5004f']
        });
        $('html, body').animate({
            scrollTop: target.offset().top - 10
        }, 100);
    }
};

$(document).ready(function () {
    common_ops.init();
});