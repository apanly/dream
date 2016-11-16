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

        $("#strlen .am-btn").click( function(){
            var content = $("#strlen textarea[name=content]").val();
            $("#strlen .strlen_tip").html("共计：" + content.length + "个字符");
        });

        $("#strlen textarea[name=content]").keydown( function(){
            $("#strlen .am-btn").click();
        } );

        $("#strlen textarea[name=content]").keyup( function(){
            $("#strlen .am-btn").click();
        } );

        $("#json_format").on("input","textarea[name=content]",function() {
            $("#json_format .am-btn").click();
        });
        $("#json_format .am-btn").click( function(){
            var js_source = $("#json_format textarea[name=content]").val().replace(/^\s+/, '');
            try{
                js_source = eval('(' + js_source + ')');
                $("#json-renderer").JSONView(js_source);
            }catch( e ){
                $("#json-renderer").html( '错误信息，' + e.name + "：" + e.message );
            }

            return false;
        } );
    }
};

$(document).ready(function(){
    tools_index_ops.init();
});