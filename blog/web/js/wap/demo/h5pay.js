;
var demo_h5pay_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){
        var that = this;
        $(".am-form .pay").click(function(){
            window.location.href = $(".am-form input[name=email]").val();
        });
    }
};


$(document).ready( function(){
    demo_h5pay_ops.init();
} );