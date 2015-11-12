;
var tools_index_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){
        $("#gene_password  .do_gene").click(function(){
            var options = [];
            var pass_length = $("#pass_length").val();

            $("#gene_password input[name='option[]']").each(function () {
                if( $(this).prop("checked") ){
                    options.push( $(this).val() );
                }
            });

            if( options.length == 0){
                alert("请选择所用字符!");
                return false;
            }

            $.ajax({
                url:common_ops.getUrlPrefix() + "/tools/index",
                type:'POST',
                data:{options:options,pass_length:pass_length},
                dataType:'json',
                success:function(res){
                    if( res.code == 200 ){
                        $("#result").val(res.data.pwd);
                    }else{
                        alert(res.msg);
                    }
                }
            })
        });
    }
};

$(document).ready(function(){
    tools_index_ops.init();
});