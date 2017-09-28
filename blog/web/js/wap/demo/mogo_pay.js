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
                success:function( res ){
                    var data = res.data['payinfo'];
                    data = eval( '(' + data + ')' );
                    var json_data = {
                        timestamp: data.timeStamp,
                        nonceStr: data.nonceStr,
                        package: data.package,
                        signType: data.signType,
                        paySign: data.paySign,
                        success: function () {
                            alert("支付成功~~");
                            window.location.href = window.location.href;
                        },
                        cancel: function(){
                            alert("取消了支付~~");
                        },
                        fail: function(){
                            alert("支付失败~~");
                        }
                    };
                    // wx.ready( function(){
                    //     wx.chooseWXPay( json_data );
                    // } );
                    WeixinJSBridge.invoke(
                        'getBrandWCPayRequest', {
                            "appId": data.appId,     //公众号名称，由商户传入
                            "timeStamp":data.timeStamp,         //时间戳，自1970年以来的秒数
                            "nonceStr":data.nonceStr, //随机串
                            "package":data.package,
                            "signType":data.signType,         //微信签名方式：
                            "paySign":data.paySign //微信签名
                        },
                        function( res ){
                            //// 使用以上方式判断前端返回,微信团队郑重提示：res.err_msg将在用户支付成功后返回    ok，但并不保证它绝对可靠。
                            if(res.err_msg == "get_brand_wcpay_request:ok" ) {
                                alert("支付成功~~");
                            }

                            if(res.err_msg == "get_brand_wcpay_request:cancel" ) {
                                alert("支付取消~~");
                            }

                            if(res.err_msg == "get_brand_wcpay_request:fail" ) {
                                alert("支付失败~~");
                            }
                        }
                    );
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
                'url':location.href.split('#')[0]
            },
            dataType:'json',
            success:function(data){
                if(data.code == 200) {
                    var appId = data.data.appId;
                    var timestamp = data.data.timestamp;
                    var nonceStr = data.data.nonceStr;
                    var signature = data.data.signature;
                    wx.config({
                        debug: true,
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
                        var msg = '';
                        for( var idx in res ){
                            msg += idx + ":" + res[idx];
                        }
                        alert(  msg  );
                    });
                }
            }
        });
    }
};

function onBridgeReady(){
    demo_mogopay_ops.init();
}

$(document).ready( function(){
    if (typeof WeixinJSBridge == "undefined"){
        if( document.addEventListener ){
            document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
        }else if (document.attachEvent){
            document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
            document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
        }
    }else{
        onBridgeReady();
    }
} );