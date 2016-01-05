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

        $(".online").each(function(){
            $(this).click(function(){
                var post_id = $(this).attr("data");
                $.ajax({
                    url:'/library/ops/' + post_id,
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

        $(".btn-book-read").each(function(){
            $(this).click(function(){
                $('.modal input[name=book_id]').val( $(this).attr("data") );
                $('.modal #read_status').val( $(this).attr("data-read-status") );
                if( $(this).attr("data-read-status") == -2 ||  $(this).attr("data-read-status") == -1 ){
                    $('.modal input[name=read_start_time]').val( $(this).attr("data-start-time") );
                    $('.modal input[name=read_end_time]').val( $(this).attr("data-end-time") );
                }
                $('.modal #read_status').change();
                $('.modal').modal();
            });
        });

        $(".modal #read_status").change(function(){
            if( $(this).val() != -2 && $(this).val() != -1 ){//计划读,正在读
                $('.modal input[name=read_start_time]').parent().parent().hide();
                $('.modal input[name=read_end_time]').parent().parent().hide();
            }else{
                $('.modal input[name=read_start_time]').parent().parent().show();
                $('.modal input[name=read_end_time]').parent().parent().show();
            }
        });

        $(".modal .btn-primary").click(function(){
            var book_id = $('.modal input[name=book_id]').val();
            var read_status = $('.modal #read_status').val();
            var read_start_time = $('.modal input[name=read_start_time]').val();
            var read_end_time = $('.modal input[name=read_end_time]').val();
            $.ajax({
                url:'/library/edit/' + book_id,
                type:'POST',
                data:{
                    'read_start_time':read_start_time,
                    'read_end_time':read_end_time,
                    'read_status':read_status
                },
                dataType:'json',
                success:function(res){
                    alert(res.msg);
                    if(res.code == 200){
                        window.location.href = window.location.href;
                    }
                }
            });
        });

        $(".datepicker").datepicker( {
            format: 'yyyy-mm-dd',
            language: 'zh-CN',
            autoclose: true,
            todayHighlight: true
        } );
    }
};

$(document).ready(function(){
    library_index_ops.init();
});