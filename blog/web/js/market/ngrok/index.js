;
var ngrok_index_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){
        $(".do_ngrok").click( function(){
            $("#ngrok_set_wrap input[name=id]").val( $(this).attr("data") );
            $('#ngrok_set_wrap').modal();
        });

        $("#ngrok_set_wrap .save").click( function(){
            var btn_target = $(this);
            if( btn_target.hasClass("disabled") ){
                common_ops.alert("正在保存，请不要重复提交~~");
                return false;
            }

            var prefix_domain = $("#ngrok_set_wrap input[name=prefix_domain]").val();
            if( prefix_domain == undefined || prefix_domain.length < 4 ){
                common_ops.alert("请输入符合规范的域名前缀,至少4位~~");
                return false;
            }
            var ngrok_id = $("#ngrok_set_wrap input[name=id]").val();
            $.ajax({
                url: common_ops.buildMarketUrl("/ngrok/ops"),
                type: 'POST',
                data: {
                    id: ngrok_id,
                    prefix_domain:prefix_domain
                },
                dataType: 'json',
                success: function (res) {
                    btn_target.removeClass("disabled");
                    var callback = null;

                    if( res.code == 200 ){
                        callback = function(){
                            window.location.href = window.location.href;
                        };
                    }
                    common_ops.alert( res.msg,callback );
                }
            });
            btn_target.addClass("disabled");
        });
    }
};

$(document).ready( function(){
    ngrok_index_ops.init();
});