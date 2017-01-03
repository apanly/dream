;
var md_set_ops = {
    init:function(){
        this.initEditor();
        this.eventBind();
    },
    eventBind:function(){

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
                console.log('onload', this);
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
