;
var user_reg_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){
        $("#register_form .do_reg").click( function(){
            var btn_target = $(this);
            if( btn_target.hasClass("disabled") ){
                common_ops.alert("正在处理!!请不要重复提交~~");
                return;
            }

            var login_name_target = $("#register_form input[name=login_name]");
            var login_name = login_name_target.val();

            var email_target = $("#register_form input[name=email]");
            var email = email_target.val();

            var login_pwd_target = $("#register_form input[name=login_pwd]");
            var login_pwd = login_pwd_target.val();

            var captcha_code_target = $("#register_form input[name=captcha_code]");
            var captcha_code = captcha_code_target.val();

            if( login_name.length < 1  ){
                common_ops.tip("请输入符合规范的用户名~~",login_name_target);
                return;
            }

            if( email.length < 1  ){
                common_ops.tip("请输入符合规范的邮箱地址~~",email_target);
                return;
            }

            if(  !/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/.test( email ) ){
                common_ops.tip("请输入符合规范的邮箱地址~~",email_target);
                return;
            }

            if( login_pwd.length < 6  ){
                common_ops.tip("请设置一个不少于6位的密码~~",login_pwd_target);
                return;
            }

            if( captcha_code.length < 4  ){
                common_ops.tip("请输入符合规范的图形验证码~~",captcha_code_target);
                return;
            }

            btn_target.addClass("disabled");
            var data = {
                email:email,
                login_name:login_name,
                login_pwd:login_pwd,
                captcha_code:captcha_code
            };

            $.ajax({
                url:common_ops.buildWebUrl("/user/reg") ,
                type:'POST',
                data:data,
                dataType:'json',
                success:function(res){
                    btn_target.removeClass("disabled");
                    var callback = null;
                    if( res.code == 200 ){
                        callback = function(){
                            window.location.href = common_ops.buildWebUrl("/user/login");
                        }
                    }
                    common_ops.alert( res.msg,callback );
                }
            });

        });
    }
};

$(document).ready( function(){
    user_reg_ops.init();
} );