;
var library_index_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){
        $(".delete").each(function(){
            $(this).click(function(){
                if(!confirm("确认隐藏吗?\r\n隐藏之后数据无法恢复!!")){
                    return;
                }
                var post_id = $(this).attr("data");
                $.ajax({
                    url:'/library/ops/' + post_id,
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
    }
};

$(document).ready(function(){
    library_index_ops.init();
});