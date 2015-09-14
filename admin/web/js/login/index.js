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
                $(".signin .login").click();
            }
        };

        $(".login-form input[name=mobile]").focus(function(){
            $(this).attr("placeholder","");
        });
        $(".login-form input[name=mobile]").blur(function(){
            if($(this).val().length <= 0 ){
                $(this).attr("placeholder","请输入手机号码");
            }
        });
        $(".login-form input[name=passwd]").focus(function(){
            $(this).attr("placeholder","");
        });
        $(".login-form input[name=passwd]").blur(function(){
            if($(this).val().length <= 0 ){
                $(this).attr("placeholder","请输入密码");
            }
        });
        $(".signin .login").click(function(){
            if(!that.inputCheck()){
                return;
            }
            that.dataSubmit();
        });
    },
    inputCheck:function(){
        var mobile = $.trim( $(".login-form input[name=mobile]").val() );
        var passwd = $.trim( $(".login-form input[name=passwd]").val() );
        var mobile_reg = /^[1-9]\d{10}$/;
        if(!mobile_reg.test(mobile)){
            alert("请输入符合规范的手机号码!");
            $(".login-form input[name=mobile]").focus();
            return false;
        }
        if(passwd.length <= 0 || passwd.length > 20){
            alert("请输入符合规范的密码!");
            $(".login-form input[name=passwd]").focus();
            return false;
        }
        return true;
    },
    dataSubmit:function(){
        var mobile = $.trim( $(".login-form input[name=mobile]").val() );
        var passwd = $.trim( $(".login-form input[name=passwd]").val() );
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
                    alert(res.msg);
                }
            }
        });
    }
};
$(document).ready(function(){
    login_index_ops.init();
});