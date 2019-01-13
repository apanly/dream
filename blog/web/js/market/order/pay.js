;
var order_pay_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){
        $(".pay_soft").click( function(){
            var btn_target = $(this);
            if( btn_target.hasClass("disabled") ){
                common_ops.alert("正在保存，请不要重复提交~~");
                return false;
            }
            btn_target.addClass("disabled");

            $.ajax({
                url:common_ops.buildMarketUrl("/order/pay"),
                type:'POST',
                data:{
                    pay_sn:btn_target.attr("data")
                },
                dataType:'json',
                success:function( res ) {
                    btn_target.removeClass("disabled");
                    if (res.code == 201){
                        layer.open({
                            type: 1,
                            skin: 'layui-layer-demo', //样式类名
                            closeBtn: 1, //0不显示关闭按钮
                            shadeClose: true, //开启遮罩关闭,
                            area: ['600px', '480px'],
                            title:"支付宝微信转账",
                            content: res.data['content']
                        });
                        return;
                    }
                    var callback = null;
                    if( res.code == 200 ){
                        callback = function(){
                            window.location.href = window.location.href;
                        };
                    }
                    common_ops.alert( res.msg,callback );
                }
            });
        });
    }
};
$(document).ready(function () {
    order_pay_ops.init();
});