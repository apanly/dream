;
var wechatwall_ops = {
    init:function(){
        this.eventBind();

    },
    eventBind:function(){
        var that = this;
        $('#close_checkin_window').on("click",function(){
            WeixinJSBridge.invoke('closeWindow',{});
        });
    }

};

$(document).ready(function(){
    wechatwall_ops.init();
});
