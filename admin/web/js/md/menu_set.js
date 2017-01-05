;
var menu_set_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){
        $(".pop_menu_set").off("click",".save").on("click",".save",function(){
            var btn_target = $(this);
            if( btn_target.hasClass("disabled") ){
                $.alert("正在保存，请不要重复提交~~");
                return false;
            }
            var title_target = $(".pop_menu_set input[name=title]");
            var title = $.trim( title_target.val() );

            var weight_target = $(".pop_menu_set input[name=weight]");
            var weight = $.trim( weight_target.val() );

            if( title.length < 1  ){
                title_target.tip("请输入符合规范的菜单名称~~");
                return;
            }

            if( weight.length < 1 || parseInt( weight ) < 1 ){
                weight_target.tip("请输入符合规范的权重~~");
                return;
            }

            btn_target.addClass("disabled");

            $.ajax({
                url:common_ops.buildAdminUrl('/md/menu-set'),
                data:{
                    id:$(".pop_menu_set input[name=id]").val(),
                    title:title,
                    weight:weight
                },
                type:'POST',
                dataType:'json',
                success:function(res){
                    btn_target.removeClass("disabled");
                    var callback = {};
                    if(res.code == 200){
                        callback = {
                            ok:function(){
                                window.location.href = window.location.href;
                            },
                            cancel:function(){
                                window.location.href = window.location.href;
                            }
                        }
                    }
                    $.alert(res.msg,callback);
                }
            });
        });
    }
};

$(document).ready( function(){
    menu_set_ops.init();
});