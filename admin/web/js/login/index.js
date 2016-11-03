;
var login_index_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){
        var that = this;
        document.onkeydown = function(e){
            var ev = document.all ? window.event : e;
            if(ev.keyCode==13) {
                $(".login-form .login").click();
            }
        };

        $(".login-form .login").click(function(){

            var mobile = $.trim( $(".login-form input[name=mobile]").val() );
            var passwd = $.trim( $(".login-form input[name=passwd]").val() );

            if(!/^[1-9]\d{10}$/.test(mobile)){
                $.alert("请输入符合规范的手机号码!");
                $(".login-form input[name=mobile]").focus();
                return false;
            }
            if(passwd.length <= 0 || passwd.length > 20){
                $.alert("请输入符合规范的密码!");
                $(".login-form input[name=passwd]").focus();
                return false;
            }

            var data = {
                mobile:mobile,
                passwd:passwd
            };
            $.ajax({
                url:'/auth/login',
                type:'POST',
                data:data,
                dataType:'json',
                success:function(res){
                    if(res.code == 200){
                        window.location.href = res.data.url;
                    }else{
                        $.alert(res.msg);
                    }
                }
            });
        });
    }
};
$(document).ready(function(){
    login_index_ops.init();
});