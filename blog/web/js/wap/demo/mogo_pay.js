;
var demo_mogopay_ops = {
    init:function(){
        $(".am-navbar").hide();
        this.initWechatconfig();
        this.eventBind();
    },
    eventBind:function(){
        var that = this;
        $(".am-form .pay").click(function(){
            var openid = $(this).attr("data");
            if( openid == undefined ){
                openid = $(".am-form input[name=openid]").val();
            }
            $.ajax({
                url:common_ops.buildWapUrl("/demo/mogo-pay"),
                type:'POST',
                dataType:'json',
                data:{
                    'openid':openid
                },
                success:function(){

                }
            });
        });
    },
    initWechatconfig:function(){
        var that = this;
        $.ajax({
            url:common_ops.buildWapUrl( '/demo/jssdk' ) ,
            type:'GET',
            data:{
                'url':encodeURIComponent(location.href.split('#')[0])
            },
            dataType:'json',
            success:function(data){
                if(data.code == 200) {
                    var appId = data.data.appId;
                    var timestamp = data.data.timestamp;
                    var nonceStr = data.data.nonceStr;
                    var signature = data.data.signature;
                    wx.config({
                        debug: false,
                        appId: appId,
                        timestamp: timestamp,
                        nonceStr: nonceStr,
                        signature: signature,
                        jsApiList: [
                            'onMenuShareTimeline','onMenuShareAppMessage','chooseWXPay'
                        ]
                    });

                    var res_data = data;
                    wx.ready( function(){

                    });

                    wx.error(function(res){
                        alert( res );
                    });
                }
            }
        });
    },
};


$(document).ready( function(){
    demo_mogopay_ops.init();
} );