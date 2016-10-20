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

        if(  pathname.indexOf("/club/recept") > -1  ){
            nav_name = "recept";
        }

        if(  pathname.indexOf("/club/member") > -1  ){
            nav_name = "member";
        }

        if(  pathname.indexOf("/import/member") > -1  ){
            nav_name = "member";
        }

        if(  pathname.indexOf("/club/course") > -1  ){
            nav_name = "course";
        }

        if(  pathname.indexOf("/club/product") > -1  ){
            nav_name = "product";
        }

        if(  pathname.indexOf("/import/contract") > -1  ){
            nav_name = "product";
        }

        if(  pathname.indexOf("/club/staff") > -1  ){
            nav_name = "staff";
        }

        if( pathname.indexOf("club/rbac") > -1 ){
            nav_name = "staff";
        }

        if(  pathname.indexOf("/club/stat") > -1  ){
            nav_name = "stat";
        }

        if(  pathname.indexOf("/club/finance") > -1  ){
            nav_name = "finance";
        }

        if(  pathname.indexOf("/club/plugins") > -1 || pathname == '/club/setting/sms' ){
            nav_name = "plugins";
        }

        if(  pathname.indexOf("/club/shop") > -1  ){
            nav_name = "shop";
        }

        if( nav_name == null ){
            return;
        }

        $(".box_left_nav .menu_list li."+nav_name).addClass("current");
    },
    buildClubUrl:function( path ,params){
        var url =  "/club" + path;
        var _paramUrl = '';
        if( params ){
            _paramUrl = Object.keys(params).map(function(k) {
                return [encodeURIComponent(k), encodeURIComponent(params[k])].join("=");
            }).join('&');
            _paramUrl = "?"+_paramUrl;
        }
        return url+_paramUrl

    },
    buildPicStaticUrl:function(bucket,img_key,params){
        bucket = bucket?bucket:"pic3";
        var url = "http://"+bucket+".s.rrr.me/"+img_key;

        var width = params.hasOwnProperty("w")?params['w']:0;
        var height = params.hasOwnProperty("h")?params['h']:0;
        if( !width && !height ){
            return url;
        }

        if( params.hasOwnProperty('view_mode') ){
            url += "?imageView2/"+params['view_mode'];
        }else{
            url += "?imageView2/1";
        }

        if( width ){
            url += "/w/"+width;
        }

        if( height ){
            url += "/h/"+height;
        }
        url += "/interlace/1";
        return url;
    },

    autoComplete:function(){
        $("#top_search").autocomplete({
            source: function( request, response ) {
                $.ajax({
                    url: common_ops.buildClubUrl("/search/member"),
                    dataType: "json",
                    data:{q: request.term,top: 1},//top=1区分是否是top搜索栏
                    success: function( res ) {
                        response( $.map( res.data, function( item ) {
                            return {
                                member_id:item.member_id,
                                nickname:item.nickname,
                                mobile:item.mobile,
                                ret_url:item.ret_url,
                                label: item.nickname +"(" + item.mobile + ")",
                                value: item.nickname +"(" + item.mobile + ")"
                            }
                        }));
                    }
                });
            },
            minLength: 1,
            select:function(event, ui){
                window.location.href = ui.item.ret_url;
                $("#top_search").text(ui.item.value);
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
            url:common_ops.buildClubUrl(url),
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
    },
    selectAll:function( btn_target,item_input_get ){//全选操作
        btn_target.change(function(){
            item_input_get.prop('checked',$(this).prop('checked') );
        });

        item_input_get.change( function(){
            btn_target.prop('checked',$(this).prop('checked') );
        });
    },
    getCheckBoxSelectOption:function( item_input_get ){//获取全选选中的值
        var options = [];
        item_input_get.each( function(){
            if( $(this).prop('checked') ){
                options.push ( $(this).val() )
            }
        });
        return options;
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
if( window.console && window.location.hostname.indexOf("rrr.test") <= -1 ){
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