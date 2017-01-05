;
var md_menu_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){
        $(".ops_btn_wrap .add").click( function(){
            common_ops.popLayer( "/md/menu-set",{
                'title':'设置一级菜单'
            } )
        });

        $(".ops_btn_wrap .refresh").click( function(){
            $.ajax({
                url:common_ops.buildAdminUrl('/md/menu-refresh'),
                type:'POST',
                dataType:'json',
                success:function(res){
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

        $(".menu_list_wrap .edit").click( function(){
            common_ops.popLayer( "/md/menu-set",{
                'title':'设置一级菜单',
                data:{
                    id:$(this).attr("data")
                }
            } )
        });

        $(".menu_list_wrap .add_sub").click( function(){
            common_ops.popLayer( "/md/menu-sub-set",{
                'title':'添加子菜单',
                'data':{
                    parent_id:$(this).attr("data")
                }
            } )
        });

        $(".menu_list_wrap .edit_sub").click( function(){
            common_ops.popLayer( "/md/menu-sub-set",{
                'title':'编辑子菜单',
                'data':{
                    id:$(this).attr("data"),
                    parent_id:$(this).attr("data_parent_id")
                }
            } )
        });


        $(".rbac_l .lv_1").click( function(){
            $(".rbac_l .lv_1").removeClass('color-theme');
            $(this).addClass('color-theme');
            $(".rbac_r .table-1").hide();
            $("#menu_"+$(this).attr('data')).show();
        } );

        $(".rbac_l .lv_1:first").click();
    }
};
$(document).ready( function(){
    md_menu_ops.init();
});