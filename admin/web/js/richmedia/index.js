;
var richmedia_index_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){
        $(".delete").each(function(){
            $(this).click(function(){
                if(!confirm("确认隐藏吗?!!")){
                    return;
                }
                var media_id = $(this).attr("data");
                $.ajax({
                    url:'/richmedia/ops/' + media_id,
                    type:'POST',
                    data:{'act':'del'},
                    dataType:'json',
                    success:function(res){
                        alert(res.msg);
                        if(res.code == 200){
                            window.location.href = window.location.href;
                        }
                    }
                });
            });
        });
        $(".online").each(function(){
            $(this).click(function(){
                var media_id = $(this).attr("data");
                $.ajax({
                    url:'/richmedia/ops/' + media_id ,
                    type:'POST',
                    data:{'act':'online'},
                    dataType:'json',
                    success:function(res){
                        alert(res.msg);
                        if(res.code == 200){
                            window.location.href = window.location.href;
                        }
                    }
                });
            });
        });
        $(".goaway").each(function(){
            $(this).click(function(){
                if(!confirm("确认雪藏吗?!!\r\n就是不在展示了")){
                    return;
                }
                var media_id = $(this).attr("data");
                $.ajax({
                    url:'/richmedia/ops/' + media_id,
                    type:'POST',
                    data:{'act':'goaway'},
                    dataType:'json',
                    success:function(res){
                        alert(res.msg);
                        if(res.code == 200){
                            window.location.href = window.location.href;
                        }
                    }
                });
            });
        });

        $(".edit_address").click(function(){
            $('#pop_layer_wrap input[name=media-id]').val( $(this).attr("data") );
            $('#pop_layer_wrap input[name=address]').val( $(this).attr("data-address") );
            $.lay.open({
                'content':$('#pop_layer_wrap'),
                'title':'编辑地址',
                'shadeClose':false
            });
        });

        $("#pop_layer_wrap .save").click(function(){
            var media_id = $('#pop_layer_wrap input[name=media-id]').val();
            var address = $('#pop_layer_wrap input[name=address]').val();
            $.ajax({
                url:common_ops.buildAdminUrl('/richmedia/edit/' + media_id),
                type:'POST',
                data:{'address':address},
                dataType:'json',
                success:function(res){
                    var callback = {};
                    if(res.code == 200){
                        callback = {
                            'ok':function( ){
                                window.location.href = window.location.href;
                            }
                        };

                    }
                    $.alert(res.msg,callback);
                }
            });
        });
    }
};

$(document).ready(function(){
    richmedia_index_ops.init();
});