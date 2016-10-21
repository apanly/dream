;
var library_index_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){
        $(".delete").each(function(){
            $(this).click(function(){
                var post_id = $(this).attr("data");
                $.confirm("确认下架吗？",{
                    'ok':function(){
                        $.ajax({
                            url:common_ops.buildAdminUrl('/library/ops/' + post_id),
                            type:'POST',
                            data:{'act':'del'},
                            dataType:'json',
                            success:function(res){
                                var callback = {};
                                if(res.code == 200){
                                    callback = {
                                        'ok':function(){
                                            window.location.href = window.location.href;
                                        }
                                    };
                                }
                                $.alert(res.msg,callback);
                            }
                        });
                    }
                });
            });
        });

        $(".online").click(function(){
            var post_id = $(this).attr("data");
            $.confirm("确认上架吗？",{
                'ok':function(){
                    $.ajax({
                        url:common_ops.buildAdminUrl('/library/ops/' + post_id),
                        type:'POST',
                        data:{'act':'online'},
                        dataType:'json',
                        success:function(res){
                            var callback = {};
                            if(res.code == 200){
                                callback = {
                                    'ok':function(){
                                        window.location.href = window.location.href;
                                    }
                                };
                            }
                            $.alert(res.msg,callback);
                        }
                    });
                }
            });
        });



        $(".btn-book-read").click(function(){
            common_ops.popLayer( "/library/set",{
                title:'编辑图书状态',
                data:{ id:$(this).attr("data") }
            } );
        });
    }
};

$(document).ready(function(){
    library_index_ops.init();
});