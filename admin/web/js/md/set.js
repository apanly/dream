;
var md_set_ops = {
    init:function(){
        this.initEditor();
        this.eventBind();
    },
    eventBind:function(){
        var that = this;
        $("#md_content_wrap .save").click(function(){
            var btn_target = $(this);
            if( btn_target.hasClass("disabled") ){
                $.alert("正在保存，请不要重复提交~~");
                return false;
            }

            var title_target = $("#md_content_wrap input[name=title]");
            var title_val = $.trim( title_target.val() );
            var content  = $.trim( that.edit_target.getMarkdown() );
            var status_target = $("#status");
            var status_val = $.trim( status_target.val() );

            if( title_val.length <= 0){
                title_target.tip("请输入博文标题~~");
                return false;
            }

            if( content.length <= 10){
                $.alert("请输入更多点博文内容~~");
                return false;
            }

            btn_target.addClass("disabled");

            var data = {
                id: $.trim($("#md_content_wrap input[name=docs_id]").val() ),
                title:title_val,
                content:content,
                status:status_val
            };
            $.ajax({
                url:'/md/set',
                data:data,
                type:'POST',
                dataType:'json',
                success:function(res){
                    btn_target.removeClass("disabled");
                    var callback = {};
                    if(res.code == 200){
                        callback = {
                            ok:function(){
                                window.location.href = "/md/set/"+res.data.id;
                            },
                            cancel:function(){
                                window.location.href = "/md/set/"+res.data.id;
                            }
                        }
                    }
                    $.alert(res.msg,callback);
                }
            });
        });
    },
    initEditor:function(){
        this.edit_target = editormd({
            id : "editormd",
            width  : "96%",
            height : 640,
            //syncScrolling : "single",
            path : $("#hide_wrap input[name=lib_path]").val() + "/",
            // theme : "dark",
            // previewTheme : "dark",
            // editorTheme : "pastel-on-dark"
            saveHTMLToTextarea : true,    // 保存 HTML 到 Textarea
            imageUpload : true,
            imageFormats : ["jpg", "jpeg", "gif", "png", "bmp"],
            imageUploadURL : common_ops.buildAdminUrl("/upload/editor-md"),
            onload : function() {
                //console.log('onload', this);
                //this.fullscreen();
                //this.unwatch();
                //this.watch().fullscreen();

                //this.setMarkdown("#PHP");
                //this.width("100%");
                //this.height(480);
                //this.resize("100%", 640);
            }

        });
    }
};

$(document).ready( function(){
    md_set_ops.init();
});
