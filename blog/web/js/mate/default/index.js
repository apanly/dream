;
var mate_default_index = {
    init:function(){

        this.eventBind();
    },
    eventBind:function(){
        $("#enrol .save").click( function(){
            var _this = this;
            if( $(_this).hasClass("am-disabled") ){
                alert("正在保存，请不要重复提交!!");
                return;
            }

            var nickname = $("#enrol input[name=nickname]").val();
            var mobile = $("#enrol input[name=mobile]").val();
            var person_number = $("#enrol #person_number").val();
            if( nickname.length < 1 ){
                alert("请填写你的真实姓名!!");
                return;
            }

            if( mobile.length > 11 ){
                alert("请输入合法的手机号码!!");
                return;
            }

            if( !/^[1-4]$/.test(person_number) ){
                alert("请选择回校人数!!");
                return;
            }

            $(_this).addClass("am-disabled");

            $.ajax({
                url:common_ops.getUrlPrefix() + "/default/index",
                type:'POST',
                data:{ 'nickname':nickname,'mobile':mobile,'person_number':person_number },
                dataType:'json',
                success:function( res ){
                    alert(res.msg);
                    $(_this).removeClass("am-disabled");
                    if( res.code == 200 ){
                        window.location.href = window.location.href;
                    }
                }
            })
        });
    }
};

$(document).ready( function(){
    mate_default_index.init();
});