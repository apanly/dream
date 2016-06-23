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

        $("#json_format .am-btn").click( function(){
            var js_source = $("#json_format textarea[name=content]").val().replace(/^\s+/, '');
            var tabsize = 4;//这里可选 1,2,4,8
            var tabchar = '';
            if (tabsize == 1) {
                tabchar = '\t';
            }
            var foramt_result = '';
            if (js_source && js_source.charAt(0) === '<') {
                foramt_result = json_format_ops.style_html(js_source, tabsize, tabchar, 80);
            } else {
                foramt_result =  json_format_ops.js_beautify(js_source, tabsize, tabchar);
            }
            $("#json_format textarea[name=content]").val(foramt_result);
            return false;
        } );
    }
};

$(document).ready(function(){
    tools_index_ops.init();
});