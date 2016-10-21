;
var account_index_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){
        var that = this;
        $("#set_account_wrap .save").unbind("click").click( function(){
            var btn_target = $(this);
            if( btn_target.hasClass("disabled") ){
                $.alert("正在提交，请不要重复提交~~");
                return;
            }

            var title_target = $("#set_account_wrap input[name=title]");
            var title_val = title_target.val();
            var account_target = $("#set_account_wrap input[name=account]");
            var account_val = account_target.val();
            var pwd_target = $("#set_account_wrap input[name=pwd]");
            var pwd_val = pwd_target.val();
            var description_target = $("#set_account_wrap textarea[name=description]");
            var description_val = description_target.val();

            if( !title_val || title_val.length < 1){
                title_target.tip("请输入标题，方便记忆~~");
                return;
            }

            if( !account_val || account_val.length < 1){
                account_val.tip("请输入账号~~");
                return;
            }

            if( !pwd_val || pwd_val.length < 1){
                pwd_target.tip("请输入密码~~");
                return;
            }

            btn_target.addClass("disabled");

            $.ajax({
                url:'/account/set',
                type:'post',
                data:{
                    title:title_val,
                    account:account_val,
                    pwd:pwd_val,
                    description:description_val,
                    account_id: $("#set_account_wrap input[name=account_id]").val()
                },
                dataType:'json',
                success:function( res ){
                    btn_target.removeClass("disabled");
                    var callback = {};
                    if( res.code == 200 ){
                        callback = {
                            'ok':function(){
                                window.location.href = window.location.href;
                            }
                        };
                    }
                    $.alert(res.msg,callback);
                }
            });
        } );

        $("#set_account_wrap .gene_pwd").unbind("click").click( function(){
            $.ajax({
                url:'/account/gene_pwd',
                type:'post',
                dataType:'json',
                success:function( res ){
                    if( res.code == 200 ){
                        $("#set_account_wrap input[name=pwd]").val( res.data.pwd );
                    }else{
                        $.alert( res.msg );
                    }
                }
            });
        } );


    }
};

$(document).ready( function(){
    account_index_ops.init();
} );