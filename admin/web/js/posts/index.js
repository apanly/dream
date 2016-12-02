;
var posts_index_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){

        $("#search_conditions .do").click(function(){
            $("#search_conditions").submit();
        });

        $("#search_conditions .clear_search").click( function(){
            $("#search_conditions select[name=status]").val(-99);
            $("#search_conditions input[name=kw]").val('');
            $("#search_conditions .do").click();
        });

        $("#search_conditions input[name=kw]").keydown(function (e) {
            if (e.keyCode == 13) {
                $("#search_conditions .do").click();
            }
        });

        $(".delete").each(function(){
            $(this).click(function(){
                if(!confirm("确认删除吗?\r\n删除之后数据无法恢复!!")){
                    return;
                }
                var post_id = $(this).attr("data");
                $.ajax({
                    url:'/posts/ops/' + post_id,
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
                var post_id = $(this).attr("data");
                $.ajax({
                    url:'/posts/ops/' + post_id,
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
    posts_index_ops.init();
});