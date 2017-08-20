;
var public_ops = {
    init: function () {
        this.eventBind();
        this.backToTop();
    },
    eventBind: function () {
        var that = this;
        $(".sidebar .do-search").click(function () {
            that.search();
        });

        $(".sidebar #kw").keydown(function (e) {
            if (e.keyCode == 13) {
                that.search();
            }
        });
    },
    search: function () {
        var kw = $.trim($(".sidebar #kw").val());
        if (kw.length < 1) {
            $(".sidebar #kw").focus();
            alert("编程浪子提醒您\r\n请输入搜索关键字!!");
            return;
        }
        window.location.href = "/search/do?kw=" + kw;
    },
    backToTop: function () {
        $(window).scroll(function () {
            if ($(this).scrollTop() > 100) {
                $('#back-to-top').fadeIn();
            } else {
                $('#back-to-top').fadeOut();
            }
        });
        $('#back-to-top').on('click', function (e) {
            e.preventDefault();
            $('html, body').animate({scrollTop: 0}, 1000);
            return false;
        });
    }
};

var common_ops = {
    buildWebUrl:function( path ,params){
        var url =    path;
        var _paramUrl = '';
        if( params ){
            _paramUrl = Object.keys(params).map(function(k) {
                return [encodeURIComponent(k), encodeURIComponent(params[k])].join("=");
            }).join('&');
            _paramUrl = "?"+_paramUrl;
        }
        return url + _paramUrl

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
    public_ops.init();
});