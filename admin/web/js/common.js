;
var common_ops = {
    init:function(){
        this.eventBind();
        this.setMenuIconHighLight();
        this.autoComplete();
    },
    eventBind:function(){
        //文本框失去焦点时隐藏tip提示层
        $('div').off('change','.input-1,.textarea-1,.textarea-1a').on('blur','.input-1,.textarea-1,.textarea-1a',function(){
            $(this).hideTip();
        });
        $('div').off('change',".radio-1,.select-1,.checkbox-1").on('change',".radio-1,.select-1,.checkbox-1",function() {
            $(this).hideTip();
        });

    },
    setMenuIconHighLight:function(){
        if( $(".box_left_nav .menu_list").size() < 1 ){
            return;
        }
        var pathname = window.location.pathname;

        var nav_name = null;

        if(  pathname.indexOf("/default/") > -1  ){
            nav_name = "dashboard";
        }

        if(  pathname.indexOf("/posts/") > -1 || pathname.indexOf("/md/") > -1  ){
            nav_name = "posts";
        }

        if(  pathname.indexOf("/wechat/") > -1 ){
            nav_name = "wechat";
        }

        if(  pathname.indexOf("/account/") > -1  ){
            nav_name = "account";
        }

        if(  pathname.indexOf("/richmedia/") > -1  ){
            nav_name = "richmedia";
        }

        if(  pathname.indexOf("/library/") > -1  ){
            nav_name = "library";
        }

        if(  pathname.indexOf("/file/") > -1  ){
            nav_name = "files";
        }

        if(  pathname.indexOf("/log/") > -1  ){
            nav_name = "stat";
        }

        if(  pathname.indexOf("/ops/") > -1  ){
            nav_name = "ops";
        }

        if( pathname.indexOf("/douban/") > -1 ){
            nav_name = "girl";
        }

        if( pathname.indexOf("/soft/") > -1 ){
            nav_name = "soft";
        }


        if( nav_name == null ){
            return;
        }

        $(".box_left_nav .menu_list li.menu_"+nav_name).addClass("current");
    },
    buildAdminUrl:function( path ,params){
        var url =   path;
        var _paramUrl = '';
        if( params ){
            _paramUrl = Object.keys(params).map(function(k) {
                return [encodeURIComponent(k), encodeURIComponent(params[k])].join("=");
            }).join('&');
            _paramUrl = "?"+_paramUrl;
        }
        return url+_paramUrl

    },
    autoComplete:function(){
        $("#top_search").autocomplete({
            source: function( request, response ) {
                $.ajax({
                    url: common_ops.buildAdminUrl("/default/top-search"),
                    dataType: "json",
                    data:{q: request.term },
                    success: function( res ) {
                        response( $.map( res.data, function( item ) {
                            return {
                                url:item.url,
                                label: item.title,
                                value: item.title
                            }
                        }));
                    }
                });
            },
            minLength: 1,
            select:function(event, ui){
                window.location.href = ui.item.url;
            }
        });
    },

    popLayer:function(url,params){
        var data = params.hasOwnProperty('data')?params['data']:{};
        var target_handle = params.hasOwnProperty('target')?params['target']:$("#pop_layer_wrap");
        var title = params.hasOwnProperty('title')?params['title']:'';
        var request_method =  params.hasOwnProperty('method')?params['method']:'GET';
        //是否阻止弹窗的默认关闭事件
        var preventClose = params.hasOwnProperty('preventClose')?params['preventClose']:false;
        $.ajax({
            url:common_ops.buildAdminUrl(url),
            type:request_method,
            data:data,
            dataType:'json',
            success:function(res){
                if( res.code == 200 ){
                    target_handle.html(  res.data.form_wrap );
                    if(  target_handle.parents(".lay-body").size() > 0  ){
                        $.lay.refresh();
                        return;
                    }
                    if(  params.hasOwnProperty('lay-size') ){
                        target_handle.attr("class", "hide " + params['lay-size']);
                    }else{//默认是small
                        //target_handle.addClass('lay-medium');
                    }
                    $.lay.open({
                        'content':target_handle,
                        'title':title,
                        'shadeClose':false,
                        'preventClose':preventClose
                    });
                }else{
                    $.alert(res.msg);
                }
            }
        })
    }
};

$(document).ready(function(){
    common_ops.init();
    window.onerror = function(message, url, lineNumber,columnNo,error) {
        var data = {
            'message':message,
            'url':url,
            'error':error.stack
        };
        $.ajax({
            url:"/error/capture",
            type:'post',
            data:data,
            success:function(){

            }
        });
        return true;
    };
});


/**
 * 正式代码如果有console.log
 * 提交到错误平台
 * **/
if( window.console && window.location.hostname.indexOf("dr.local.com") <= -1 ){
    window.console.log = function( msg ){
        var data = {
            'message':msg,
            'url':window.location.href,
            'error':'console.log'
        };
        $.ajax({
            url:"/error/capture",
            type:'post',
            data:data,
            success:function(){

            }
        });
    };
}

// 对Date的扩展，将 Date 转化为指定格式的String
// 月(M)、日(d)、小时(h)、分(m)、秒(s)、季度(q) 可以用 1-2 个占位符，
// 年(y)可以用 1-4 个占位符，毫秒(S)只能用 1 个占位符(是 1-3 位的数字)
// 例子：
// (new Date()).Format("yyyy-MM-dd hh:mm:ss.S") ==> 2006-07-02 08:09:04.423
// (new Date()).Format("yyyy-M-d h:m:s.S")      ==> 2006-7-2 8:9:4.18
Date.prototype.Format = function(fmt)
{ //author: meizz
    var o = {
        "M+" : this.getMonth()+1,                 //月份
        "d+" : this.getDate(),                    //日
        "h+" : this.getHours(),                   //小时
        "m+" : this.getMinutes(),                 //分
        "s+" : this.getSeconds(),                 //秒
        "q+" : Math.floor((this.getMonth()+3)/3), //季度
        "S"  : this.getMilliseconds()             //毫秒
    };
    if(/(y+)/.test(fmt))
        fmt=fmt.replace(RegExp.$1, (this.getFullYear()+"").substr(4 - RegExp.$1.length));
    for(var k in o)
        if(new RegExp("("+ k +")").test(fmt))
            fmt = fmt.replace(RegExp.$1, (RegExp.$1.length==1) ? (o[k]) : (("00"+ o[k]).substr((""+ o[k]).length)));
    return fmt;
};
