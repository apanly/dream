;
var user_login_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){
        $("#login_form .do_login").click( function(){
            var btn_target = $(this);
            if( btn_target.hasClass("disabled") ){
                common_ops.alert("正在处理!!请不要重复提交~~");
                return;
            }

            var login_name_target = $("#login_form input[name=login_name]");
            var login_name = login_name_target.val();

            var login_pwd_target = $("#login_form input[name=login_pwd]");
            var login_pwd = login_pwd_target.val();

            if( login_name.length < 1  ){
                common_ops.tip("请输入符合规范的用户名或者邮箱~~",login_name_target);
                return;
            }

            if( login_pwd.length < 6  ){
                common_ops.tip("请设置一个不少于6位的密码~~",login_pwd_target);
                return;
            }

            btn_target.addClass("disabled");
            var data = {
                login_name:login_name,
                login_pwd:login_pwd
            };

            $.ajax({
                url:common_ops.buildWebUrl("/user/login") ,
                type:'POST',
                data:data,
                dataType:'json',
                success:function(res){
                    btn_target.removeClass("disabled");
                    var callback = null;
                    if( res.code == 200 ){
                        callback = function(){
                            window.location.href = res.data.url;
                        }
                    }
                    common_ops.alert( res.msg,callback );
                }
            });

        });
    }
};

$(document).ready( function(){
    user_login_ops.init();
} );