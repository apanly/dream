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
    }
};

$(document).ready(function(){
    richmedia_index_ops.init();
});