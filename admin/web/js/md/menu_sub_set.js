;
var menu_sub_set_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){
        $(".pop_menu_sub_set").off("click",".save").on("click",".save",function(){
            var btn_target = $(this);
            if( btn_target.hasClass("disabled") ){
                $.alert("正在保存，请不要重复提交~~");
                return false;
            }
            var doc_id_target = $(".pop_menu_sub_set select[name=doc_id]");
            var doc_id = $.trim( doc_id_target.val() );

            var weight_target = $(".pop_menu_sub_set input[name=weight]");
            var weight = $.trim( weight_target.val() );

            if( parseInt( doc_id ) < 1  ){
                doc_id_target.tip("请选择教程~~");
                return;
            }

            if( weight.length < 1 || parseInt( weight ) < 1 ){
                weight_target.tip("请输入符合规范的权重~~");
                return;
            }

            btn_target.addClass("disabled");

            $.ajax({
                url:common_ops.buildAdminUrl('/md/menu-sub-set'),
                data:{
                    id:$(".pop_menu_sub_set input[name=id]").val(),
                    parent_id:$(".pop_menu_sub_set input[name=parent_id]").val(),
                    doc_id:doc_id,
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
    menu_sub_set_ops.init();
});