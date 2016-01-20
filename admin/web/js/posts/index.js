;
var posts_index_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){

        $("#search_from .do").click(function(){
            var kw = $("#search_from input[name=kw]").val();
            window.location.href = "/posts/index?kw=" + kw;
        });

        $("#search_from input[name=kw]").keydown(function (e) {
            if (e.keyCode == 13) {
                $("#search_from .do").click();
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

        $(".go-hot").each(function(){
            $(this).click(function(){
                var post_id = $(this).attr("data");
                $.ajax({
                    url:'/posts/ops/' + post_id,
                    type:'POST',
                    data:{'act':'go-hot'},
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

        $(".down-hot").each(function(){
            $(this).click(function(){
                var post_id = $(this).attr("data");
                $.ajax({
                    url:'/posts/ops/' + post_id,
                    type:'POST',
                    data:{'act':'down-hot'},
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