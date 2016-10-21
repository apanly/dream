;
var library_set_ops = {
    init:function(){
        this.eventBind();
        $("#pop_layer_wrap #read_status").change();
    },
    eventBind:function(){
        $("#pop_layer_wrap").off("change","#read_status").on("change","#read_status",function(){
            if( $(this).val() != -2 && $(this).val() != -1 ){//计划读,正在读
                $('#pop_layer_wrap .read_start').hide();
                $('#pop_layer_wrap .read_end').hide();
            }else{
                $('#pop_layer_wrap .read_start').show();
                $('#pop_layer_wrap .read_end').show();
            }
        });


        $("#pop_layer_wrap").off("click",".save").on("click",".save",function(){
            var book_id = $('#pop_layer_wrap input[name=book_id]').val();
            var read_status = $('#pop_layer_wrap #read_status').val();
            var read_start_time = $('#pop_layer_wrap input[name=read_start_time]').val();
            var read_end_time = $('#pop_layer_wrap input[name=read_end_time]').val();

            $.ajax({
                url:common_ops.buildAdminUrl('/library/set'),
                type:'POST',
                data:{
                    'id':book_id,
                    'read_start_time':read_start_time,
                    'read_end_time':read_end_time,
                    'read_status':read_status
                },
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
        });

        $("#pop_layer_wrap .datepicker").datepicker( {
            format: 'yyyy-mm-dd',
            language: 'zh-CN',
            autoclose: true,
            todayHighlight: true
        } );
    }
};

$(document).ready( function(){
    library_set_ops.init();
});