;
var user_profile_set_pwd_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){
        $(".wrap_set_pwd .save").click( function(){
            var btn_target = $(this);
            if( btn_target.hasClass("disabled") ){
                common_ops.alert("正在处理!!请不要重复提交~~");
                return;
            }

            var pwd_target = $(".wrap_set_pwd input[name=pwd]");
            var pwd_val = pwd_target.val();

            var pwd1_target = $(".wrap_set_pwd input[name=pwd1]");
            var pwd1_val = pwd1_target.val();

            var pwd2_target = $(".wrap_set_pwd input[name=pwd2]");
            var pwd2_val = pwd2_target.val();

            if( pwd_val.length < 1  ){
                common_ops.tip("请输入当前账号密码~~",pwd_target);
                return;
            }


            if( pwd1_val.length < 6  ){
                common_ops.tip("请输入新密码，密码不少于6位~~",pwd1_target);
                return;
            }

            if( pwd1_val != pwd2_val ){
                common_ops.tip("请输入确认密码，确认密码必须与新密码一致~~",pwd2_target);
                return;
            }

            btn_target.addClass("disabled");
            var data = {
                pwd:pwd_val,
                pwd1:pwd1_val,
                pwd2:pwd2_val
            };

            $.ajax({
                url:common_ops.buildWebUrl("/user/profile/set-pwd") ,
                type:'POST',
                data:data,
                dataType:'json',
                success:function(res){
                    btn_target.removeClass("disabled");
                    var callback = null;
                    if( res.code == 200 ){
                        callback = function(){
                            window.location.href = window.location.href;
                        }
                    }
                    common_ops.alert( res.msg,callback );
                }
            });

        });
    }
};

$(document).ready( function(){
    user_profile_set_pwd_ops.init();
} );

