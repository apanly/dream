;
var demo_mobile_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){
        var that = this;
        $("#search .btn-search").click(function(){
            var mobile = $("#search input[name=mobile]").val();
            if( mobile.length < 1 || mobile.length > 13 ){
                alert("请输入正确手机号码~");
                return;
            }

            $(".search_result").addClass( "am-hide" );

            $.ajax({
                url: common_ops.buildWapUrl("/demo/mobile"),
                type: 'POST',
                dataType: 'json',
                data: {
                    'mobile': mobile
                },
                success: function (res) {
                    if( res.code != 200 ){
                        alert( res.msg );
                        return;
                    }
                    var data = res.data;
                    str = "";
                    str += "<p class='am-monospace'>省份：" +  data['provice'] + "</p>";
                    str += "<p class='am-monospace'>城市：" +  data['city'] + "</p>";
                    str += "<p class='am-monospace'>运营商：" +  data['operator'] + "</p>";
                    str += "<p class='am-monospace'>区号：" +  data['zone'] + "</p>";
                    str += "<p class='am-monospace'>邮编：" +  data['code'] + "</p>";
                    $(".search_result").html( str );
                    $(".search_result").removeClass( "am-hide" );
                }
            })
        });
    }
};


$(document).ready( function(){
    demo_mobile_ops.init();
} );