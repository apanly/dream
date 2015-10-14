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

        $(".btn-address").each(function(){
            $(this).click(function(){
                $('.modal input[name=media-id]').val( $(this).attr("data") );
                $('.modal input[name=address]').val( $(this).attr("data-address") );
                $('.modal').modal()
            });
        });

        $(".modal .btn-primary").click(function(){
            var media_id = $('.modal input[name=media-id]').val();
            var address = $('.modal input[name=address]').val();
            $.ajax({
                url:'/richmedia/edit/' + media_id,
                type:'POST',
                data:{'address':address},
                dataType:'json',
                success:function(res){
                    alert(res.msg);
                    if(res.code == 200){
                        window.location.href = window.location.href;
                    }
                }
            });
        });
    }
};

$(document).ready(function(){
    richmedia_index_ops.init();
});