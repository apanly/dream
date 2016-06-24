;
var account_index_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){
        var that = this;
        $('.add').click( function(){
            $.ajax({
                url:'/account/set',
                type:'get',
                dataType:'json',
                success:function( res ){
                    if( res.code == 200 ){
                        $("#set_account_wrap").html( res.data.form_wrap);
                        that.setPopEvent();
                        $("#set_account_wrap").modal();
                    }else{
                        alert( res.msg );
                    }
                }
            });

        });

        $('.edit').click( function(){
            $.ajax({
                url:'/account/set',
                type:'get',
                data:{ account_id: $(this).attr("data") },
                dataType:'json',
                success:function( res ){
                    if( res.code == 200 ){
                        $("#set_account_wrap").html( res.data.form_wrap);
                        that.setPopEvent();
                        $("#set_account_wrap").modal();
                    }else{
                        alert( res.msg );
                    }
                }
            });

        });


    },
    setPopEvent:function(){
        $("#set_account_wrap .save").unbind("click").click( function(){
            var _this = this;
            if( $(_this).hasClass("btn-doing") ){
                alert("正在提交，请不要重复提交！！");
                return;
            }

            var title = $("#set_account_wrap input[name=title]").val();
            var account = $("#set_account_wrap input[name=account]").val();
            var pwd = $("#set_account_wrap input[name=pwd]").val();
            var description = $("#set_account_wrap textarea[name=description]").val();

            if( !title || title.length < 1){
                alert("请输入标题，方便记忆！！");
                return;
            }

            if( !account || account.length < 1){
                alert("请输入账号！！");
                return;
            }

            if( !pwd || pwd.length < 1){
                alert("请输入密码！！");
                return;
            }

            $(_this).addClass("btn-doing");

            $.ajax({
                url:'/account/set',
                type:'post',
                data:{
                    title:title,
                    account:account,
                    pwd:pwd,
                    description:description,
                    account_id: $("#set_account_wrap input[name=account_id]").val()
                },
                dataType:'json',
                success:function( res ){
                    $(_this).removeClass("btn-doing");
                    alert(res.msg);
                    if( res.code == 200 ){
                        window.location.href = window.location.href;
                    }
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
                        alert( res.msg );
                    }
                }
            });
        } );
    }
};

$(document).ready( function(){
    account_index_ops.init();
} );